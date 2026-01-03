<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Destinasi;
use App\Models\PaketWisata;
use App\Models\Promo;
use App\Models\PromoUsage;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class OrderController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Show checkout page
     */
    public function checkout(PaketWisata $paketWisata): View
    {
        return view('order.paket-checkout', compact('paketWisata'));
    }

    /**
     * Show destination checkout page
     */
    public function checkoutDestinasi(Destinasi $destinasi): View
    {
        return view('order.destinasi-checkout', compact('destinasi'));
    }

    /**
     * Store new order
     */
    public function store(Request $request, PaketWisata $paketWisata): JsonResponse
    {
        $validated = $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'tanggal_berangkat' => 'required|date|after:today',
            'jumlah_peserta' => 'required|integer|min:1|max:50',
            'catatan' => 'nullable|string|max:500',
        ]);

        $totalHarga = $paketWisata->harga * $validated['jumlah_peserta'];
        
        // Promo Logic
        $discountAmount = 0;
        $promoUsage = null;

        if ($request->filled('promo_code')) {
            $promo = Promo::where('code', $request->promo_code)->first();
            if ($promo && $promo->isValid() && $promo->isApplicableTo('paket')) {
                $promoUsage = PromoUsage::where('user_id', Auth::id())
                    ->where('promo_id', $promo->id)
                    ->where(function($q) {
                        $q->where('status', 'claimed')
                          ->orWhereNull('booking_id');
                    })
                    ->first();
                
                if ($promoUsage) {
                    $discountAmount = $promo->calculateDiscount($totalHarga);
                }
            }
        }

        $finalPrice = max(1, $totalHarga - $discountAmount);

        if ($finalPrice < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Total harga tidak valid (minimal Rp 1).',
            ], 400);
        }

        $orderId = Order::generateOrderId();

        // Check stok
        if ($paketWisata->stok < $validated['jumlah_peserta']) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi.',
            ], 400);
        }

        $order = Order::create([
            'order_id' => $orderId,
            'user_id' => Auth::id(),
            'paket_wisata_id' => $paketWisata->id,
            'nama_pemesan' => $validated['nama_pemesan'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'tanggal_berangkat' => $validated['tanggal_berangkat'],
            'jumlah_peserta' => $validated['jumlah_peserta'],
            'total_harga' => $finalPrice,
            'catatan' => $validated['catatan'],
            'status' => 'pending',
        ]);

        // Mark promo as used
        if ($promoUsage) {
            $promoUsage->update([
                'status' => 'used',
                'booking_type' => 'App\Models\Order',
                'booking_id' => $order->id,
                'discount_amount' => $discountAmount,
            ]);
        }

        // Kurangi stok
        $paketWisata->decrement('stok', $validated['jumlah_peserta']);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $finalPrice,
            ],
            'customer_details' => [
                'first_name' => $validated['nama_pemesan'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ],
            'item_details' => [
                [
                    'id' => $paketWisata->id,
                    'price' => (int) $paketWisata->harga,
                    'quantity' => $validated['jumlah_peserta'],
                    'name' => substr($paketWisata->nama_paket, 0, 50),
                ]
            ],
        ];

        // Adjust item price if discount applied (Midtrans checks sum(items) == gross_amount)
        if ($discountAmount > 0) {
            // Add discount as a negative item item or adjust item price?
            // Midtrans supports negative value item for discount
            $params['item_details'][] = [
                'id' => 'DISCOUNT',
                'price' => -(int) $discountAmount,
                'quantity' => 1,
                'name' => 'Promo Discount',
            ];
        }

        try {
            $snapToken = $this->midtransService->createTransaction($params);
            $order->update(['snap_token' => $snapToken]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ]);
        } catch (\Exception $e) {
            $order->update(['status' => 'cancelled']);
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store new destination order
     */
    public function storeDestinasi(Request $request, Destinasi $destinasi): JsonResponse
    {
        $validated = $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'tanggal_berangkat' => 'required|date|after:today',
            'jumlah_peserta' => 'required|integer|min:1|max:50',
            'catatan' => 'nullable|string|max:500',
        ]);

        $totalHarga = $destinasi->harga * $validated['jumlah_peserta'];
        
        if ($totalHarga < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Total harga tidak valid (minimal Rp 1).',
            ], 400);
        }

        $orderId = Order::generateOrderId();

        // Check stok
        if ($destinasi->stok < $validated['jumlah_peserta']) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi.',
            ], 400);
        }

        $order = Order::create([
            'order_id' => $orderId,
            'user_id' => Auth::id(),
            'destinasi_id' => $destinasi->id,
            'nama_pemesan' => $validated['nama_pemesan'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'tanggal_berangkat' => $validated['tanggal_berangkat'],
            'jumlah_peserta' => $validated['jumlah_peserta'],
            'total_harga' => $totalHarga,
            'catatan' => $validated['catatan'],
            'status' => 'pending',
        ]);

        // Kurangi stok
        $destinasi->decrement('stok', $validated['jumlah_peserta']);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $totalHarga,
            ],
            'customer_details' => [
                'first_name' => $validated['nama_pemesan'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ],
            'item_details' => [
                [
                    'id' => 'DST-' . $destinasi->id,
                    'price' => (int) $destinasi->harga,
                    'quantity' => $validated['jumlah_peserta'],
                    'name' => substr($destinasi->nama_destinasi, 0, 50),
                ]
            ],
        ];

        try {
            $snapToken = $this->midtransService->createTransaction($params);
            $order->update(['snap_token' => $snapToken]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ]);
        } catch (\Exception $e) {
            $order->update(['status' => 'cancelled']);
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show order success page
     */
    public function success(Request $request): View
    {
        $orderId = $request->query('order_id');
        
        // Active Status Check (Workaround for Localhost/No Callback)
        try {
            $status = $this->midtransService->getTransactionStatus($orderId);
            $transactionStatus = $status->transaction_status;
            $paymentType = $status->payment_type;
            
            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                // Check Order
                $order = Order::where('order_id', $orderId)->first();
                if ($order && $order->status !== 'paid') {
                    $order->update([
                        'status' => 'paid',
                        'payment_type' => $paymentType,
                        'paid_at' => now(),
                    ]);
                }
                
                // Check Hotel
                $hotelBooking = \App\Models\HotelBooking::where('kode_booking', $orderId)->first();
                if ($hotelBooking && $hotelBooking->payment_status !== 'paid') {
                    $hotelBooking->update([
                        'payment_status' => 'paid',
                        'status_booking' => 'confirmed'
                    ]);
                }

                // Check Ticket
                $ticketBooking = \App\Models\TicketBooking::where('kode_booking', $orderId)->first();
                if ($ticketBooking && $ticketBooking->payment_status !== 'paid') {
                    $ticketBooking->update([
                        'payment_status' => 'paid',
                        'status_booking' => 'confirmed'
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Ignore error if check fails, fallback to existing status
            Log::warning('Manual status check failed: ' . $e->getMessage());
        }

        // Determine which view to show based on order type
        if (str_starts_with($orderId, 'HTL-')) {
            $booking = \App\Models\HotelBooking::with('hotel')->where('kode_booking', $orderId)->firstOrFail();
            // Standardize variable name for view if possible, or handle checking in view
            return view('order.success', ['order' => $booking, 'type' => 'hotel']);
        }
        
        if (str_starts_with($orderId, 'TKT-')) {
            $booking = \App\Models\TicketBooking::with('ticket')->where('kode_booking', $orderId)->firstOrFail();
            return view('order.success', ['order' => $booking, 'type' => 'ticket']);
        }

        $order = Order::with('paketWisata')->where('order_id', $orderId)->firstOrFail();
        return view('order.success', ['order' => $order, 'type' => 'paket']);
    }

    /**
     * Show order history
     */
    public function history(): View
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['paketWisata', 'review'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('order.history', compact('orders'));
    }

    /**
     * Show order detail
     */
    public function show(Order $order): View
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('paketWisata');
        return view('order.show', compact('order'));
    }

    /**
     * Handle Midtrans callback
     */
    public function callback(Request $request): JsonResponse
    {
        Log::info('Midtrans callback received', [
            'order_id' => $request->order_id,
            'transaction_status' => $request->transaction_status,
            'payment_type' => $request->payment_type,
            'gross_amount' => $request->gross_amount,
        ]);

        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            Log::warning('Invalid signature in Midtrans callback', ['order_id' => $request->order_id]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $paymentType = $request->payment_type;
        $orderId = $request->order_id;

        // Check for Hotel Booking
        if (str_starts_with($orderId, 'HTL-')) {
            $booking = \App\Models\HotelBooking::where('kode_booking', $orderId)->first();
            if ($booking) {
                if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                    $booking->update([
                        'payment_status' => 'paid',
                        'status_booking' => 'confirmed' // Or whatever confirmed status is used
                    ]);
                } elseif ($transactionStatus == 'expire') {
                    $booking->update(['payment_status' => 'expired', 'status_booking' => 'cancelled']);
                } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny') {
                    $booking->update(['payment_status' => 'failed', 'status_booking' => 'cancelled']);
                }
                return response()->json(['message' => 'Hotel booking updated']);
            }
        }
        
        // Check for Ticket Booking
        if (str_starts_with($orderId, 'TKT-')) {
            $booking = \App\Models\TicketBooking::where('kode_booking', $orderId)->first();
            if ($booking) {
                if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                    $booking->update([
                        'payment_status' => 'paid',
                        'status_booking' => 'confirmed'
                    ]);
                } elseif ($transactionStatus == 'expire') {
                    $booking->update(['payment_status' => 'expired', 'status_booking' => 'cancelled']);
                } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny') {
                    $booking->update(['payment_status' => 'failed', 'status_booking' => 'cancelled']);
                }
                return response()->json(['message' => 'Ticket booking updated']);
            }
        }

        // Default: Order (Paket / Destinasi)
        $order = Order::where('order_id', $orderId)->first();

        if (!$order) {
            Log::error('Order not found in Midtrans callback', ['order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $order->update([
                'status' => 'paid',
                'payment_type' => $paymentType,
                'paid_at' => now(),
            ]);
            Log::info('Order marked as paid', ['order_id' => $orderId]);
        } elseif ($transactionStatus == 'pending') {
            $order->update(['status' => 'pending', 'payment_type' => $paymentType]);
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'cancel') {
            $order->update(['status' => 'cancelled']);
        } elseif ($transactionStatus == 'expire') {
            $order->update(['status' => 'expired']);
        }

        return response()->json(['message' => 'OK']);
    }
}

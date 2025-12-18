<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaketWisata;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('paket.order.checkout', compact('paketWisata'));
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
        $orderId = Order::generateOrderId();

        $order = Order::create([
            'order_id' => $orderId,
            'user_id' => Auth::id(),
            'paket_wisata_id' => $paketWisata->id,
            'nama_pemesan' => $validated['nama_pemesan'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'tanggal_berangkat' => $validated['tanggal_berangkat'],
            'jumlah_peserta' => $validated['jumlah_peserta'],
            'total_harga' => $totalHarga,
            'catatan' => $validated['catatan'],
            'status' => 'pending',
        ]);

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
                    'id' => $paketWisata->id,
                    'price' => (int) $paketWisata->harga,
                    'quantity' => $validated['jumlah_peserta'],
                    'name' => substr($paketWisata->nama_paket, 0, 50),
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
        $order = Order::where('order_id', $orderId)->firstOrFail();

        return view('paket.order.success', compact('order'));
    }

    /**
     * Show order history
     */
    public function history(): View
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('paketWisata')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('paket.order.history', compact('orders'));
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
        return view('paket.order.show', compact('order'));
    }

    /**
     * Handle Midtrans callback
     */
    public function callback(Request $request): JsonResponse
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('order_id', $request->order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $request->transaction_status;
        $paymentType = $request->payment_type;

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $order->update([
                'status' => 'paid',
                'payment_type' => $paymentType,
                'paid_at' => now(),
            ]);
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

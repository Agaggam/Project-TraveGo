<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelBooking;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HotelBookingController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();
        $bookings = HotelBooking::with(['hotel', 'user'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Data booking hotel berhasil diambil',
            'data' => $bookings
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|exists:hotels,id',
            'tanggal_checkin' => 'required|date|after:today',
            'tanggal_checkout' => 'required|date|after:tanggal_checkin',
            'jumlah_kamar' => 'required|integer|min:1',
            'nama_tamu' => 'required|string|max:255',
            'email_tamu' => 'required|email',
            'telepon_tamu' => 'required|string|max:20',
            'nomor_identitas' => 'required|string|max:50',
            'tipe_identitas' => 'required|in:KTP,Paspor,SIM',
            'permintaan_khusus' => 'nullable|string|max:500',
            'breakfast_included' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $hotel = Hotel::findOrFail($request->hotel_id);

        // Check availability
        if ($hotel->kamar_tersedia < $request->jumlah_kamar) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kamar tidak tersedia dalam jumlah yang diminta'
            ], 400);
        }

        // Calculate number of nights
        $checkin = \Carbon\Carbon::parse($request->tanggal_checkin);
        $checkout = \Carbon\Carbon::parse($request->tanggal_checkout);
        $jumlahMalam = $checkin->diffInDays($checkout);

        $totalHarga = $hotel->harga_per_malam * $jumlahMalam * $request->jumlah_kamar;

        DB::beginTransaction();
        try {
            // Create booking
            $booking = HotelBooking::create([
                'user_id' => Auth::id(),
                'hotel_id' => $request->hotel_id,
                'tanggal_checkin' => $request->tanggal_checkin,
                'tanggal_checkout' => $request->tanggal_checkout,
                'jumlah_kamar' => $request->jumlah_kamar,
                'jumlah_malam' => $jumlahMalam,
                'total_harga' => $totalHarga,
                'status_booking' => 'pending',
                'payment_status' => 'unpaid',
                'nama_tamu' => $request->nama_tamu,
                'email_tamu' => $request->email_tamu,
                'telepon_tamu' => $request->telepon_tamu,
                'nomor_identitas' => $request->nomor_identitas,
                'tipe_identitas' => $request->tipe_identitas,
                'permintaan_khusus' => $request->permintaan_khusus,
                'breakfast_included' => $request->breakfast_included ?? false,
                'tipe_kamar' => $hotel->tipe_kamar,
            ]);

            // Reduce available rooms
            $hotel->decrement('kamar_tersedia', $request->jumlah_kamar);

            // Create Midtrans payment
            $paymentData = [
                'order_id' => 'HOTEL-' . $booking->id . '-' . time(),
                'gross_amount' => $totalHarga,
                'customer_details' => [
                    'first_name' => $request->nama_tamu,
                    'email' => $request->email_tamu,
                    'phone' => $request->telepon_tamu,
                ],
                'item_details' => [
                    [
                        'id' => $hotel->id,
                        'price' => $hotel->harga_per_malam * $jumlahMalam,
                        'quantity' => $request->jumlah_kamar,
                        'name' => $hotel->nama_hotel . ' - ' . $jumlahMalam . ' malam',
                    ]
                ]
            ];

            $paymentUrl = $this->midtransService->createTransaction($paymentData);

            $booking->update([
                'midtrans_order_id' => $paymentData['order_id'],
                'payment_url' => $paymentUrl,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Booking hotel berhasil dibuat',
                'data' => [
                    'booking' => $booking->load('hotel'),
                    'payment_url' => $paymentUrl,
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat membuat booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        $user = Auth::user();
        $booking = HotelBooking::with(['hotel', 'user'])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$booking) {
            return response()->json([
                'status' => 'error',
                'message' => 'Booking tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data booking berhasil diambil',
            'data' => $booking
        ]);
    }

    public function cancel($id): JsonResponse
    {
        $user = Auth::user();
        $booking = HotelBooking::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status_booking', 'pending')
            ->first();

        if (!$booking) {
            return response()->json([
                'status' => 'error',
                'message' => 'Booking tidak ditemukan atau tidak dapat dibatalkan'
            ], 404);
        }

        DB::beginTransaction();
        try {
            // Restore room availability
            $booking->hotel->increment('kamar_tersedia', $booking->jumlah_kamar);

            // Update booking status
            $booking->update([
                'status_booking' => 'cancelled',
                'payment_status' => 'refunded'
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Booking berhasil dibatalkan'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat membatalkan booking'
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketBooking;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TicketBookingController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();
        $bookings = TicketBooking::with(['ticket', 'user'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Data booking tiket berhasil diambil',
            'data' => $bookings
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|exists:tickets,id',
            'tanggal_keberangkatan' => 'required|date|after:today',
            'jumlah_tiket' => 'required|integer|min:1',
            'nama_penumpang' => 'required|string|max:255',
            'email_penumpang' => 'required|email',
            'telepon_penumpang' => 'required|string|max:20',
            'nomor_identitas' => 'required|string|max:50',
            'tipe_identitas' => 'required|in:KTP,Paspor,SIM',
            'permintaan_khusus' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $ticket = Ticket::findOrFail($request->ticket_id);

        // Check availability
        if ($ticket->kapasitas_tersedia < $request->jumlah_tiket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tiket tidak tersedia dalam jumlah yang diminta'
            ], 400);
        }

        $totalHarga = $ticket->harga * $request->jumlah_tiket;

        DB::beginTransaction();
        try {
            // Create booking
            $booking = TicketBooking::create([
                'user_id' => Auth::id(),
                'ticket_id' => $request->ticket_id,
                'tanggal_keberangkatan' => $request->tanggal_keberangkatan,
                'jumlah_tiket' => $request->jumlah_tiket,
                'total_harga' => $totalHarga,
                'status_booking' => 'pending',
                'payment_status' => 'unpaid',
                'nama_penumpang' => $request->nama_penumpang,
                'email_penumpang' => $request->email_penumpang,
                'telepon_penumpang' => $request->telepon_penumpang,
                'nomor_identitas' => $request->nomor_identitas,
                'tipe_identitas' => $request->tipe_identitas,
                'permintaan_khusus' => $request->permintaan_khusus,
                'tipe_transportasi' => $ticket->tipe_transportasi,
                'kelas' => $ticket->kelas,
            ]);

            // Reduce available capacity
            $ticket->decrement('kapasitas_tersedia', $request->jumlah_tiket);

            // Create Midtrans payment
            $paymentData = [
                'order_id' => 'TICKET-' . $booking->id . '-' . time(),
                'gross_amount' => $totalHarga,
                'customer_details' => [
                    'first_name' => $request->nama_penumpang,
                    'email' => $request->email_penumpang,
                    'phone' => $request->telepon_penumpang,
                ],
                'item_details' => [
                    [
                        'id' => $ticket->id,
                        'price' => $ticket->harga,
                        'quantity' => $request->jumlah_tiket,
                        'name' => $ticket->nama_transportasi . ' - ' . $ticket->asal . ' ke ' . $ticket->tujuan,
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
                'message' => 'Booking tiket berhasil dibuat',
                'data' => [
                    'booking' => $booking->load('ticket'),
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
        $booking = TicketBooking::with(['ticket', 'user'])
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
        $booking = TicketBooking::where('id', $id)
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
            // Restore ticket availability
            $booking->ticket->increment('kapasitas_tersedia', $booking->jumlah_tiket);

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

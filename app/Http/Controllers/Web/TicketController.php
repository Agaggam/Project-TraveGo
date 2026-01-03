<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketBooking;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Display a listing of available tickets.
     */
    public function index(Request $request)
    {
        $query = Ticket::where('aktif', true)
            ->where('tersedia', '>', 0);

        // Filter by transportation type
        if ($request->filled('jenis_transportasi')) {
            $query->where('jenis_transportasi', $request->jenis_transportasi);
        }

        // Filter by class
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        // Price range
        if ($request->filled('min_price')) {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('harga', '<=', $request->max_price);
        }

        // Search by name or code
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_transportasi', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('kode_transportasi', 'LIKE', '%' . $request->search . '%');
            });
        }

        $tickets = $query->orderBy('waktu_berangkat')
                        ->orderBy('harga')
                        ->paginate(15);

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket)
    {
        if (!$ticket->aktif) {
            abort(404);
        }
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the booking form for the specified ticket.
     */
    public function booking(Ticket $ticket)
    {
        if (!$ticket->aktif) {
            abort(404);
        }

        if ($ticket->tersedia <= 0) {
            return redirect()->back()->with('error', 'Tiket tidak tersedia');
        }

        return view('tickets.booking', compact('ticket'));
    }

    /**
     * Search tickets by route and date.
     */
    public function search(Request $request)
    {
        $tickets = collect();

        if ($request->filled('asal') && $request->filled('tujuan')) {
            $query = Ticket::where('aktif', true)
                ->where('tersedia', '>', 0)
                ->where('asal', 'LIKE', '%' . $request->asal . '%')
                ->where('tujuan', 'LIKE', '%' . $request->tujuan . '%');

            if ($request->filled('tanggal')) {
                $query->whereDate('waktu_berangkat', $request->tanggal);
            }

            if ($request->filled('jenis_transportasi')) {
                $query->where('jenis_transportasi', $request->jenis_transportasi);
            }

            $tickets = $query->orderBy('waktu_berangkat')
                           ->orderBy('harga')
                           ->get();
        }

        return view('tickets.search', compact('tickets'));
    }

    /**
     * Store a new ticket booking.
     */
    public function storeBooking(Request $request, Ticket $ticket)
    {
        if (!$ticket->aktif) {
            abort(404);
        }

        $request->validate([
            'jumlah_tiket' => 'required|integer|min:1',
            'nama_penumpang' => 'required|string|max:255',
            'email_penumpang' => 'required|email',
            'telepon_penumpang' => 'required|string|max:20',
            'nomor_identitas' => 'required|string|max:50',
            'tipe_identitas' => 'required|in:KTP,Paspor,SIM',
        ]);

        // Check availability
        if ($ticket->tersedia < $request->jumlah_tiket) {
            return redirect()->back()
                ->with('error', 'Tiket tidak tersedia dalam jumlah yang diminta')
                ->withInput();
        }

        $totalHarga = $ticket->harga * $request->jumlah_tiket;
        
        if ($totalHarga < 1) {
             return redirect()->back()
                ->with('error', 'Total harga tidak valid (minimal Rp 1)')
                ->withInput();
        }

        $kodeBooking = 'TKT-' . time() . '-' . Str::random(5);

        DB::beginTransaction();
        try {
            // Create booking
            $booking = TicketBooking::create([
                'user_id' => Auth::id(),
                'ticket_id' => $ticket->id,
                'jumlah_tiket' => $request->jumlah_tiket,
                'total_harga' => $totalHarga,
                'status_booking' => 'pending',
                'payment_status' => 'unpaid',
                'nama_penumpang' => $request->nama_penumpang,
                'email_penumpang' => $request->email_penumpang,
                'telepon_penumpang' => $request->telepon_penumpang,
                'nomor_identitas' => $request->nomor_identitas,
                'tipe_identitas' => $request->tipe_identitas,
                'kode_booking' => $kodeBooking,
            ]);

            // Reduce available tickets
            $ticket->decrement('tersedia', $request->jumlah_tiket);

            // Create Midtrans transaction
            $params = [
                'transaction_details' => [
                    'order_id' => $kodeBooking,
                    'gross_amount' => (int) $totalHarga,
                ],
                'customer_details' => [
                    'first_name' => $request->nama_penumpang,
                    'email' => $request->email_penumpang,
                    'phone' => $request->telepon_penumpang,
                ],
                'item_details' => [
                    [
                        'id' => 'ticket-' . $ticket->id,
                        'price' => (int) $ticket->harga,
                        'quantity' => $request->jumlah_tiket,
                        'name' => substr($ticket->nama_transportasi . ' (' . $ticket->asal . '-' . $ticket->tujuan . ')', 0, 50),
                    ]
                ],
            ];

            try {
                $snapToken = $this->midtransService->createTransaction($params);
                $booking->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                \Log::error('Midtrans error: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('booking.tiket.show', $booking->id)
                ->with('success', 'Booking tiket berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membuat booking: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display user's ticket bookings.
     */
    public function myBookings()
    {
        $bookings = TicketBooking::with(['ticket', 'review'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('order.ticket.history', compact('bookings'));
    }

    /**
     * Display the specified booking.
     */
    public function showBooking($id)
    {
        $booking = TicketBooking::with('ticket')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('order.ticket.show', compact('booking'));
    }

    /**
     * Cancel a ticket booking.
     */
    public function cancelBooking($id)
    {
        $booking = TicketBooking::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status_booking', 'pending')
            ->firstOrFail();

        DB::beginTransaction();
        try {
            // Restore ticket availability
            $booking->ticket->increment('tersedia', $booking->jumlah_tiket);

            // Update booking status
            $booking->update([
                'status_booking' => 'cancelled',
                'payment_status' => 'refunded'
            ]);

            DB::commit();

            return redirect()->route('booking.tiket')
                ->with('success', 'Booking berhasil dibatalkan');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membatalkan booking');
        }
    }
}

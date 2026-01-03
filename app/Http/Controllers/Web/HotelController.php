<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelBooking;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index(Request $request)
    {
        $query = Hotel::available();

        // Filter by location
        if ($request->filled('location')) {
            $query->where('lokasi', 'LIKE', '%' . $request->location . '%');
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        // Filter by facilities
        if ($request->filled('facilities')) {
            $facilities = is_array($request->facilities) ? $request->facilities : [$request->facilities];
            foreach ($facilities as $facility) {
                $query->where($facility, true);
            }
        }

        // Price range
        if ($request->filled('min_price')) {
            $query->where('harga_per_malam', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('harga_per_malam', '<=', $request->max_price);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_hotel', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'LIKE', '%' . $request->search . '%');
            });
        }

        $hotels = $query->orderBy('rating', 'desc')
                        ->orderBy('harga_per_malam')
                        ->paginate(12);

        return view('hotels.index', compact('hotels'));
    }

    public function show(Hotel $hotel)
    {
        return view('hotels.show', compact('hotel'));
    }

    public function booking(Hotel $hotel)
    {
        $totalAvailable = $hotel->kamar_standard + $hotel->kamar_deluxe + $hotel->kamar_suite;
        if ($totalAvailable <= 0 && $hotel->kamar_tersedia <= 0) {
            return redirect()->back()->with('error', 'Kamar tidak tersedia');
        }

        return view('hotels.booking', compact('hotel'));
    }

    public function search(Request $request)
    {
        $hotels = collect();

        if ($request->filled('location')) {
            $query = Hotel::available()
                ->where('lokasi', 'LIKE', '%' . $request->location . '%');

            $hotels = $query->orderBy('rating', 'desc')->get();
        }

        return view('hotels.search', compact('hotels'));
    }

    /**
     * Store a new hotel booking with Midtrans payment.
     */
    public function storeBooking(Request $request, Hotel $hotel)
    {
        $request->validate([
            'tipe_kamar' => 'required|in:standard,deluxe,suite',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'jumlah_tamu' => 'required|integer|min:1',
            'nama_pemesan' => 'required|string|max:255',
            'email_pemesan' => 'required|email',
            'telepon_pemesan' => 'required|string|max:20',
        ]);
        $tipeKamar = $request->tipe_kamar;

        // Check availability by room type
        $available = $hotel->getAvailableByType($tipeKamar);
        if ($available <= 0) {
            return redirect()->back()
                ->with('error', 'Maaf, kamar ' . ucfirst($tipeKamar) . ' tidak tersedia.')
                ->withInput();
        }

        // Calculate nights and price
        $checkIn = new \DateTime($request->check_in);
        $checkOut = new \DateTime($request->check_out);
        $nights = $checkIn->diff($checkOut)->days;
        $pricePerNight = $hotel->getPriceByType($tipeKamar);
        $totalHarga = $pricePerNight * $nights;
        
        if ($totalHarga < 1) {
             return redirect()->back()
                ->with('error', 'Total harga tidak valid (pastikan tanggal check-out benar)')
                ->withInput();
        }

        $kodeBooking = 'HTL-' . strtoupper(Str::random(10));

        DB::beginTransaction();
        try {
            $booking = HotelBooking::create([
                'user_id' => Auth::id(),
                'hotel_id' => $hotel->id,
                'tanggal_checkin' => $request->check_in,
                'tanggal_checkout' => $request->check_out,
                'total_harga' => $totalHarga,
                'jumlah_kamar' => 1,
                'jumlah_malam' => $nights,
                'status_booking' => 'pending',
                'payment_status' => 'unpaid',
                'nama_tamu' => $request->nama_pemesan,
                'email_tamu' => $request->email_pemesan,
                'telepon_tamu' => $request->telepon_pemesan,
                'tipe_kamar' => $tipeKamar,
                'kode_booking' => $kodeBooking,
            ]);

            // Reduce room availability by type
            $hotel->decrementRoomByType($tipeKamar);

            // Create Midtrans transaction
            $params = [
                'transaction_details' => [
                    'order_id' => $kodeBooking,
                    'gross_amount' => (int) $totalHarga,
                ],
                'customer_details' => [
                    'first_name' => $request->nama_pemesan,
                    'email' => $request->email_pemesan,
                    'phone' => $request->telepon_pemesan,
                ],
                'item_details' => [
                    [
                        'id' => 'hotel-' . $hotel->id,
                        'price' => (int) $pricePerNight,
                        'quantity' => $nights,
                        'name' => substr($hotel->nama_hotel . ' - ' . ucfirst($tipeKamar), 0, 50),
                    ]
                ],
            ];

            try {
                $snapToken = $this->midtransService->createTransaction($params);
                $booking->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                // Log error but don't fail the booking
                \Log::error('Midtrans error: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('booking.hotel.show', $booking->id)
                ->with('success', 'Reservasi berhasil dibuat! Silakan selesaikan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display user's hotel bookings.
     */
    public function myBookings()
    {
        $bookings = HotelBooking::with(['hotel', 'review'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('order.hotel.history', compact('bookings'));
    }

    /**
     * Display the specified booking.
     */
    public function showBooking($id)
    {
        $booking = HotelBooking::with('hotel')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('order.hotel.show', compact('booking'));
    }

    /**
     * Cancel a hotel booking.
     */
    public function cancelBooking($id)
    {
        $booking = HotelBooking::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status_booking', 'pending')
            ->firstOrFail();

        DB::beginTransaction();
        try {
            // Restore room availability by type
            $booking->hotel->incrementRoomByType($booking->tipe_kamar ?? 'standard');

            // Update status
            $booking->update([
                'status_booking' => 'cancelled',
                'payment_status' => 'refunded'
            ]);

            DB::commit();

            return redirect()->route('booking.hotel')
                ->with('success', 'Reservasi berhasil dibatalkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal membatalkan reservasi.');
        }
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\TicketBooking;
use App\Models\HotelBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ETicketController extends Controller
{
    /**
     * Generate QR Code URL using Google Charts API.
     */
    private function generateQrCodeUrl(string $data, int $size = 200): string
    {
        return 'https://chart.googleapis.com/chart?chs=' . $size . 'x' . $size . '&cht=qr&chl=' . urlencode($data) . '&choe=UTF-8';
    }

    /**
     * Generate unique e-ticket token if not exists.
     */
    private function ensureETicketToken($booking): string
    {
        if (!$booking->eticket_token) {
            $token = Str::uuid()->toString();
            $booking->update(['eticket_token' => $token]);
            return $token;
        }
        return $booking->eticket_token;
    }

    /**
     * Display e-ticket for order (paket/destinasi).
     */
    public function showOrder(Order $order)
    {
        // Verify ownership
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Only show for paid orders
        if ($order->status !== 'paid') {
            return redirect()->route('order.show', $order)->with('error', 'E-Ticket hanya tersedia untuk pesanan yang sudah dibayar.');
        }

        $token = $this->ensureETicketToken($order);
        $qrData = route('eticket.verify', ['type' => 'order', 'token' => $token]);
        $qrCodeUrl = $this->generateQrCodeUrl($qrData, 250);

        return view('eticket.order', compact('order', 'qrCodeUrl', 'token'));
    }

    /**
     * Display e-ticket for ticket booking.
     */
    public function showTicket(TicketBooking $booking)
    {
        // Verify ownership
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Only show for paid bookings
        if ($booking->payment_status !== 'paid') {
            return redirect()->route('booking.tiket.show', $booking)->with('error', 'E-Ticket hanya tersedia untuk booking yang sudah dibayar.');
        }

        $token = $this->ensureETicketToken($booking);
        $qrData = route('eticket.verify', ['type' => 'ticket', 'token' => $token]);
        $qrCodeUrl = $this->generateQrCodeUrl($qrData, 250);

        return view('eticket.ticket', compact('booking', 'qrCodeUrl', 'token'));
    }

    /**
     * Display e-ticket for hotel booking.
     */
    public function showHotel(HotelBooking $booking)
    {
        // Verify ownership
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Only show for paid bookings
        if ($booking->payment_status !== 'paid') {
            return redirect()->route('booking.hotel.show', $booking)->with('error', 'E-Ticket hanya tersedia untuk booking yang sudah dibayar.');
        }

        $token = $this->ensureETicketToken($booking);
        $qrData = route('eticket.verify', ['type' => 'hotel', 'token' => $token]);
        $qrCodeUrl = $this->generateQrCodeUrl($qrData, 250);

        return view('eticket.hotel', compact('booking', 'qrCodeUrl', 'token'));
    }

    /**
     * Verify e-ticket by scanning QR code.
     */
    public function verify(Request $request)
    {
        $type = $request->type;
        $token = $request->token;

        $booking = null;
        $bookingType = '';

        switch ($type) {
            case 'order':
                $booking = Order::where('eticket_token', $token)->first();
                $bookingType = 'Pesanan Wisata';
                break;
            case 'ticket':
                $booking = TicketBooking::with('ticket')->where('eticket_token', $token)->first();
                $bookingType = 'Tiket Transportasi';
                break;
            case 'hotel':
                $booking = HotelBooking::with('hotel')->where('eticket_token', $token)->first();
                $bookingType = 'Reservasi Hotel';
                break;
        }

        if (!$booking) {
            return view('eticket.verify', [
                'valid' => false,
                'message' => 'E-Ticket tidak ditemukan atau tidak valid.'
            ]);
        }

        return view('eticket.verify', [
            'valid' => true,
            'booking' => $booking,
            'bookingType' => $bookingType,
            'type' => $type
        ]);
    }
}

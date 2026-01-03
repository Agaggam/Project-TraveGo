<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaketWisata;
use App\Models\Destinasi;
use App\Models\Ticket;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\TicketBooking;
use App\Models\HotelBooking;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // Cache statistik selama 5 menit untuk performa lebih baik
        $stats = Cache::remember('admin_dashboard_stats', 300, function () {
            return [
                'totalPaket' => PaketWisata::count(),
                'totalDestinasi' => Destinasi::count(),
                'totalTicket' => Ticket::count(),
                'totalHotel' => Hotel::count(),
                'totalUser' => User::where('role', 'user')->count(),
                'totalOrders' => Order::where('status', 'success')->count(),
                'totalTicketBookings' => TicketBooking::where('payment_status', 'paid')->count(),
                'totalHotelBookings' => HotelBooking::where('payment_status', 'paid')->count(),
                'revenuePaket' => Order::where('status', 'success')->sum('total_harga'),
                'revenueTicket' => TicketBooking::where('payment_status', 'paid')->sum('total_harga'),
                'revenueHotel' => HotelBooking::where('payment_status', 'paid')->sum('total_harga'),
                'pendingReviews' => \App\Models\Review::where('status', 'pending')->count(),
                'activePromos' => \App\Models\Promo::where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->count(),
                'openChats' => \App\Models\SupportConversation::whereIn('status', ['open', 'pending'])->count(),
            ];
        });

        // Extract stats
        $totalPaket = $stats['totalPaket'];
        $totalDestinasi = $stats['totalDestinasi'];
        $totalTicket = $stats['totalTicket'];
        $totalHotel = $stats['totalHotel'];
        $totalUser = $stats['totalUser'];
        $totalOrders = $stats['totalOrders'];
        $totalTicketBookings = $stats['totalTicketBookings'];
        $totalHotelBookings = $stats['totalHotelBookings'];
        $revenuePaket = $stats['revenuePaket'];
        $revenueTicket = $stats['revenueTicket'];
        $revenueHotel = $stats['revenueHotel'];
        $totalRevenue = $revenuePaket + $revenueTicket + $revenueHotel;
        $pendingReviews = $stats['pendingReviews'];
        $activePromos = $stats['activePromos'];
        $openChats = $stats['openChats'];

        // Recent data - cache terpisah karena lebih sering berubah (1 menit)
        $recentData = Cache::remember('admin_dashboard_recent', 60, function () {
            return [
                'latestPakets' => PaketWisata::latest()->take(5)->get(),
                'recentOrders' => Order::with(['user', 'paketWisata'])->latest()->take(5)->get(),
                'recentTicketBookings' => TicketBooking::with(['user', 'ticket'])->latest()->take(5)->get(),
                'recentHotelBookings' => HotelBooking::with(['user', 'hotel'])->latest()->take(5)->get(),
                'recentPakets' => PaketWisata::latest()->take(5)->get(),
                'recentDestinasis' => Destinasi::latest()->take(5)->get(),
            ];
        });

        $latestPakets = $recentData['latestPakets'];
        $recentOrders = $recentData['recentOrders'];
        $recentTicketBookings = $recentData['recentTicketBookings'];
        $recentHotelBookings = $recentData['recentHotelBookings'];
        $recentPakets = $recentData['recentPakets'];
        $recentDestinasis = $recentData['recentDestinasis'];

        // Get Midtrans balance (mock data for sandbox)
        $midtransBalance = $this->getMidtransBalance();

        return view('admin.dashboard', compact(
            'totalPaket', 'totalDestinasi', 'totalTicket', 'totalHotel', 'totalUser', 
            'totalOrders', 'totalTicketBookings', 'totalHotelBookings',
            'totalRevenue', 'revenuePaket', 'revenueTicket', 'revenueHotel',
            'latestPakets', 'recentOrders', 'recentTicketBookings', 'recentHotelBookings',
            'midtransBalance', 'pendingReviews', 'activePromos', 'openChats',
            'recentPakets', 'recentDestinasis'
        ));
    }

    private function getMidtransBalance()
    {
        try {
            // In a real implementation, you would call Midtrans API
            // For now, we'll return a mock balance for demonstration
            // You can replace this with actual Midtrans API call

            $serverKey = config('midtrans.server_key');
            $baseUrl = config('midtrans.is_production') ? 'https://api.midtrans.com' : 'https://api.sandbox.midtrans.com';

            // This is a mock implementation - in production you'd make actual API calls
            // to check balance, transaction history, etc.

            // For demonstration, return a random balance between 1M - 10M
            return rand(1000000, 10000000);

        } catch (\Exception $e) {
            // Return 0 if there's an error
            return 0;
        }
    }
}

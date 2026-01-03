<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PaketWisata;
use App\Models\Destinasi;
use App\Models\Ticket;
use App\Models\Hotel;
use App\Models\Review;
use App\Models\Promo;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Show home page with random content
     */
    public function home(): View
    {
        // Paket Wisata - cached random selection
        $paketWisatas = Cache::remember('home.paket_wisatas', 3600, function () {
            return PaketWisata::where('stok', '>', 0)
                ->inRandomOrder()
                ->take(6)
                ->get();
        });

        // Destinasi - cached random selection
        $destinasis = Cache::remember('home.destinasis', 3600, function () {
            return Destinasi::inRandomOrder()
                ->take(4)
                ->get();
        });

        // Gallery - cached random destinations with images
        $galleryDestinasis = Cache::remember('home.gallery_destinasis', 3600, function () {
            return Destinasi::whereNotNull('gambar_url')
                ->inRandomOrder()
                ->take(8)
                ->get();
        });

        // Tickets - cached random active tickets
        $tickets = Cache::remember('home.tickets', 3600, function () {
            return Ticket::where('aktif', true)
                ->where('tersedia', '>', 0)
                ->inRandomOrder()
                ->take(4)
                ->get();
        });

        // Hotels - cached random active hotels
        $hotels = Cache::remember('home.hotels', 3600, function () {
            return Hotel::where('status', 'active')
                ->where('kamar_tersedia', '>', 0)
                ->inRandomOrder()
                ->take(4)
                ->get();
        });

        // Reviews - cached random approved reviews
        $reviews = Cache::remember('home.reviews', 3600, function () {
            return Review::with(['user', 'reviewable'])
                ->approved()
                ->inRandomOrder()
                ->take(6)
                ->get();
        });

        // Active promos - cached random promos
        $promos = Cache::remember('home.promos', 3600, function () {
            return Promo::valid()
                ->where(function($query) {
                    $query->whereNull('usage_limit')
                          ->orWhereRaw('used_count < usage_limit');
                })
                ->inRandomOrder()
                ->take(4)
                ->get();
        });

        return view('pages.home', compact(
            'paketWisatas',
            'destinasis',
            'galleryDestinasis',
            'tickets',
            'hotels',
            'reviews',
            'promos'
        ));
    }

    /**
     * Show about page
     */
    public function about(): View
    {
        return view('pages.about');
    }

    /**
     * Show destinasi page
     */
    public function destinasi(): View
    {
        return view('destinasi.index');
    }

    /**
     * Show kontak page
     */
    public function kontak(): View
    {
        return view('pages.kontak');
    }
}

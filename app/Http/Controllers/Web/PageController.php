<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PaketWisata;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Show home page
     */
    public function home(): View
    {
        $paketWisatas = PaketWisata::orderBy('rating', 'desc')->take(6)->get();
        return view('pages.home', compact('paketWisatas'));
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
        return view('pages.destinasi');
    }

    /**
     * Show kontak page
     */
    public function kontak(): View
    {
        return view('pages.kontak');
    }
}

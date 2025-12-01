<?php

namespace App\Http\Controllers;

use App\Models\PaketWisata;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $paketWisatas = PaketWisata::orderBy('rating', 'desc')->take(6)->get();
        return view('home', compact('paketWisatas'));
    }
}

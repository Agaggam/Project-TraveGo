<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaketWisata;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPaket = PaketWisata::count();
        $totalUser = User::where('role', 'user')->count();
        $latestPakets = PaketWisata::oldest()->take(5)->get();

        return view('admin.dashboard', compact('totalPaket', 'totalUser', 'latestPakets'));
    }
}

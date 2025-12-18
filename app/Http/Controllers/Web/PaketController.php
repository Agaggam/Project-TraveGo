<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PaketWisata;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaketController extends Controller
{
    /**
     * Display list of paket wisata
     */
    public function index(Request $request): View
    {
        $query = PaketWisata::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_paket', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'harga_asc':
                    $query->orderBy('harga', 'asc');
                    break;
                case 'harga_desc':
                    $query->orderBy('harga', 'desc');
                    break;
                case 'rating':
                    $query->orderBy('rating', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $paketWisatas = $query->paginate(9);
        $lokasiList = PaketWisata::distinct()->pluck('lokasi');

        return view('paket.index', compact('paketWisatas', 'lokasiList'));
    }

    /**
     * Display detail of paket wisata
     */
    public function show(PaketWisata $paketWisata): View
    {
        $relatedPakets = PaketWisata::where('lokasi', $paketWisata->lokasi)
            ->where('id', '!=', $paketWisata->id)
            ->take(3)
            ->get();

        return view('paket.show', compact('paketWisata', 'relatedPakets'));
    }
}

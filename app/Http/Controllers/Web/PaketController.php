<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PaketWisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PaketController extends Controller
{
    /**
     * Display list of paket wisata
     */
    public function index(Request $request): View
    {
        $query = PaketWisata::with('destinasis');

        // Filter by destinasi slug
        if ($request->filled('destinasi')) {
            $query->whereHas('destinasis', function ($q) use ($request) {
                $q->where('slug', $request->destinasi);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_paket', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  // Also search in related destinations
                  ->orWhereHas('destinasis', function ($destQuery) use ($search) {
                      $destQuery->where('nama_destinasi', 'like', "%{$search}%")
                                ->orWhere('lokasi', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'harga_asc':
                case 'price_asc':
                    $query->orderBy('harga', 'asc');
                    break;
                case 'harga_desc':
                case 'price_desc':
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
        $lokasiList = Cache::remember('paket_lokasi_list', 3600, function () {
            return PaketWisata::distinct()->pluck('lokasi');
        });

        // Get current destinasi name for filter label
        $currentDestinasi = null;
        if ($request->filled('destinasi')) {
            $currentDestinasi = \App\Models\Destinasi::where('slug', $request->destinasi)->first();
        }

        return view('paket.index', compact('paketWisatas', 'lokasiList', 'currentDestinasi'));
    }

    /**
     * Display detail of paket wisata
     */
    public function show(PaketWisata $paketWisata): View
    {
        $paketWisata->load('destinasis');

        $relatedPakets = PaketWisata::where('lokasi', $paketWisata->lokasi)
            ->where('id', '!=', $paketWisata->id)
            ->take(3)
            ->get();

        return view('paket.show', compact('paketWisata', 'relatedPakets'));
    }
}

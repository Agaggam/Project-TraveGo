<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Destinasi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DestinasiController extends Controller
{
    /**
     * Display a listing of destinations
     */
    public function index(Request $request): View
    {
        $query = Destinasi::with('paketWisatas');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_destinasi', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $destinasis = $query->orderBy('is_featured', 'desc')
            ->orderBy('rating', 'desc')
            ->paginate(12);

        $kategoris = Destinasi::distinct()->pluck('kategori');

        return view('destinasi.index', compact('destinasis', 'kategoris'));
    }

    /**
     * Display the specified destination
     */
    public function show(Destinasi $destinasi): View
    {
        // Load related packages that include this destination
        $destinasi->load('paketWisatas');
        $relatedPakets = $destinasi->paketWisatas;

        // Get related destinations from same category
        $relatedDestinasis = Destinasi::where('kategori', $destinasi->kategori)
            ->where('id', '!=', $destinasi->id)
            ->orderBy('rating', 'desc')
            ->limit(4)
            ->get();

        return view('destinasi.show', compact('destinasi', 'relatedDestinasis', 'relatedPakets'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destinasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DestinasiController extends Controller
{
    /**
     * Display list of destinasi
     */
    public function index(): View
    {
        $destinasis = Destinasi::oldest()->paginate(10);
        return view('admin.destinasi.index', compact('destinasis'));
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        return view('admin.destinasi.create');
    }

    /**
     * Store new destinasi
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_destinasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'gambar_url' => 'nullable|url|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'kategori' => 'required|in:pantai,gunung,kota,alam,budaya,kuliner,petualangan',
            'is_featured' => 'boolean',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0'
        ]);

        $validated['rating'] = $validated['rating'] ?? 0;

        Destinasi::create($validated);

        // Clear home page caches
        Cache::forget('home_destinasis');
        Cache::forget('home_gallery');

        return redirect()->route('admin.destinasi.index')->with('success', 'Destinasi berhasil ditambahkan!');
    }

    /**
     * Show edit form
     */
    public function edit(Destinasi $destinasi): View
    {
        return view('admin.destinasi.edit', compact('destinasi'));
    }

    /**
     * Update destinasi
     */
    public function update(Request $request, Destinasi $destinasi): RedirectResponse
    {
        $validated = $request->validate([
            'nama_destinasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'gambar_url' => 'nullable|url|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'kategori' => 'required|in:pantai,gunung,kota,alam,budaya,kuliner,petualangan',
            'is_featured' => 'boolean',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0'
        ]);

        $validated['rating'] = $validated['rating'] ?? 0;

        $destinasi->update($validated);

        return redirect()->route('admin.destinasi.index')->with('success', 'Destinasi berhasil diperbarui!');
    }

    /**
     * Delete destinasi
     */
    public function destroy(Destinasi $destinasi): RedirectResponse
    {
        $destinasi->delete();

        // Clear home page caches
        Cache::forget('home_destinasis');
        Cache::forget('home_gallery');

        return redirect()->route('admin.destinasi.index')->with('success', 'Destinasi berhasil dihapus!');
    }
}

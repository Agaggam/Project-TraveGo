<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaketWisata;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaketController extends Controller
{
    /**
     * Display list of paket wisata
     */
    public function index(): View
    {
        $paketWisatas = PaketWisata::oldest()->paginate(10);
        return view('admin.paket.index', compact('paketWisatas'));
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        return view('admin.paket.create');
    }

    /**
     * Store new paket wisata
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'gambar_url' => 'nullable|url|max:255',
        ]);

        $validated['rating'] = $validated['rating'] ?? 0;

        PaketWisata::create($validated);

        return redirect()->route('admin.paket.index')->with('success', 'Paket wisata berhasil ditambahkan!');
    }

    /**
     * Show edit form
     */
    public function edit(PaketWisata $paketWisata): View
    {
        return view('admin.paket.edit', compact('paketWisata'));
    }

    /**
     * Update paket wisata
     */
    public function update(Request $request, PaketWisata $paketWisata): RedirectResponse
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'gambar_url' => 'nullable|url|max:255',
        ]);

        $validated['rating'] = $validated['rating'] ?? 0;

        $paketWisata->update($validated);

        return redirect()->route('admin.paket.index')->with('success', 'Paket wisata berhasil diperbarui!');
    }

    /**
     * Delete paket wisata
     */
    public function destroy(PaketWisata $paketWisata): RedirectResponse
    {
        $paketWisata->delete();

        return redirect()->route('admin.paket.index')->with('success', 'Paket wisata berhasil dihapus!');
    }
}

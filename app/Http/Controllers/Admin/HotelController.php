<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::latest()->paginate(15);
        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('admin.hotels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_hotel' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_per_malam' => 'required|numeric|min:0',
            'harga_standard' => 'nullable|numeric|min:0',
            'harga_deluxe' => 'nullable|numeric|min:0',
            'harga_suite' => 'nullable|numeric|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
            'kamar_total' => 'required|integer|min:0',
            'kamar_tersedia' => 'required|integer|min:0',
            'kamar_standard' => 'nullable|integer|min:0',
            'kamar_deluxe' => 'nullable|integer|min:0',
            'kamar_suite' => 'nullable|integer|min:0',
            'tipe_kamar' => 'nullable|string|max:100',
            'wifi' => 'nullable|boolean',
            'kolam_renang' => 'nullable|boolean',
            'restoran' => 'nullable|boolean',
            'gym' => 'nullable|boolean',
            'parkir' => 'nullable|boolean',
            'foto' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['wifi'] = $request->has('wifi');
        $validated['kolam_renang'] = $request->has('kolam_renang');
        $validated['restoran'] = $request->has('restoran');
        $validated['gym'] = $request->has('gym');
        $validated['parkir'] = $request->has('parkir');

        Hotel::create($validated);

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel berhasil ditambahkan');
    }

    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('admin.hotels.show', compact('hotel'));
    }

    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('admin.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $validated = $request->validate([
            'nama_hotel' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_per_malam' => 'required|numeric|min:0',
            'harga_standard' => 'nullable|numeric|min:0',
            'harga_deluxe' => 'nullable|numeric|min:0',
            'harga_suite' => 'nullable|numeric|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
            'kamar_total' => 'required|integer|min:0',
            'kamar_tersedia' => 'required|integer|min:0',
            'kamar_standard' => 'nullable|integer|min:0',
            'kamar_deluxe' => 'nullable|integer|min:0',
            'kamar_suite' => 'nullable|integer|min:0',
            'tipe_kamar' => 'nullable|string|max:100',
            'wifi' => 'nullable|boolean',
            'kolam_renang' => 'nullable|boolean',
            'restoran' => 'nullable|boolean',
            'gym' => 'nullable|boolean',
            'parkir' => 'nullable|boolean',
            'foto' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['wifi'] = $request->has('wifi');
        $validated['kolam_renang'] = $request->has('kolam_renang');
        $validated['restoran'] = $request->has('restoran');
        $validated['gym'] = $request->has('gym');
        $validated['parkir'] = $request->has('parkir');

        $hotel->update($validated);

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel berhasil diperbarui');
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destinasi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DestinasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $destinasis = Destinasi::orderBy('is_featured', 'desc')
            ->orderBy('rating', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $destinasis
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_destinasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'gambar_url' => 'nullable|url|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'kategori' => 'required|in:pantai,gunung,kota,alam,budaya,kuliner,petualangan',
            'is_featured' => 'boolean'
        ]);

        $destinasi = Destinasi::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Destinasi berhasil ditambahkan',
            'data' => $destinasi
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $destinasi = Destinasi::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $destinasi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $destinasi = Destinasi::findOrFail($id);

        $validated = $request->validate([
            'nama_destinasi' => 'sometimes|required|string|max:255',
            'deskripsi' => 'sometimes|required|string',
            'lokasi' => 'sometimes|required|string|max:255',
            'gambar_url' => 'nullable|url|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'kategori' => 'sometimes|required|in:pantai,gunung,kota,alam,budaya,kuliner,petualangan',
            'is_featured' => 'boolean'
        ]);

        $destinasi->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Destinasi berhasil diperbarui',
            'data' => $destinasi
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $destinasi = Destinasi::findOrFail($id);
        $destinasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Destinasi berhasil dihapus'
        ]);
    }
}

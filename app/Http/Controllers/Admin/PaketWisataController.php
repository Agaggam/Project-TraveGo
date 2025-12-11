<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaketWisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaketWisataController extends Controller
{
    public function index()
    {
        $paketWisatas = PaketWisata::oldest()->paginate(10);
        return view('admin.paket.index', compact('paketWisatas'));
    }

    // All
    public function apiIndex(Request $request)
    {
        $limit = $request->input('limit', 1000);
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $orderBy = $request->input('orderBy', 'id');
        $sortBy = $request->input('sortBy', 'asc');

        $query = PaketWisata::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_paket', 'LIKE', '%' . $search . '%')
                    ->orWhere('lokasi', 'LIKE', '%' . $search . '%');
            });
        }

        $allowedColumns = ['id', 'nama_paket', 'harga', 'created_at', 'rating'];
        if (in_array($orderBy, $allowedColumns)) {
            $query->orderBy($orderBy, $sortBy);
        }

        $data = $query->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'status' => 'success',
            'message' => 'Success get data',
            'data' => $data
        ], 200, [], JSON_PRETTY_PRINT);
    }

    // Detail
    public function apiShow($id)
    {
        $paket = PaketWisata::find($id);

        if (!$paket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404, [], JSON_PRETTY_PRINT);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Success get data',
            'data' => $paket
        ], 200, [], JSON_PRETTY_PRINT);
    }

    // Store
    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'gambar_url' => 'nullable|url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400, [], JSON_PRETTY_PRINT);
        }

        $data = $validator->validated();
        $data['rating'] = $data['rating'] ?? 0;

        $paket = PaketWisata::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan',
            'data' => $paket
        ], 201, [], JSON_PRETTY_PRINT);
    }

    //  Update
    public function apiUpdate(Request $request, $id)
    {
        $paket = PaketWisata::find($id);

        if (!$paket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404, [], JSON_PRETTY_PRINT);
        }

        $validator = Validator::make($request->all(), [
            'nama_paket' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|string',
            'harga' => 'sometimes|numeric|min:0',
            'durasi' => 'sometimes|string|max:255',
            'lokasi' => 'sometimes|string|max:255',
            'rating' => 'sometimes|numeric|min:0|max:5',
            'gambar_url' => 'sometimes|url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400, [], JSON_PRETTY_PRINT);
        }

        $paket->update($validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diperbarui',
            'data' => $paket
        ], 200, [], JSON_PRETTY_PRINT);
    }

    //  Delete
    public function apiDestroy($id)
    {
        $paket = PaketWisata::find($id);

        if (!$paket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404, [], JSON_PRETTY_PRINT);
        }

        $paket->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function create()
    {
        return view('admin.paket.create');
    }

    public function store(Request $request)
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

    public function edit(PaketWisata $paketWisata)
    {
        return view('admin.paket.edit', compact('paketWisata'));
    }

    public function update(Request $request, PaketWisata $paketWisata)
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

    public function destroy(PaketWisata $paketWisata)
    {
        $paketWisata->delete();

        return redirect()->route('admin.paket.index')->with('success', 'Paket wisata berhasil dihapus!');
    }
}

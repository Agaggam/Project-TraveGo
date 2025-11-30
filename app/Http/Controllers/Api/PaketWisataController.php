<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaketWisata;
use Illuminate\Support\Facades\Validator;

class PaketWisataController extends Controller
{
    // GET ALL
    public function index(Request $request)
    {
        $limit    = $request->input('limit', 1000);
        $page     = $request->input('page', 1);
        $search   = $request->input('search', '');
        $orderBy  = $request->input('orderBy', 'id');
        $sortBy   = $request->input('sortBy', 'asc');

        $query = PaketWisata::query();

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nama_paket', 'LIKE', '%' . $search . '%')
                  ->orWhere('lokasi', 'LIKE', '%' . $search . '%');
            });
        }

        $allowedColumns = ['id', 'nama_paket', 'harga', 'created_at', 'rating'];
        if (in_array($orderBy, $allowedColumns)) {
            $query->orderBy($orderBy, $sortBy);
        }

        $data = $query->paginate($limit, ['*'], 'page', $page);

        return response()->json(['status' => 'success', 'message' => 'Success get data', 'data' => $data], 200, [], JSON_PRETTY_PRINT);
    }

    // GET DETAIL
    public function show($id)
    {
        $paket = PaketWisata::find($id);
        if (!$paket) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404, [], JSON_PRETTY_PRINT);
        return response()->json(['status' => 'success', 'message' => 'Success get data', 'data' => $paket], 200, [], JSON_PRETTY_PRINT);
    }

    // CREATE
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_paket' => 'required|string',
            'deskripsi'  => 'required|string',
            'harga'      => 'required|numeric',
            'durasi'     => 'required|string',
            'lokasi'     => 'required|string',
            'rating'     => 'nullable|numeric|max:5',
            'gambar_url' => 'nullable|url' // Jika string kosong dikirim, ini bisa error. JS harus kirim null.
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal', 'errors' => $validator->errors()], 400, [], JSON_PRETTY_PRINT);
        }

        $paket = PaketWisata::create($request->all());
        return response()->json(['status' => 'success', 'message' => 'Data berhasil ditambahkan', 'data' => $paket], 201, [], JSON_PRETTY_PRINT);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $paket = PaketWisata::find($id);
        if (!$paket) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404, [], JSON_PRETTY_PRINT);

        $validator = Validator::make($request->all(), [
            'nama_paket' => 'sometimes|string',
            'deskripsi'  => 'sometimes|string',
            'harga'      => 'sometimes|numeric',
            'durasi'     => 'sometimes|string',
            'lokasi'     => 'sometimes|string',
            'rating'     => 'sometimes|numeric|max:5',
            'gambar_url' => 'sometimes|url'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal', 'errors' => $validator->errors()], 400, [], JSON_PRETTY_PRINT);
        }

        $paket->update($request->all());
        return response()->json(['status' => 'success', 'message' => 'Data berhasil diperbarui', 'data' => $paket], 200, [], JSON_PRETTY_PRINT);
    }

    // DELETE
    public function destroy($id)
    {
        $paket = PaketWisata::find($id);
        if (!$paket) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404, [], JSON_PRETTY_PRINT);

        $paket->delete();
        return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus'], 200, [], JSON_PRETTY_PRINT);
    }
}

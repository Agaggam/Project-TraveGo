<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePaketRequest;
use App\Http\Requests\Api\UpdatePaketRequest;
use App\Models\PaketWisata;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    public function index(Request $request): JsonResponse
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
        ], 200);
    }

    public function show($id): JsonResponse
    {
        $paket = PaketWisata::find($id);

        if (!$paket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Success get data',
            'data' => $paket
        ], 200);
    }

    public function store(StorePaketRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['rating'] = $data['rating'] ?? 0;

        if ($request->hasFile('gambar')) {
            $data['gambar_url'] = $this->uploadFile($request->file('gambar'));
            unset($data['gambar']);
        }

        $paket = PaketWisata::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan',
            'data' => $paket
        ], 201);
    }

    public function update(UpdatePaketRequest $request, $id): JsonResponse
    {
        $paket = PaketWisata::find($id);

        if (!$paket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            $this->deleteOldFile($paket->gambar_url);
            $data['gambar_url'] = $this->uploadFile($request->file('gambar'));
            unset($data['gambar']);
        }

        $paket->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diperbarui',
            'data' => $paket
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $paket = PaketWisata::find($id);

        if (!$paket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $this->deleteOldFile($paket->gambar_url);
        $paket->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ], 200);
    }

    private function uploadFile($file): string
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('paket-wisata', $filename, 'public');
        return Storage::url($path);
    }

    private function deleteOldFile(?string $url): void
    {
        if ($url && str_starts_with($url, '/storage/')) {
            $path = str_replace('/storage/', '', $url);
            Storage::disk('public')->delete($path);
        }
    }
}

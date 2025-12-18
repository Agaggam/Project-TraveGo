<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePaketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_paket' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'gambar' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'gambar_url' => 'nullable|url|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_paket.required' => 'Nama paket wajib diisi',
            'nama_paket.max' => 'Nama paket maksimal 255 karakter',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
            'durasi.required' => 'Durasi wajib diisi',
            'lokasi.required' => 'Lokasi wajib diisi',
            'rating.numeric' => 'Rating harus berupa angka',
            'rating.min' => 'Rating minimal 0',
            'rating.max' => 'Rating maksimal 5',
            'gambar.file' => 'Gambar harus berupa file',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
            'gambar.max' => 'Ukuran gambar maksimal 5MB',
            'gambar_url.url' => 'URL gambar tidak valid',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Validasi gagal',
            'errors' => $validator->errors()
        ], 400));
    }
}

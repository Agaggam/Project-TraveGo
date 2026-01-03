<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePaketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_paket' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|string',
            'harga' => 'sometimes|numeric|min:0',
            'durasi' => 'sometimes|string|max:255',
            'lokasi' => 'sometimes|string|max:255',
            'rating' => 'sometimes|numeric|min:0|max:5',
            'gambar' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'gambar_url' => 'sometimes|url|max:255',
            'stok' => 'sometimes|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_paket.max' => 'Nama paket maksimal 255 karakter',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
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

@extends('layouts.admin')

@section('title', 'Tambah Paket Wisata - Admin TraveGo')

@section('content')
<div class="flex items-center mb-6">
    <a href="{{ route('admin.paket.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
    </a>
    <h1 class="text-2xl font-bold text-gray-800">Tambah Paket Wisata</h1>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <form method="POST" action="{{ route('admin.paket.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nama_paket" class="block text-sm font-medium text-gray-700 mb-2">Nama Paket *</label>
                <input type="text" name="nama_paket" id="nama_paket" value="{{ old('nama_paket') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('nama_paket') border-red-500 @enderror">
                @error('nama_paket')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Lokasi *</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required placeholder="Contoh: Bali, Lombok, Raja Ampat"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('lokasi') border-red-500 @enderror">
                @error('lokasi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp) *</label>
                <input type="number" name="harga" id="harga" value="{{ old('harga') }}" required min="0" step="1000"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('harga') border-red-500 @enderror">
                @error('harga')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="durasi" class="block text-sm font-medium text-gray-700 mb-2">Durasi *</label>
                <input type="text" name="durasi" id="durasi" value="{{ old('durasi') }}" required placeholder="Contoh: 3 Hari 2 Malam"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('durasi') border-red-500 @enderror">
                @error('durasi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">Rating (0-5)</label>
                <input type="number" name="rating" id="rating" value="{{ old('rating', 0) }}" min="0" max="5" step="0.1"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('rating') border-red-500 @enderror">
                @error('rating')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="gambar_url" class="block text-sm font-medium text-gray-700 mb-2">URL Gambar</label>
                <input type="url" name="gambar_url" id="gambar_url" value="{{ old('gambar_url') }}" placeholder="https://example.com/gambar.jpg"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('gambar_url') border-red-500 @enderror">
                @error('gambar_url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi *</label>
            <textarea name="deskripsi" id="deskripsi" rows="5" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="{{ route('admin.paket.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection

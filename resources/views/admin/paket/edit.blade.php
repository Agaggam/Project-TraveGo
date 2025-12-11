@extends('layouts.admin')

@section('title', 'Edit Paket Wisata - Admin TraveGo')
@section('page-title', 'Edit Paket Wisata')

@section('content')
<div class="flex items-center mb-6">
    <a href="{{ route('admin.paket.index') }}" class="p-2 rounded-xl text-gray-500 dark:text-dark-400 hover:bg-gray-100 dark:hover:bg-dark-800 transition-colors mr-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
    </a>
    <p class="text-gray-600 dark:text-dark-400">Edit paket: {{ $paketWisata->nama_paket }}</p>
</div>

<div class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-100 dark:border-dark-700 p-6 transition-colors">
    <form method="POST" action="{{ route('admin.paket.update', $paketWisata) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nama_paket" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Nama Paket *</label>
                <input type="text" name="nama_paket" id="nama_paket" value="{{ old('nama_paket', $paketWisata->nama_paket) }}" required
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-dark-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('nama_paket') border-red-500 dark:border-red-500 @enderror">
                @error('nama_paket')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="lokasi" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Lokasi *</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $paketWisata->lokasi) }}" required
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-dark-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('lokasi') border-red-500 dark:border-red-500 @enderror"
                    placeholder="Contoh: Bali, Lombok, Raja Ampat">
                @error('lokasi')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="harga" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Harga (Rp) *</label>
                <input type="number" name="harga" id="harga" value="{{ old('harga', $paketWisata->harga) }}" required min="0" step="1000"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-dark-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('harga') border-red-500 dark:border-red-500 @enderror">
                @error('harga')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="durasi" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Durasi *</label>
                <input type="text" name="durasi" id="durasi" value="{{ old('durasi', $paketWisata->durasi) }}" required
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-dark-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('durasi') border-red-500 dark:border-red-500 @enderror"
                    placeholder="Contoh: 3 Hari 2 Malam">
                @error('durasi')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Rating (0-5)</label>
                <input type="number" name="rating" id="rating" value="{{ old('rating', $paketWisata->rating) }}" min="0" max="5" step="0.1"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-dark-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('rating') border-red-500 dark:border-red-500 @enderror">
                @error('rating')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="gambar_url" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">URL Gambar</label>
                <input type="url" name="gambar_url" id="gambar_url" value="{{ old('gambar_url', $paketWisata->gambar_url) }}"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-dark-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('gambar_url') border-red-500 dark:border-red-500 @enderror"
                    placeholder="https://example.com/gambar.jpg">
                @error('gambar_url')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Deskripsi *</label>
            <textarea name="deskripsi" id="deskripsi" rows="5" required
                class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-dark-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all resize-none @error('deskripsi') border-red-500 dark:border-red-500 @enderror">{{ old('deskripsi', $paketWisata->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        @if($paketWisata->gambar_url)
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Preview Gambar</label>
                <img src="{{ $paketWisata->gambar_url }}" alt="{{ $paketWisata->nama_paket }}" class="w-48 h-32 object-cover rounded-xl border border-gray-200 dark:border-dark-600">
            </div>
        @endif

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.paket.index') }}" class="px-6 py-3 border border-gray-300 dark:border-dark-600 text-gray-700 dark:text-dark-300 rounded-xl hover:bg-gray-50 dark:hover:bg-dark-700 transition-all duration-300 font-medium">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl transition-all duration-300 font-medium">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

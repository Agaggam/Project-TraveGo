@extends('layouts.app')

@section('title', 'Paket Wisata - TraveGo')

@section('content')
<div class="bg-primary-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Paket Wisata</h1>
        <p class="mt-2 text-primary-100">Temukan paket wisata impian Anda</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('paket.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama paket atau lokasi..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                <select name="lokasi" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Semua Lokasi</option>
                    @foreach($lokasiList as $lokasi)
                        <option value="{{ $lokasi }}" {{ request('lokasi') == $lokasi ? 'selected' : '' }}>{{ $lokasi }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Terbaru</option>
                    <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Results -->
    @if($paketWisatas->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($paketWisatas as $paket)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gray-200">
                        @if($paket->gambar_url)
                            <img src="{{ $paket->gambar_url }}" alt="{{ $paket->nama_paket }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-primary-400 to-primary-600">
                                <span class="text-white text-lg">{{ $paket->nama_paket }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-primary-600 font-medium">{{ $paket->lokasi }}</span>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="ml-1 text-sm text-gray-600">{{ number_format($paket->rating, 1) }}</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $paket->nama_paket }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $paket->deskripsi }}</p>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-lg font-bold text-primary-600">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-500">/ {{ $paket->durasi }}</span>
                            </div>
                            <a href="{{ route('paket.show', $paket) }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm">
                                Lihat Detail →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $paketWisatas->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow-md">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-600 text-lg">Tidak ada paket wisata yang ditemukan.</p>
            <a href="{{ route('paket.index') }}" class="inline-block mt-4 text-primary-600 hover:text-primary-700">Reset Filter</a>
        </div>
    @endif
</div>
@endsection

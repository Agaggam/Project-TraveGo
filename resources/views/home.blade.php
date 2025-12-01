@extends('layouts.app')

@section('title', 'TraveGo - Jelajahi Indonesia')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-primary-600 to-primary-800 text-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Jelajahi Keindahan Indonesia</h1>
            <p class="text-xl mb-8 text-primary-100">Temukan paket wisata terbaik untuk petualangan Anda</p>
            <a href="{{ route('paket.index') }}" class="inline-block bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Lihat Paket Wisata
            </a>
        </div>
    </div>
</section>

<!-- Featured Packages -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Paket Wisata Populer</h2>
            <p class="text-gray-600 mt-2">Pilihan terbaik untuk liburan Anda</p>
        </div>

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

            <div class="text-center mt-12">
                <a href="{{ route('paket.index') }}" class="inline-block border-2 border-primary-600 text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-primary-600 hover:text-white transition">
                    Lihat Semua Paket
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-600">Belum ada paket wisata tersedia.</p>
            </div>
        @endif
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Mengapa Memilih TraveGo?</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Terpercaya</h3>
                <p class="text-gray-600">Ribuan pelanggan telah mempercayai kami untuk liburan mereka</p>
            </div>
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Harga Terbaik</h3>
                <p class="text-gray-600">Dapatkan harga terbaik untuk setiap paket wisata</p>
            </div>
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Dukungan 24/7</h3>
                <p class="text-gray-600">Tim kami siap membantu Anda kapan saja</p>
            </div>
        </div>
    </div>
</section>
@endsection

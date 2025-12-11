@extends('layouts.app')

@section('title', 'TraveGo - Jelajahi Indonesia')

@section('content')
<!-- Hero Section -->
<section class="relative py-24 overflow-hidden">
    <div class="absolute top-1/4 left-10 w-72 h-72 bg-primary-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 right-10 w-96 h-96 bg-accent-500/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-gray-100 dark:bg-dark-800/80 border border-gray-200 dark:border-dark-600 mb-8">
                <span class="w-2 h-2 bg-primary-500 rounded-full mr-2 animate-pulse"></span>
                <span class="text-sm text-gray-600 dark:text-dark-200">Platform Travel #1 di Indonesia</span>
            </div>
            
            <h1 class="font-heading text-5xl sm:text-6xl lg:text-7xl font-bold mb-6 leading-tight text-gray-900 dark:text-white">
                Jelajahi Keindahan<br>
                <span class="gradient-text">Indonesia</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-dark-300 max-w-2xl mx-auto mb-10 leading-relaxed">
                Temukan paket wisata terbaik untuk petualangan Anda bersama TraveGo
            </p>
            <a href="{{ route('paket.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-xl transition-all duration-300 glow-primary text-lg">
                Lihat Paket Wisata
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Featured Packages -->
<section class="py-24 bg-gray-100/50 dark:bg-dark-900/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-primary-500 font-semibold text-sm uppercase tracking-wider">Pilihan Terbaik</span>
            <h2 class="font-heading text-4xl sm:text-5xl font-bold mt-4 mb-6 text-gray-900 dark:text-white">
                Paket Wisata <span class="gradient-text">Populer</span>
            </h2>
            <p class="text-gray-600 dark:text-dark-300 max-w-2xl mx-auto text-lg">
                Pilihan terbaik untuk liburan Anda
            </p>
        </div>

        @if($paketWisatas->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($paketWisatas as $paket)
                    <div class="bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 rounded-2xl overflow-hidden card-hover transition-all duration-300">
                        <div class="h-48 bg-gray-200 dark:bg-dark-700">
                            @if($paket->gambar_url)
                                <img src="{{ $paket->gambar_url }}" alt="{{ $paket->nama_paket }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-primary-600 to-accent-600">
                                    <span class="text-white text-lg font-heading">{{ $paket->nama_paket }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm text-primary-500 font-medium">{{ $paket->lokasi }}</span>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-accent-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="ml-1 text-sm text-gray-500 dark:text-dark-300">{{ number_format($paket->rating, 1) }}</span>
                                </div>
                            </div>
                            <h3 class="font-heading text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $paket->nama_paket }}</h3>
                            <p class="text-gray-500 dark:text-dark-400 text-sm mb-4 line-clamp-2">{{ $paket->deskripsi }}</p>
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-lg font-bold text-primary-500">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                                    <span class="text-sm text-gray-400 dark:text-dark-500">/ {{ $paket->durasi }}</span>
                                </div>
                                <a href="{{ route('paket.show', $paket) }}" class="text-primary-500 hover:text-primary-400 font-medium text-sm flex items-center">
                                    Lihat Detail
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('paket.index') }}" class="inline-flex items-center px-8 py-4 gradient-border rounded-xl text-gray-900 dark:text-white font-semibold hover:bg-gray-50 dark:hover:bg-dark-800 transition-all duration-300">
                    Lihat Semua Paket
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 dark:text-dark-400">Belum ada paket wisata tersedia.</p>
            </div>
        @endif
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-primary-500 font-semibold text-sm uppercase tracking-wider">Keunggulan Kami</span>
            <h2 class="font-heading text-4xl sm:text-5xl font-bold mt-4 mb-6 text-gray-900 dark:text-white">
                Mengapa Memilih <span class="gradient-text">TraveGo</span>?
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-8 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 card-hover transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-500/20 to-primary-600/20 rounded-xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="font-heading text-xl font-semibold mb-3 text-gray-900 dark:text-white">Terpercaya</h3>
                <p class="text-gray-500 dark:text-dark-400">Ribuan pelanggan telah mempercayai kami untuk liburan mereka</p>
            </div>
            <div class="text-center p-8 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 card-hover transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-accent-500/20 to-accent-600/20 rounded-xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-heading text-xl font-semibold mb-3 text-gray-900 dark:text-white">Harga Terbaik</h3>
                <p class="text-gray-500 dark:text-dark-400">Dapatkan harga terbaik untuk setiap paket wisata</p>
            </div>
            <div class="text-center p-8 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 card-hover transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-500/20 to-accent-500/20 rounded-xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="font-heading text-xl font-semibold mb-3 text-gray-900 dark:text-white">Dukungan 24/7</h3>
                <p class="text-gray-500 dark:text-dark-400">Tim kami siap membantu Anda kapan saja</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 bg-gray-100/50 dark:bg-dark-900/50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-heading text-4xl sm:text-5xl font-bold mb-6 text-gray-900 dark:text-white">
            Siap Memulai <span class="gradient-text">Petualangan</span>?
        </h2>
        <p class="text-gray-600 dark:text-dark-300 text-lg mb-10 max-w-2xl mx-auto">
            Bergabung dengan ribuan traveler lainnya dan mulai jelajahi destinasi impian Anda hari ini.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 text-white font-semibold rounded-xl transition-all duration-300 text-lg">
                Daftar Sekarang - Gratis!
            </a>
        </div>
    </div>
</section>
@endsection

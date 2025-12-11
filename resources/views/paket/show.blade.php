@extends('layouts.app')

@section('title', $paketWisata->nama_paket . ' - TraveGo')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-dark-400">
            <li><a href="/" class="hover:text-primary-500">Beranda</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('paket.index') }}" class="hover:text-primary-500">Paket Wisata</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900 dark:text-white">{{ $paketWisata->nama_paket }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Image -->
            <div class="h-96 bg-gray-200 dark:bg-dark-700 rounded-2xl overflow-hidden mb-6">
                @if($paketWisata->gambar_url)
                    <img src="{{ $paketWisata->gambar_url }}" alt="{{ $paketWisata->nama_paket }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-primary-500 to-accent-500">
                        <span class="text-white text-2xl font-heading">{{ $paketWisata->nama_paket }}</span>
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-200 dark:border-dark-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-primary-500 font-medium">{{ $paketWisata->lokasi }}</span>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-accent-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="ml-1 text-gray-700 dark:text-dark-300">{{ number_format($paketWisata->rating, 1) }}</span>
                    </div>
                </div>

                <h1 class="text-3xl font-heading font-bold text-gray-900 dark:text-white mb-4">{{ $paketWisata->nama_paket }}</h1>

                <div class="flex items-center space-x-6 text-gray-600 dark:text-dark-300 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $paketWisata->durasi }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $paketWisata->lokasi }}
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-dark-700 pt-6">
                    <h2 class="text-xl font-heading font-semibold text-gray-900 dark:text-white mb-4">Deskripsi</h2>
                    <p class="text-gray-600 dark:text-dark-300 leading-relaxed whitespace-pre-line">{{ $paketWisata->deskripsi }}</p>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-200 dark:border-dark-700 p-6 sticky top-24">
                <div class="text-center mb-6">
                    <span class="text-sm text-gray-500 dark:text-dark-400">Mulai dari</span>
                    <div class="text-3xl font-heading font-bold text-primary-500">Rp {{ number_format($paketWisata->harga, 0, ',', '.') }}</div>
                    <span class="text-gray-500 dark:text-dark-400">/ orang</span>
                </div>

                @auth
                    <a href="{{ route('order.checkout', $paketWisata) }}" class="w-full block text-center py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-semibold transition-all duration-300 mb-4">
                        Pesan Sekarang
                    </a>
                @else
                    <a href="{{ route('login') }}?redirect={{ urlencode(route('order.checkout', $paketWisata)) }}" class="w-full block text-center py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl font-semibold transition-all duration-300 mb-4">
                        Pesan Sekarang
                    </a>
                    <p class="text-center text-sm text-gray-500 dark:text-dark-400 mb-4">Login untuk melakukan pemesanan</p>
                @endauth

                <a href="https://wa.me/6281234567890?text={{ urlencode('Halo, saya tertarik dengan paket ' . $paketWisata->nama_paket) }}" target="_blank" class="w-full block text-center py-3 border border-gray-300 dark:border-dark-600 text-gray-700 dark:text-dark-300 rounded-xl font-semibold hover:bg-gray-50 dark:hover:bg-dark-700 transition-all duration-300">
                    Hubungi Kami
                </a>

                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-dark-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Termasuk dalam paket:</h3>
                    <ul class="space-y-2 text-gray-600 dark:text-dark-300">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Transportasi
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Akomodasi
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Makan 3x sehari
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Tour guide
                        </li>
                    </ul>
                </div>
                
                <!-- Secure Badge -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-dark-700 flex items-center justify-center text-sm text-gray-500 dark:text-dark-400">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Pembayaran Aman via Midtrans
                </div>
            </div>
        </div>
    </div>

    <!-- Related Packages -->
    @if($relatedPakets->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-heading font-bold text-gray-900 dark:text-white mb-6">Paket Wisata Lainnya di {{ $paketWisata->lokasi }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedPakets as $paket)
                    <div class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-200 dark:border-dark-700 overflow-hidden hover:border-primary-500/50 transition-all duration-300">
                        <div class="h-40 bg-gray-200 dark:bg-dark-700">
                            @if($paket->gambar_url)
                                <img src="{{ $paket->gambar_url }}" alt="{{ $paket->nama_paket }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-primary-500 to-accent-500">
                                    <span class="text-white">{{ $paket->nama_paket }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $paket->nama_paket }}</h3>
                            <div class="flex items-center justify-between">
                                <span class="text-primary-500 font-bold">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                                <a href="{{ route('paket.show', $paket) }}" class="text-primary-500 hover:text-primary-400 text-sm font-medium">Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

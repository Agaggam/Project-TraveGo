@extends('layouts.app')

@section('title', $destinasi->nama_destinasi . ' - TraveGo')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[50vh] flex items-end overflow-hidden">
    <div class="absolute inset-0 z-0">
        @if($destinasi->gambar_url)
            <img src="{{ $destinasi->gambar_url }}" alt="{{ $destinasi->nama_destinasi }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full" style="background: linear-gradient(135deg, var(--primary), var(--accent))"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 pt-8 w-full">
        <!-- Back Button -->
        <button onclick="history.back()" class="inline-flex items-center text-white/80 hover:text-white mb-6 transition-colors cursor-pointer bg-transparent border-0">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </button>
        <span class="inline-block px-4 py-2 rounded-full text-sm font-medium text-white mb-4" style="background: var(--accent)">
            {{ ucfirst($destinasi->kategori) }}
        </span>
        <h1 class="font-serif text-4xl sm:text-5xl font-bold text-white mb-4">{{ $destinasi->nama_destinasi }}</h1>
        <div class="flex items-center text-white/80">
            <i class="fas fa-map-marker-alt mr-2" style="color: var(--primary-light)"></i>
            <span>{{ $destinasi->lokasi ?? 'Indonesia' }}</span>
        </div>
    </div>
</section>

<!-- Content -->
<section class="py-16" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-10">
                <div class="fade-up">
                    <h2 class="font-serif text-2xl font-bold mb-4" style="color: var(--text-primary)">Tentang Destinasi Ini</h2>
                    <div class="prose max-w-none leading-relaxed whitespace-pre-line" style="color: var(--text-secondary)">
                        {{ $destinasi->deskripsi }}
                    </div>
                </div>

                <!-- Gallery -->
                @if(isset($destinasi->galeri) && count($destinasi->galeri) > 0)
                <div class="fade-up">
                    <h2 class="font-serif text-2xl font-bold mb-4" style="color: var(--text-primary)">Galeri</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($destinasi->galeri as $img)
                            <div class="aspect-square rounded-xl overflow-hidden">
                                <img src="{{ $img }}" alt="" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Related Packages -->
                @if(isset($relatedPakets) && $relatedPakets->count() > 0)
                <div class="fade-up">
                    <h2 class="font-serif text-2xl font-bold mb-4" style="color: var(--text-primary)">Paket yang Termasuk Destinasi Ini</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($relatedPakets as $paket)
                            <a href="{{ route('paket.show', $paket) }}" class="card group rounded-xl overflow-hidden">
                                <div class="aspect-video overflow-hidden">
                                    @if($paket->gambar_url)
                                        <img src="{{ $paket->gambar_url }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                                            <i class="fas fa-image text-3xl" style="color: var(--text-muted)"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h4 class="font-bold mb-1" style="color: var(--text-primary)">{{ $paket->nama_paket }}</h4>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gradient font-bold">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                                        <span class="text-xs" style="color: var(--text-muted)">{{ $paket->durasi }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-28 space-y-6">
                    <!-- Booking Card -->
                    <div class="card rounded-2xl p-6">
                        <div class="mb-4">
                            <span class="text-xs" style="color: var(--text-muted)">Harga Tiket Masuk</span>
                            <div class="text-3xl font-bold text-gradient">Rp {{ number_format($destinasi->harga ?? 0, 0, ',', '.') }}</div>
                            <span class="text-sm" style="color: var(--text-muted)">/orang</span>
                        </div>
                        
                        @if($destinasi->stok > 0)
                            <div class="mb-4 flex items-center text-sm" style="color: var(--text-muted)">
                                <i class="fas fa-ticket-alt mr-2" style="color: var(--primary)"></i>
                                <span>{{ $destinasi->stok }} tiket tersedia</span>
                            </div>
                        @endif

                        @auth
                            <a href="{{ route('order.destinasi.checkout', $destinasi->slug) }}" class="btn-primary w-full py-4 rounded-xl font-semibold flex items-center justify-center">
                                <i class="fas fa-shopping-cart mr-2"></i>Pesan Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary w-full py-4 rounded-xl font-semibold flex items-center justify-center">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login untuk Memesan
                            </a>
                        @endauth
                        
                        <div class="mt-4 pt-4 text-center" style="border-top: 1px solid var(--border)">
                            <p class="text-xs" style="color: var(--text-muted)">
                                <i class="fas fa-shield-alt mr-1"></i>Pembayaran aman & terverifikasi
                            </p>
                        </div>
                    </div>
                    
                    <!-- Info Card -->
                    <div class="card rounded-2xl p-6">
                        <h3 class="font-bold mb-4" style="color: var(--text-primary)">Informasi</h3>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: var(--bg-tertiary)">
                                    <i class="fas fa-tag" style="color: var(--primary)"></i>
                                </div>
                                <div>
                                    <span class="text-xs" style="color: var(--text-muted)">Kategori</span>
                                    <p class="font-medium" style="color: var(--text-primary)">{{ ucfirst($destinasi->kategori) }}</p>
                                </div>
                            </div>
                            @if($destinasi->lokasi)
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: var(--bg-tertiary)">
                                    <i class="fas fa-map-marker-alt" style="color: var(--accent)"></i>
                                </div>
                                <div>
                                    <span class="text-xs" style="color: var(--text-muted)">Lokasi</span>
                                    <p class="font-medium" style="color: var(--text-primary)">{{ $destinasi->lokasi }}</p>
                                </div>
                            </div>
                            @endif
                            @if($destinasi->rating)
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: var(--bg-tertiary)">
                                    <i class="fas fa-star" style="color: #f59e0b"></i>
                                </div>
                                <div>
                                    <span class="text-xs" style="color: var(--text-muted)">Rating</span>
                                    <p class="font-medium" style="color: var(--text-primary)">{{ number_format($destinasi->rating, 1) }} / 5.0</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        @if(isset($relatedPakets) && $relatedPakets->count() > 0)
                        <div class="mt-6 pt-6" style="border-top: 1px solid var(--border)">
                            <p class="text-sm mb-3" style="color: var(--text-muted)">
                                <i class="fas fa-suitcase-rolling mr-1"></i>
                                {{ $relatedPakets->count() }} paket tersedia
                            </p>
                            <a href="{{ route('paket.index', ['destinasi' => $destinasi->slug]) }}" class="w-full py-3 rounded-xl font-medium flex items-center justify-center border" style="border-color: var(--border); color: var(--text-primary)">
                                <i class="fas fa-search mr-2"></i>Lihat Paket
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

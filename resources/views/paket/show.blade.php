@extends('layouts.app')

@section('title', $paketWisata->nama_paket . ' - TraveGo')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[60vh] flex items-end overflow-hidden">
    <div class="absolute inset-0 z-0">
        @if($paketWisata->gambar_url)
            <img src="{{ $paketWisata->gambar_url }}" alt="{{ $paketWisata->nama_paket }}" class="w-full h-full object-cover">
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
        <div class="flex flex-wrap gap-3 mb-6">
            <span class="px-4 py-2 rounded-full text-sm font-medium text-white" style="background: var(--primary)">
                <i class="fas fa-clock mr-2"></i>{{ $paketWisata->durasi }}
            </span>
            <span class="px-4 py-2 rounded-full text-sm font-bold text-white" style="background: var(--accent)">
                <i class="fas fa-star mr-2"></i>{{ number_format($paketWisata->rating, 1) }}
            </span>
        </div>
        <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-4">
            {{ $paketWisata->nama_paket }}
        </h1>
        <div class="flex items-center text-white/80">
            <i class="fas fa-map-marker-alt mr-2" style="color: var(--primary-light)"></i>
            <span class="text-lg">{{ $paketWisata->lokasi }}</span>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-16" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-12">
                <!-- Description -->
                <div class="fade-up">
                    <h2 class="font-serif text-2xl font-bold mb-6" style="color: var(--text-primary)">About This Package</h2>
                    <div class="prose max-w-none leading-relaxed whitespace-pre-line" style="color: var(--text-secondary)">
                        {{ $paketWisata->deskripsi }}
                    </div>
                </div>

                <!-- Features -->
                <div class="fade-up">
                    <h2 class="font-serif text-2xl font-bold mb-6" style="color: var(--text-primary)">What's Included</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach([
                            ['fas fa-bus', 'Transport'],
                            ['fas fa-hotel', 'Accommodation'],
                            ['fas fa-utensils', 'Meals'],
                            ['fas fa-user-tie', 'Tour Guide']
                        ] as $feature)
                            <div class="card p-6 rounded-xl text-center">
                                <i class="{{ $feature[0] }} text-2xl mb-3" style="color: var(--primary)"></i>
                                <span class="text-sm font-medium" style="color: var(--text-secondary)">{{ $feature[1] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Destinations -->
                @if($paketWisata->destinasis->count() > 0)
                <div class="fade-up">
                    <h2 class="font-serif text-2xl font-bold mb-6" style="color: var(--text-primary)">Destinations Covered</h2>
                    <div class="space-y-4">
                        @foreach($paketWisata->destinasis as $destinasi)
                            <a href="{{ route('destinasi.show', $destinasi->slug) }}" class="card rounded-xl overflow-hidden block hover:shadow-lg transition-all group">
                                <div class="flex flex-col md:flex-row">
                                    <div class="md:w-48 h-32 md:h-auto overflow-hidden">
                                        @if($destinasi->gambar_url)
                                            <img src="{{ $destinasi->gambar_url }}" alt="{{ $destinasi->nama_destinasi }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                                                <i class="fas fa-image text-2xl" style="color: var(--text-muted)"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 p-6">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="font-bold text-lg group-hover:text-[var(--primary)] transition-colors" style="color: var(--text-primary)">{{ $destinasi->nama_destinasi }}</h3>
                                            <span class="px-2 py-1 rounded text-xs font-medium" style="background: var(--bg-tertiary); color: var(--text-muted)">{{ $destinasi->kategori }}</span>
                                        </div>
                                        <p class="text-sm line-clamp-2" style="color: var(--text-muted)">{{ $destinasi->deskripsi }}</p>
                                        <span class="inline-flex items-center mt-3 text-sm font-medium" style="color: var(--primary)">
                                            View Details <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar - Booking Card -->
            <div class="lg:col-span-1">
                <div class="sticky top-28">
                    <div class="card rounded-2xl p-8 shadow-xl">
                        <div class="mb-6">
                            <span class="text-sm" style="color: var(--text-muted)">Price per person</span>
                            <div class="text-3xl font-bold text-gradient">Rp {{ number_format($paketWisata->harga, 0, ',', '.') }}</div>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div class="flex items-center justify-between p-4 rounded-xl" style="background: var(--bg-tertiary)">
                                <div class="flex items-center">
                                    <i class="fas fa-users mr-3" style="color: var(--primary)"></i>
                                    <span class="text-sm font-medium" style="color: var(--text-secondary)">Available Slots</span>
                                </div>
                                <span class="font-bold {{ $paketWisata->stok > 0 ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $paketWisata->stok > 0 ? $paketWisata->stok . ' slots' : 'Full' }}
                                </span>
                            </div>
                            <div class="flex items-center text-sm px-4" style="color: var(--text-muted)">
                                <i class="fas fa-shield-alt mr-2" style="color: var(--primary)"></i>
                                Secure payment via Midtrans
                            </div>
                        </div>

                        @auth
                            @if($paketWisata->stok > 0)
                                <a href="{{ route('order.checkout', $paketWisata) }}" class="btn-primary w-full py-4 rounded-xl font-semibold flex items-center justify-center">
                                    <i class="fas fa-bolt mr-2"></i>Book Now
                                </a>
                            @else
                                <button disabled class="w-full py-4 rounded-xl font-semibold cursor-not-allowed" style="background: var(--bg-tertiary); color: var(--text-muted)">
                                    Fully Booked
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}?redirect={{ urlencode(route('order.checkout', $paketWisata)) }}" class="btn-primary w-full py-4 rounded-xl font-semibold flex items-center justify-center">
                                Sign in to Book
                            </a>
                        @endauth

                        <div class="mt-6 pt-6 text-center" style="border-top: 1px solid var(--border)">
                            <a href="https://wa.me/6281234567890?text={{ urlencode('Hi, I\'m interested in ' . $paketWisata->nama_paket) }}" 
                               class="text-sm font-medium transition-colors hover:text-green-500" style="color: var(--text-muted)">
                                <i class="fab fa-whatsapp mr-2"></i>Ask via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Packages -->
@if($relatedPakets->count() > 0)
<section class="py-16" style="background: var(--bg-secondary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="fade-up font-serif text-3xl font-bold mb-8" style="color: var(--text-primary)">You May Also Like</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedPakets as $paket)
                <a href="{{ route('paket.show', $paket) }}" class="scale-up card group rounded-2xl overflow-hidden">
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ $paket->gambar_url }}" alt="{{ $paket->nama_paket }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg mb-2 group-hover:text-[var(--primary)] transition-colors" style="color: var(--text-primary)">{{ $paket->nama_paket }}</h3>
                        <span class="text-lg font-bold text-gradient">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

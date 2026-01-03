@extends('layouts.app')

@section('title', 'TraveGo - Platform Travel Premium Indonesia')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center overflow-hidden -mt-24 pt-24">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1920" alt="Bali" class="w-full h-full object-cover">
        <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0.6))"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <!-- Badge -->
        <div class="fade-up inline-flex items-center px-5 py-2 glass rounded-full mb-8">
            <i class="fas fa-award text-amber-400 mr-2"></i>
            <span class="text-sm font-medium text-white">Dipercaya 50,000+ Traveler Indonesia</span>
        </div>

        <!-- Headline -->
        <h1 class="fade-up font-serif text-5xl sm:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight">
            Temukan Keindahan<br>
            <span class="text-gradient">Indonesia</span>
        </h1>

        <!-- Subheadline -->
        <p class="fade-up text-xl text-gray-200 max-w-2xl mx-auto mb-12">
            Jelajahi destinasi menakjubkan, paket wisata terkurasi, dan pengalaman tak terlupakan di seluruh nusantara.
        </p>

        <!-- Search Bar -->
        <div class="fade-up max-w-4xl mx-auto mb-12">
            <div class="glass rounded-2xl p-3">
                <form action="{{ route('paket.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3">
                    <div class="flex-1 relative">
                        <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2" style="color: var(--primary)"></i>
                        <input type="text" name="search" placeholder="Mau kemana?" 
                            class="w-full pl-12 pr-4 py-4 rounded-xl border-0 text-white bg-white/10 placeholder-gray-300 focus:bg-white/20 focus:ring-2 focus:ring-[var(--primary)] transition-all">
                    </div>
                    <div class="lg:w-48 relative">
                        <i class="fas fa-calendar absolute left-4 top-1/2 -translate-y-1/2" style="color: var(--primary)"></i>
                        <input type="date" name="date" class="w-full pl-12 pr-4 py-4 rounded-xl border-0 text-white bg-white/10 focus:bg-white/20 focus:ring-2 focus:ring-[var(--primary)] transition-all">
                    </div>
                    <div class="lg:w-40 relative">
                        <i class="fas fa-users absolute left-4 top-1/2 -translate-y-1/2" style="color: var(--primary)"></i>
                        <select name="people" class="w-full pl-12 pr-4 py-4 rounded-xl border-0 text-white bg-white/10 focus:bg-white/20 focus:ring-2 focus:ring-[var(--primary)] transition-all appearance-none">
                            <option value="1">1 Orang</option>
                            <option value="2">2 Orang</option>
                            <option value="3">3 Orang</option>
                            <option value="4">4+ Orang</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-primary px-8 py-4 rounded-xl font-semibold flex items-center justify-center space-x-2">
                        <i class="fas fa-search"></i>
                        <span>Jelajahi</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Stats -->
        <div class="fade-up flex flex-wrap justify-center gap-12">
            @foreach([['500+', 'Destinasi'], ['50K+', 'Traveler Puas'], ['4.9★', 'Rating Rata-rata'], ['24/7', 'Layanan']] as $stat)
                <div class="text-center">
                    <div class="text-3xl font-serif font-bold text-white">{{ $stat[0] }}</div>
                    <div class="text-sm text-gray-300">{{ $stat[1] }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <i class="fas fa-chevron-down text-white text-2xl opacity-50"></i>
    </div>
</section>

<!-- Active Promos Banner -->
@if(isset($promos) && $promos->count() > 0)
<section class="py-8" style="background: linear-gradient(135deg, var(--primary), var(--accent))">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center text-white">
                <i class="fas fa-tags text-3xl mr-4"></i>
                <div>
                    <h3 class="font-bold text-lg">🎉 Promo Spesial Tersedia!</h3>
                    <p class="text-white/80 text-sm">{{ $promos->count() }} promo aktif menunggu untuk diklaim</p>
                </div>
            </div>
            <a href="{{ route('promo.index') }}" class="px-6 py-3 bg-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:-translate-y-1" style="color: var(--primary)">
                <i class="fas fa-gift mr-2"></i>Lihat Semua Promo
            </a>
        </div>
    </div>
</section>
@endif

<!-- Tiket Transportasi Section -->
@if(isset($tickets) && $tickets->count() > 0)
<section class="py-16" style="background: var(--bg-secondary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
            <div>
                <span class="fade-up inline-block px-4 py-2 rounded-full text-sm font-medium mb-4" style="background: rgba(59,130,246,0.1); color: #3b82f6">
                    <i class="fas fa-plane mr-2"></i>Tiket Transportasi
                </span>
                <h2 class="fade-up font-serif text-3xl sm:text-4xl font-bold" style="color: var(--text-primary)">
                    Pesan Tiket <span class="text-gradient">Mudah & Cepat</span>
                </h2>
            </div>
            <a href="{{ route('tiket.index') }}" class="fade-up mt-4 md:mt-0 font-medium flex items-center transition-colors" style="color: var(--primary)">
                Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($tickets as $index => $ticket)
                <div class="scale-up" style="animation-delay: {{ $index * 0.1 }}s">
                    <a href="{{ route('tiket.show', $ticket) }}" class="card group rounded-2xl overflow-hidden block p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                                @if($ticket->jenis_transportasi == 'pesawat')
                                    <i class="fas fa-plane text-xl text-blue-500"></i>
                                @elseif($ticket->jenis_transportasi == 'kereta')
                                    <i class="fas fa-train text-xl text-blue-500"></i>
                                @else
                                    <i class="fas fa-bus text-xl text-blue-500"></i>
                                @endif
                            </div>
                            <span class="px-2 py-1 rounded text-xs font-medium" style="background: var(--bg-tertiary); color: var(--text-muted)">
                                {{ ucfirst($ticket->kelas) }}
                            </span>
                        </div>
                        <h3 class="font-bold mb-2 group-hover:text-[var(--primary)] transition-colors" style="color: var(--text-primary)">
                            {{ $ticket->nama_transportasi }}
                        </h3>
                        <div class="flex items-center text-sm mb-3" style="color: var(--text-muted)">
                            <span>{{ $ticket->asal }}</span>
                            <i class="fas fa-arrow-right mx-2" style="color: var(--primary)"></i>
                            <span>{{ $ticket->tujuan }}</span>
                        </div>
                        <div class="flex items-center justify-between pt-3" style="border-top: 1px solid var(--border)">
                            <div class="text-lg font-bold text-gradient">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</div>
                            <span class="text-xs" style="color: var(--text-muted)">{{ $ticket->tersedia }} tersisa</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Hotel Rekomendasi Section -->
@if(isset($hotels) && $hotels->count() > 0)
<section class="py-16" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
            <div>
                <span class="fade-up inline-block px-4 py-2 rounded-full text-sm font-medium mb-4" style="background: rgba(139,92,246,0.1); color: #8b5cf6">
                    <i class="fas fa-hotel mr-2"></i>Hotel Terbaik
                </span>
                <h2 class="fade-up font-serif text-3xl sm:text-4xl font-bold" style="color: var(--text-primary)">
                    Penginapan <span class="text-gradient">Nyaman</span>
                </h2>
            </div>
            <a href="{{ route('hotel.index') }}" class="fade-up mt-4 md:mt-0 font-medium flex items-center transition-colors" style="color: var(--primary)">
                Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($hotels as $index => $hotel)
                <div class="scale-up h-full" style="animation-delay: {{ $index * 0.1 }}s">
                    <a href="{{ route('hotel.show', $hotel) }}" class="card group rounded-2xl overflow-hidden block h-full flex flex-col">
                        <div class="aspect-[4/3] relative overflow-hidden flex-shrink-0">
                            @if($hotel->foto)
                                <img src="{{ $hotel->foto }}" alt="{{ $hotel->nama_hotel }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, #8b5cf6, #ec4899)">
                                    <i class="fas fa-hotel text-4xl text-white/50"></i>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3 px-2 py-1 rounded-lg text-xs font-bold text-white" style="background: var(--accent)">
                                <i class="fas fa-star mr-1"></i>{{ number_format($hotel->rating, 1) }}
                            </div>
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="font-bold mb-1 group-hover:text-[var(--primary)] transition-colors line-clamp-1" style="color: var(--text-primary)">
                                {{ $hotel->nama_hotel }}
                            </h3>
                            <p class="text-sm mb-3 line-clamp-1" style="color: var(--text-muted)">
                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $hotel->lokasi }}
                            </p>
                            <div class="flex items-center justify-between mt-auto">
                                <div>
                                    <span class="text-xs" style="color: var(--text-muted)">Mulai dari</span>
                                    <div class="font-bold text-gradient">Rp {{ number_format($hotel->harga_per_malam, 0, ',', '.') }}</div>
                                </div>
                                <span class="text-xs px-2 py-1 rounded" style="background: var(--bg-tertiary); color: var(--text-muted)">
                                    {{ $hotel->kamar_tersedia }} kamar
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<section class="py-24" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="fade-up inline-block px-4 py-2 rounded-full text-sm font-medium mb-4" style="background: rgba(16,185,129,0.1); color: var(--primary)">
                    <i class="fas fa-compass mr-2"></i>Destinasi Populer
                </span>
                <h2 class="fade-up font-serif text-4xl sm:text-5xl font-bold" style="color: var(--text-primary)">
                    Jelajahi <span class="text-gradient">Permata Tersembunyi</span> Indonesia
                </h2>
            </div>
            <a href="{{ route('destinasi.index') }}" class="fade-up mt-4 md:mt-0 font-medium flex items-center transition-colors" style="color: var(--primary)">
                Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($destinasis as $index => $destinasi)
                <div class="scale-up" style="animation-delay: {{ $index * 0.1 }}s">
                    <a href="{{ route('destinasi.show', $destinasi->slug) }}" class="card group rounded-2xl overflow-hidden block">
                        <div class="aspect-[4/5] relative overflow-hidden">
                            @if($destinasi->gambar_url)
                                <img src="{{ $destinasi->gambar_url }}" alt="{{ $destinasi->nama_destinasi }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--primary), var(--accent))">
                                    <i class="fas fa-map-marker-alt text-4xl text-white/50"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                            @if($destinasi->rating)
                            <div class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-bold text-white" style="background: var(--accent)">
                                <i class="fas fa-star mr-1"></i>{{ number_format($destinasi->rating, 1) }}
                            </div>
                            @endif
                            <div class="absolute bottom-4 left-4 right-4">
                                <h3 class="font-serif text-xl font-bold text-white mb-1">{{ $destinasi->nama_destinasi }}</h3>
                                <p class="text-sm text-gray-300 mb-2">{{ $destinasi->lokasi ?? ucfirst($destinasi->kategori) }}</p>
                                <div class="flex items-center justify-between">
                                    @if($destinasi->harga > 0)
                                        <span class="text-sm text-gray-400">Mulai <span class="font-bold text-white">Rp {{ number_format($destinasi->harga, 0, ',', '.') }}</span></span>
                                    @else
                                        <span class="text-sm text-gray-400">Jelajahi Sekarang</span>
                                    @endif
                                    <span class="w-8 h-8 rounded-full flex items-center justify-center bg-white/20 group-hover:bg-[var(--primary)] transition-colors">
                                        <i class="fas fa-arrow-right text-white text-xs"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <!-- Fallback jika belum ada destinasi -->
                @php
                    $fallbackDestinations = [
                        ['Bali', 'Surga Pulau', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600', '4.9'],
                        ['Raja Ampat', 'Keajaiban Laut', 'https://images.unsplash.com/photo-1570789210967-2cac24f14a89?w=600', '4.8'],
                        ['Yogyakarta', 'Warisan Budaya', 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=600', '4.7'],
                        ['Labuan Bajo', 'Gerbang Komodo', 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=600', '4.8'],
                    ];
                @endphp
                @foreach($fallbackDestinations as $index => $dest)
                    <div class="scale-up" style="animation-delay: {{ $index * 0.1 }}s">
                        <a href="{{ route('destinasi.index') }}" class="card group rounded-2xl overflow-hidden block">
                            <div class="aspect-[4/5] relative overflow-hidden">
                                <img src="{{ $dest[2] }}" alt="{{ $dest[0] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                <div class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-bold text-white" style="background: var(--accent)">
                                    <i class="fas fa-star mr-1"></i>{{ $dest[3] }}
                                </div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <h3 class="font-serif text-xl font-bold text-white mb-1">{{ $dest[0] }}</h3>
                                    <p class="text-sm text-gray-300 mb-2">{{ $dest[1] }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<!-- Travel Packages -->
<section class="py-24" style="background: var(--bg-secondary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="fade-up inline-block px-4 py-2 rounded-full text-sm font-medium mb-4" style="background: rgba(245,158,11,0.1); color: var(--accent)">
                <i class="fas fa-suitcase-rolling mr-2"></i>Paket Wisata
            </span>
            <h2 class="fade-up font-serif text-4xl sm:text-5xl font-bold mb-4" style="color: var(--text-primary)">
                Pengalaman <span class="text-gradient">Terkurasi</span>
            </h2>
            <p class="fade-up max-w-2xl mx-auto" style="color: var(--text-muted)">
                Paket wisata pilihan yang dirancang untuk memberikan pengalaman terbaik dengan harga kompetitif.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($paketWisatas ?? [] as $index => $paket)
                <div class="scale-up" style="animation-delay: {{ $index * 0.1 }}s">
                    <a href="{{ route('paket.show', $paket) }}" class="card group rounded-2xl overflow-hidden block">
                        <div class="aspect-video relative overflow-hidden">
                            @if($paket->gambar_url)
                                <img src="{{ $paket->gambar_url }}" alt="{{ $paket->nama_paket }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full" style="background: linear-gradient(135deg, var(--primary), var(--accent))"></div>
                            @endif
                            <div class="absolute top-4 left-4 flex gap-2">
                                <span class="px-3 py-1 glass rounded-full text-xs font-medium text-white">
                                    <i class="fas fa-clock mr-1"></i>{{ $paket->durasi }}
                                </span>
                                @if($paket->stok <= 5)
                                    <span class="px-3 py-1 rounded-full text-xs font-bold text-white bg-red-500">Terbatas</span>
                                @endif
                            </div>
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold text-white" style="background: var(--accent)">
                                    <i class="fas fa-star mr-1"></i>{{ number_format($paket->rating, 1) }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-sm mb-2" style="color: var(--text-muted)">
                                <i class="fas fa-map-marker-alt mr-2" style="color: var(--primary)"></i>
                                {{ $paket->lokasi }}
                            </div>
                            <h3 class="font-serif text-xl font-bold mb-3 group-hover:text-[var(--primary)] transition-colors" style="color: var(--text-primary)">
                                {{ $paket->nama_paket }}
                            </h3>
                            <div class="flex items-center justify-between pt-4" style="border-top: 1px solid var(--border)">
                                <div>
                                    <span class="text-sm" style="color: var(--text-muted)">Mulai dari</span>
                                    <div class="text-xl font-bold text-gradient">Rp {{ number_format($paket->harga, 0, ',', '.') }}</div>
                                </div>
                                <span class="btn-primary w-10 h-10 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                @for($i = 0; $i < 3; $i++)
                    <div class="scale-up card rounded-2xl overflow-hidden" style="animation-delay: {{ $i * 0.1 }}s">
                        <div class="aspect-video" style="background: linear-gradient(135deg, var(--primary), var(--accent))"></div>
                        <div class="p-6">
                            <div class="h-4 rounded mb-3" style="background: var(--bg-tertiary); width: 60%"></div>
                            <div class="h-6 rounded mb-4" style="background: var(--bg-tertiary); width: 80%"></div>
                            <div class="flex justify-between items-center pt-4" style="border-top: 1px solid var(--border)">
                                <div class="h-6 rounded" style="background: var(--bg-tertiary); width: 40%"></div>
                                <div class="w-10 h-10 rounded-xl" style="background: var(--bg-tertiary)"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            @endforelse
        </div>

        <div class="fade-up text-center mt-12">
            <a href="{{ route('paket.index') }}" class="btn-primary px-8 py-4 rounded-xl font-semibold inline-flex items-center space-x-2">
                <span>Lihat Semua Paket</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-24" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <span class="fade-up inline-block px-4 py-2 rounded-full text-sm font-medium mb-4" style="background: rgba(16,185,129,0.1); color: var(--primary)">
                    Mengapa Memilih Kami
                </span>
                <h2 class="fade-up font-serif text-4xl sm:text-5xl font-bold mb-6" style="color: var(--text-primary)">
                    Partner Perjalanan <span class="text-gradient">Terpercaya</span>
                </h2>
                <p class="fade-up mb-10" style="color: var(--text-muted)">
                    Kami berkomitmen memberikan pengalaman perjalanan terbaik dengan layanan premium dan harga kompetitif.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @php
                        $features = [
                            ['fas fa-tag', 'Jaminan Harga Terbaik', 'Harga kompetitif untuk setiap perjalanan', 'primary'],
                            ['fas fa-user-tie', 'Pemandu Profesional', 'Pemandu wisata lokal berpengalaman', 'accent'],
                            ['fas fa-shield-alt', 'Aman & Terpercaya', 'Berlisensi dan diasuransikan penuh', 'primary'],
                            ['fas fa-headset', 'Layanan 24/7', 'Selalu ada saat Anda membutuhkan', 'accent'],
                        ];
                    @endphp
                    @foreach($features as $index => $feature)
                        <div class="fade-up card p-6 rounded-xl" style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background: rgba({{ $feature[3] == 'primary' ? '16,185,129' : '245,158,11' }},0.1)">
                                <i class="{{ $feature[0] }} text-xl" style="color: var(--{{ $feature[3] }})"></i>
                            </div>
                            <h4 class="font-bold mb-2" style="color: var(--text-primary)">{{ $feature[1] }}</h4>
                            <p class="text-sm" style="color: var(--text-muted)">{{ $feature[2] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="fade-up relative">
                <div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800" alt="Travel" class="w-full h-full object-cover">
                </div>
                <!-- Floating Badge -->
                <div class="absolute -bottom-10 -left-6 card p-4 rounded-xl shadow-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, var(--primary), var(--accent))">
                            <i class="fas fa-trophy text-white text-xl"></i>
                        </div>
                        <div>
                            <div class="font-bold" style="color: var(--text-primary)">Travel Terbaik 2024</div>
                            <div class="text-sm" style="color: var(--text-muted)">Penghargaan Indonesia</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Real User Reviews -->
<section class="py-24" style="background: var(--bg-secondary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="fade-up inline-block px-4 py-2 rounded-full text-sm font-medium mb-4" style="background: rgba(245,158,11,0.1); color: var(--accent)">
                <i class="fas fa-star mr-2"></i>Review Pengguna
            </span>
            <h2 class="fade-up font-serif text-4xl sm:text-5xl font-bold" style="color: var(--text-primary)">
                Kata <span class="text-gradient">Traveler</span>
            </h2>
            <p class="fade-up mt-4" style="color: var(--text-muted)">Review terbaru dari pengguna TraveGo</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($reviews ?? [] as $index => $review)
                <div class="scale-up card p-8 rounded-2xl" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-lg" style="background: linear-gradient(135deg, var(--primary), var(--accent))">
                            {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-bold" style="color: var(--text-primary)">{{ $review->user->name ?? 'User' }}</div>
                            <div class="text-sm" style="color: var(--text-muted)">{{ $review->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <div class="flex text-amber-400 mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $review->rating ? '' : 'opacity-30' }}"></i>
                        @endfor
                        <span class="ml-2 text-sm font-medium" style="color: var(--text-muted)">{{ $review->rating }}/5</span>
                    </div>
                    <p class="leading-relaxed mb-4" style="color: var(--text-secondary)">"{{ Str::limit($review->comment, 150) }}"</p>
                    @if($review->reviewable)
                        <div class="pt-4 flex items-center" style="border-top: 1px solid var(--border)">
                            <i class="fas fa-map-marker-alt mr-2" style="color: var(--primary)"></i>
                            <span class="text-sm" style="color: var(--text-muted)">
                                {{ $review->reviewable->nama_destinasi ?? $review->reviewable->nama_hotel ?? $review->reviewable->nama_paket ?? $review->reviewable->nama_transportasi ?? 'TraveGo' }}
                            </span>
                        </div>
                    @endif
                </div>
            @empty
                @php
                    $fallbackTestimonials = [
                        ['Sarah A.', 'Jakarta', 'Pengalaman luar biasa! Pemandu wisatanya sangat berpengetahuan dan jadwalnya direncanakan dengan sempurna.', 5],
                        ['Budi P.', 'Surabaya', 'Agen travel terbaik yang pernah saya gunakan. Semuanya berjalan mulus dari pemesanan hingga perjalanan.', 5],
                        ['Rina K.', 'Bandung', 'Paket Raja Ampat melebihi ekspektasi saya. Pasti akan pesan lagi!', 5],
                    ];
                @endphp
                @foreach($fallbackTestimonials as $index => $testimonial)
                    <div class="scale-up card p-8 rounded-2xl" style="animation-delay: {{ $index * 0.1 }}s">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-lg" style="background: linear-gradient(135deg, var(--primary), var(--accent))">
                                {{ strtoupper(substr($testimonial[0], 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-bold" style="color: var(--text-primary)">{{ $testimonial[0] }}</div>
                                <div class="text-sm" style="color: var(--text-muted)">{{ $testimonial[1] }}</div>
                            </div>
                        </div>
                        <div class="flex text-amber-400 mb-4">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <p class="leading-relaxed" style="color: var(--text-secondary)">"{{ $testimonial[2] }}"</p>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<!-- Gallery -->
<section class="py-24" style="background: var(--bg-primary)" x-data="{ lightbox: false, currentImage: '', currentName: '', currentSlug: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="fade-up inline-block px-4 py-2 rounded-full text-sm font-medium mb-4" style="background: rgba(16,185,129,0.1); color: var(--primary)">
                <i class="fas fa-images mr-2"></i>Galeri
            </span>
            <h2 class="fade-up font-serif text-4xl sm:text-5xl font-bold" style="color: var(--text-primary)">
                Momen <span class="text-gradient">Terabadikan</span>
            </h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
            @forelse($galleryDestinasis ?? [] as $index => $dest)
                <div class="scale-up" style="animation-delay: {{ $index * 0.05 }}s">
                    <div class="aspect-square rounded-2xl overflow-hidden group cursor-pointer relative"
                         @click="lightbox = true; currentImage = '{{ $dest->gambar_url }}'; currentName = '{{ $dest->nama_destinasi }}'; currentSlug = '{{ $dest->slug }}'">
                        <img src="{{ $dest->gambar_url }}" alt="{{ $dest->nama_destinasi }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all flex items-center justify-center">
                            <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                            <p class="text-white text-sm font-medium truncate">{{ $dest->nama_destinasi }}</p>
                        </div>
                    </div>
                </div>
            @empty
                @php
                    $fallbackGallery = [
                        'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600',
                        'https://images.unsplash.com/photo-1570789210967-2cac24f14a89?w=600',
                        'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=600',
                        'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=600',
                        'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600',
                        'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=600',
                        'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600',
                        'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=600',
                    ];
                @endphp
                @foreach($fallbackGallery as $index => $img)
                    <div class="scale-up" style="animation-delay: {{ $index * 0.05 }}s">
                        <div class="aspect-square rounded-2xl overflow-hidden group cursor-pointer">
                            <img src="{{ $img }}" alt="Gallery" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
    
    <!-- Lightbox Modal -->
    <div x-show="lightbox" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         @click.self="lightbox = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-black/80" @click="lightbox = false"></div>
        <div class="relative max-w-4xl w-full" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
            <button @click="lightbox = false" class="absolute -top-12 right-0 text-white text-3xl hover:text-gray-300 transition-colors">
                <i class="fas fa-times"></i>
            </button>
            <img :src="currentImage" :alt="currentName" class="w-full max-h-[70vh] object-contain rounded-2xl shadow-2xl">
            <div class="mt-4 text-center">
                <h3 class="text-white text-xl font-bold mb-3" x-text="currentName"></h3>
                <a :href="'/destinasi/' + currentSlug" class="btn-primary px-6 py-3 rounded-xl font-semibold inline-flex items-center">
                    <i class="fas fa-arrow-right mr-2"></i>Lihat Destinasi
                </a>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section - Only for guests -->
@guest
<section class="py-24" style="background: linear-gradient(135deg, var(--primary), #0d9488)">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="fade-up font-serif text-4xl sm:text-5xl font-bold text-white mb-6">
            Siap Memulai Petualangan?
        </h2>
        <p class="fade-up text-xl text-white/80 mb-10">
            Bergabung dengan ribuan traveler bahagia dan ciptakan kenangan tak terlupakan bersama TraveGo.
        </p>
        <div class="fade-up flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="px-8 py-4 bg-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:-translate-y-1" style="color: var(--primary)">
                Mulai Gratis
            </a>
            <a href="{{ route('paket.index') }}" class="px-8 py-4 bg-white/20 text-white rounded-xl font-semibold hover:bg-white/30 transition-all">
                Jelajahi Paket
            </a>
        </div>
    </div>
</section>
@endguest
@endsection

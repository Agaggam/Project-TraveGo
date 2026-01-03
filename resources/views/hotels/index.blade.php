@extends('layouts.app')

@section('title', 'Hotel & Penginapan - TraveGo')

@section('content')
<!-- Hero -->
<section class="relative min-h-[40vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1920" alt="Hotel" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-amber-900/90 to-orange-800/80"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center py-20">
        <h1 class="fade-up font-serif text-4xl sm:text-5xl font-bold text-white mb-4">Hotel & Penginapan</h1>
        <p class="fade-up text-lg text-white/80 max-w-2xl mx-auto">Temukan hotel terbaik untuk perjalanan Anda</p>
    </div>
</section>

<!-- Pencarian & Filter -->
<section class="py-6 sticky top-28 z-30" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('hotel.index') }}" method="GET" class="glass rounded-2xl p-4">
            <div class="flex flex-col lg:flex-row gap-4 items-center">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2" style="color: var(--text-muted)"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari hotel atau lokasi..."
                        class="w-full pl-12 pr-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">
                </div>
                <div class="flex gap-2 flex-wrap">
                    @foreach(['wifi' => 'WiFi', 'kolam_renang' => 'Kolam', 'restoran' => 'Restoran'] as $key => $label)
                        <label class="flex items-center px-3 py-2 rounded-xl cursor-pointer" style="background: var(--bg-tertiary)">
                            <input type="checkbox" name="facilities[]" value="{{ $key }}" {{ in_array($key, request('facilities', [])) ? 'checked' : '' }}
                                class="rounded" style="color: var(--primary)">
                            <span class="ml-2 text-sm" style="color: var(--text-secondary)">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                <button type="submit" class="btn-primary px-6 py-3 rounded-xl font-medium">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Daftar Hotel -->
<section class="py-12" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($hotels->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($hotels as $index => $hotel)
                    <div class="scale-up" style="animation-delay: {{ $index * 0.05 }}s">
                        <a href="{{ route('hotel.show', $hotel) }}" class="card group rounded-2xl overflow-hidden block">
                            <div class="aspect-video relative overflow-hidden">
                                @if($hotel->foto)
                                    <img src="{{ $hotel->foto }}" alt="{{ $hotel->nama_hotel }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--primary), var(--accent))">
                                        <i class="fas fa-hotel text-4xl text-white"></i>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                
                                <!-- Tags -->
                                <div class="absolute top-4 left-4 flex gap-2">
                                    <span class="px-3 py-1 glass rounded-full text-xs font-medium text-white">
                                        <i class="fas fa-bed mr-1"></i>{{ $hotel->kamar_tersedia }} Kamar
                                    </span>
                                </div>
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold text-white" style="background: var(--accent)">
                                        <i class="fas fa-star mr-1"></i>{{ number_format($hotel->rating, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-8">
                                <div class="flex items-center text-sm mb-2" style="color: var(--text-muted)">
                                    <i class="fas fa-map-marker-alt mr-2" style="color: var(--primary)"></i>
                                    {{ $hotel->lokasi }}
                                </div>
                                <h3 class="font-serif text-xl font-bold mb-3 group-hover:text-[var(--primary)] transition-colors line-clamp-2" style="color: var(--text-primary)">
                                    {{ $hotel->nama_hotel }}
                                </h3>
                                
                                <!-- Fasilitas Icons -->
                                <div class="flex gap-3 mb-4" style="color: var(--text-muted)">
                                    @if($hotel->wifi)
                                        <span title="WiFi"><i class="fas fa-wifi"></i></span>
                                    @endif
                                    @if($hotel->kolam_renang)
                                        <span title="Kolam Renang"><i class="fas fa-swimming-pool"></i></span>
                                    @endif
                                    @if($hotel->restoran)
                                        <span title="Restoran"><i class="fas fa-utensils"></i></span>
                                    @endif
                                    @if($hotel->parkir)
                                        <span title="Parkir"><i class="fas fa-parking"></i></span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center justify-between pt-4" style="border-top: 1px solid var(--border)">
                                    <div>
                                        <span class="text-xs" style="color: var(--text-muted)">Mulai dari</span>
                                        <div class="text-xl font-bold text-gradient">Rp {{ number_format($hotel->harga_per_malam, 0, ',', '.') }}</div>
                                    </div>
                                    <span class="btn-primary w-10 h-10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fas fa-arrow-right text-white"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $hotels->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-hotel text-5xl mb-4" style="color: var(--text-muted)"></i>
                <h3 class="font-serif text-xl font-bold mb-2" style="color: var(--text-primary)">Tidak Ada Hotel</h3>
                <p style="color: var(--text-muted)">Coba ubah filter pencarian Anda</p>
            </div>
        @endif
    </div>
</section>
@endsection

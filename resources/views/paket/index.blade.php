@extends('layouts.app')

@section('title', 'Paket Wisata - TraveGo')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 overflow-hidden" style="background: linear-gradient(135deg, var(--primary), #0d9488)">
    <div class="absolute inset-0 opacity-20">
        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1920" alt="" class="w-full h-full object-cover">
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="fade-up font-serif text-4xl sm:text-5xl font-bold text-white mb-4">Paket Wisata</h1>
        <p class="fade-up text-lg text-white/80 max-w-2xl mx-auto">Temukan koleksi pengalaman perjalanan premium terkurasi kami di seluruh Indonesia.</p>
    </div>
</section>

<!-- Filters -->
<section class="py-8 sticky top-28 z-30" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass rounded-2xl p-4">
            <form action="{{ route('paket.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2" style="color: var(--text-muted)"></i>
                    <input type="text" name="search" placeholder="Cari paket..." value="{{ request('search') }}"
                        class="w-full pl-12 pr-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">
                </div>
                <select name="sort" class="px-4 py-3 rounded-xl border-0" style="background: var(--bg-tertiary); color: var(--text-primary)">
                    <option value="">Urutkan</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
                </select>
                <button type="submit" class="btn-primary px-6 py-3 rounded-xl font-medium">
                    <i class="fas fa-filter mr-2"></i>Terapkan Filter
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Package List -->
<section class="py-12" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Active Filter Banner -->
        @if(isset($currentDestinasi) && $currentDestinasi)
        <div class="mb-6 p-4 rounded-xl flex items-center justify-between" style="background: var(--bg-secondary)">
            <div class="flex items-center">
                <i class="fas fa-filter mr-3" style="color: var(--primary)"></i>
                <span style="color: var(--text-secondary)">Menampilkan paket untuk destinasi:</span>
                <span class="ml-2 font-bold" style="color: var(--text-primary)">{{ $currentDestinasi->nama_destinasi }}</span>
            </div>
            <a href="{{ route('paket.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium" style="background: var(--bg-tertiary); color: var(--text-muted)">
                <i class="fas fa-times mr-1"></i>Hapus Filter
            </a>
        </div>
        @endif
        
        @if(isset($paketWisatas) && $paketWisatas->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($paketWisatas as $index => $paket)
                    <div class="scale-up" style="animation-delay: {{ $index * 0.05 }}s">
                        <a href="{{ route('paket.show', $paket) }}" class="card group rounded-2xl overflow-hidden block">
                            <div class="aspect-video relative overflow-hidden">
                                @if($paket->gambar_url)
                                    <img src="{{ $paket->gambar_url }}" alt="{{ $paket->nama_paket }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full" style="background: linear-gradient(135deg, var(--primary), var(--accent))"></div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                
                                <!-- Tags -->
                                <div class="absolute top-4 left-4 flex gap-2">
                                    <span class="px-3 py-1 glass rounded-full text-xs font-medium text-white">
                                        <i class="fas fa-clock mr-1"></i>{{ $paket->durasi }}
                                    </span>
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
                                <h3 class="font-serif text-xl font-bold mb-3 group-hover:text-[var(--primary)] transition-colors line-clamp-2" style="color: var(--text-primary)">
                                    {{ $paket->nama_paket }}
                                </h3>
                                <p class="text-sm mb-4 line-clamp-2" style="color: var(--text-muted)">
                                    {{ Str::limit($paket->deskripsi, 100) }}
                                </p>
                                <div class="flex items-center justify-between pt-4" style="border-top: 1px solid var(--border)">
                                    <div>
                                        <span class="text-xs" style="color: var(--text-muted)">Mulai dari</span>
                                        <div class="text-xl font-bold text-gradient">Rp {{ number_format($paket->harga, 0, ',', '.') }}</div>
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
            @if($paketWisatas->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $paketWisatas->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                    <i class="fas fa-suitcase-rolling text-4xl" style="color: var(--text-muted)"></i>
                </div>
                <h3 class="font-serif text-2xl font-bold mb-2" style="color: var(--text-primary)">Paket Tidak Ditemukan</h3>
                <p style="color: var(--text-muted)">Coba sesuaikan pencarian atau filter Anda.</p>
            </div>
        @endif
    </div>
</section>
@endsection

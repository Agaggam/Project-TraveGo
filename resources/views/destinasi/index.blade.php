@extends('layouts.app')

@section('title', 'Destinasi - TraveGo')

@section('content')
<!-- Hero -->
<section class="relative py-20 overflow-hidden" style="background: linear-gradient(135deg, var(--accent), #ea580c)">
    <div class="absolute inset-0 opacity-20">
        <img src="https://images.unsplash.com/photo-1570789210967-2cac24f14a89?w=1920" alt="" class="w-full h-full object-cover">
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="fade-up font-serif text-4xl sm:text-5xl font-bold text-white mb-4">Destinasi Wisata</h1>
        <p class="fade-up text-lg text-white/80 max-w-2xl mx-auto">Jelajahi destinasi terindah dan ikonik di Indonesia</p>
    </div>
</section>

<!-- Pencarian & Filter -->
<section class="py-6 sticky top-28 z-30" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('destinasi.index') }}" method="GET" class="glass rounded-2xl p-4">
            <div class="flex flex-col md:flex-row gap-4 items-center">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2" style="color: var(--text-muted)"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari destinasi..."
                        class="w-full pl-12 pr-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">
                </div>
                <div class="flex gap-2 flex-wrap">
                    <a href="{{ route('destinasi.index') }}" class="px-4 py-2 rounded-xl font-medium text-sm {{ !request('kategori') ? 'text-white' : '' }}"
                        style="{{ !request('kategori') ? 'background: var(--primary)' : 'background: var(--bg-tertiary); color: var(--text-secondary)' }}">Semua</a>
                    @if(isset($kategoris))
                        @foreach($kategoris as $kat)
                            <a href="{{ route('destinasi.index', ['kategori' => $kat]) }}" 
                                class="px-4 py-2 rounded-xl font-medium text-sm {{ request('kategori') == $kat ? 'text-white' : '' }}"
                                style="{{ request('kategori') == $kat ? 'background: var(--primary)' : 'background: var(--bg-tertiary); color: var(--text-secondary)' }}">
                                {{ ucfirst($kat) }}
                            </a>
                        @endforeach
                    @endif
                </div>
                <button type="submit" class="btn-primary px-6 py-3 rounded-xl font-medium">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Daftar Destinasi -->
<section class="py-12" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($destinasis->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($destinasis as $index => $destinasi)
                    <div class="fade-up" style="animation-delay: {{ $index * 0.05 }}s">
                        <a href="{{ route('destinasi.show', $destinasi->slug) }}" class="card group rounded-2xl overflow-hidden block">
                            <div class="aspect-[4/5] relative overflow-hidden">
                                @if($destinasi->gambar_url)
                                    <img src="{{ $destinasi->gambar_url }}" alt="{{ $destinasi->nama_destinasi }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                                        <i class="fas fa-image text-4xl" style="color: var(--text-muted)"></i>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                                @if($destinasi->rating)
                                    <div class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-bold text-white" style="background: var(--accent)">
                                        <i class="fas fa-star mr-1"></i>{{ number_format($destinasi->rating, 1) }}
                                    </div>
                                @endif
                                <div class="absolute bottom-4 left-4 right-4">
                                    <span class="px-2 py-1 rounded text-[10px] font-bold uppercase text-white/80 mb-2 inline-block" style="background: rgba(255,255,255,0.2)">{{ ucfirst($destinasi->kategori) }}</span>
                                    <h3 class="font-serif text-xl font-bold text-white mb-1">{{ $destinasi->nama_destinasi }}</h3>
                                    <p class="text-sm text-gray-300 mb-2 line-clamp-1">{{ $destinasi->lokasi ?? 'Indonesia' }}</p>
                                    <div class="flex items-center justify-between">
                                        @if($destinasi->harga > 0)
                                            <span class="text-sm text-white font-bold">Rp {{ number_format($destinasi->harga, 0, ',', '.') }}</span>
                                        @elseif($destinasi->paketWisatas->count() > 0)
                                            <span class="text-sm text-gray-400">{{ $destinasi->paketWisatas->count() }} Paket</span>
                                        @else
                                            <span class="text-sm text-gray-400">Jelajahi</span>
                                        @endif
                                        <span class="w-8 h-8 rounded-full flex items-center justify-center bg-white/20 group-hover:bg-[var(--primary)] transition-colors">
                                            <i class="fas fa-arrow-right text-white text-xs"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $destinasis->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-map-marker-alt text-5xl mb-4" style="color: var(--text-muted)"></i>
                <h3 class="font-serif text-xl font-bold mb-2" style="color: var(--text-primary)">Tidak Ada Destinasi</h3>
                <p style="color: var(--text-muted)">Coba ubah filter pencarian Anda</p>
                <a href="{{ route('destinasi.index') }}" class="btn-primary px-6 py-3 rounded-xl font-medium mt-6 inline-block">
                    Lihat Semua Destinasi
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

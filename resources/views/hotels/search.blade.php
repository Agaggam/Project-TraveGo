@extends('layouts.app')

@section('title', 'Search Hotels - TraveGo')

@section('content')
<section class="py-16" style="background: linear-gradient(135deg, #0ea5e9, #06b6d4)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-serif text-4xl font-bold text-white mb-4">Find Your Perfect Stay</h1>
        <p class="text-white/80">Search from hundreds of hotels across Indonesia</p>
    </div>
</section>

<section class="py-8 -mt-8 relative z-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card rounded-2xl p-6 shadow-xl">
            <form action="{{ route('hotel.search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Destination</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2" style="color: var(--text-muted)"></i>
                        <input type="text" name="location" placeholder="City or hotel name" value="{{ request('location') }}"
                            class="w-full pl-12 pr-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Check-in</label>
                    <input type="date" name="check_in" value="{{ request('check_in') }}" min="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Check-out</label>
                    <input type="date" name="check_out" value="{{ request('check_out') }}"
                        class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">
                </div>
                <div class="md:col-span-4">
                    <button type="submit" class="btn-primary w-full py-3 rounded-xl font-semibold">
                        <i class="fas fa-search mr-2"></i>Search Hotels
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="py-12" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(isset($hotels) && $hotels->count() > 0)
            <h2 class="font-serif text-2xl font-bold mb-6" style="color: var(--text-primary)">{{ $hotels->count() }} Hotels Found</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($hotels as $hotel)
                    <a href="{{ route('hotel.show', $hotel) }}" class="card rounded-xl overflow-hidden group">
                        <div class="aspect-video overflow-hidden relative">
                            @if($hotel->gambar_url)
                                <img src="{{ $hotel->gambar_url }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                                    <i class="fas fa-hotel text-4xl" style="color: var(--text-muted)"></i>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3 flex text-amber-400 text-sm">
                                @for($i = 0; $i < ($hotel->bintang ?? 5); $i++) ★ @endfor
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold mb-1" style="color: var(--text-primary)">{{ $hotel->nama }}</h3>
                            <p class="text-sm mb-2" style="color: var(--text-muted)"><i class="fas fa-map-marker-alt mr-1"></i>{{ $hotel->lokasi }}</p>
                            <div class="flex justify-between items-center mt-3 pt-3" style="border-top: 1px solid var(--border)">
                                <span class="text-sm" style="color: var(--text-muted)">From</span>
                                <span class="font-bold text-gradient">Rp {{ number_format($hotel->harga ?? 0, 0, ',', '.') }}/night</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-search text-4xl mb-4" style="color: var(--text-muted)"></i>
                <p style="color: var(--text-muted)">Search for hotels to see results</p>
            </div>
        @endif
    </div>
</section>
@endsection

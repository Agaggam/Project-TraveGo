@extends('layouts.app')

@section('title', $hotel->nama . ' - TraveGo')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[50vh] flex items-end overflow-hidden">
    <div class="absolute inset-0 z-0">
        @if($hotel->gambar_url)
            <img src="{{ $hotel->gambar_url }}" alt="{{ $hotel->nama }}" class="w-full h-full object-cover">
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
        <div class="flex text-amber-400 mb-4">
            @for($i = 0; $i < ($hotel->bintang ?? 5); $i++) ★ @endfor
        </div>
        <h1 class="font-serif text-4xl sm:text-5xl font-bold text-white mb-4">{{ $hotel->nama }}</h1>
        <div class="flex items-center text-white/80">
            <i class="fas fa-map-marker-alt mr-2" style="color: var(--primary-light)"></i>
            <span>{{ $hotel->lokasi }}</span>
        </div>
    </div>
</section>

<!-- Content -->
<section class="py-16" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-10">
                <!-- Description -->
                <div class="fade-up">
                    <h2 class="font-serif text-2xl font-bold mb-4" style="color: var(--text-primary)">About This Hotel</h2>
                    <div class="prose max-w-none leading-relaxed whitespace-pre-line" style="color: var(--text-secondary)">
                        {{ $hotel->deskripsi }}
                    </div>
                </div>

                <!-- Amenities -->
                <div class="fade-up">
                    <h2 class="font-serif text-2xl font-bold mb-4" style="color: var(--text-primary)">Amenities</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach(['WiFi' => 'fas fa-wifi', 'Pool' => 'fas fa-swimming-pool', 'Spa' => 'fas fa-spa', 'Gym' => 'fas fa-dumbbell', 'Restaurant' => 'fas fa-utensils', 'Bar' => 'fas fa-glass-martini-alt', 'Parking' => 'fas fa-parking', 'AC' => 'fas fa-snowflake'] as $name => $icon)
                            <div class="card p-4 rounded-xl flex items-center space-x-3">
                                <i class="{{ $icon }}" style="color: var(--primary)"></i>
                                <span class="text-sm font-medium" style="color: var(--text-secondary)">{{ $name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Room Types -->
                <div class="fade-up">
                    <h2 class="font-serif text-2xl font-bold mb-4" style="color: var(--text-primary)">Available Rooms</h2>
                    <div class="space-y-4">
                        @foreach([
                            ['Deluxe Room', 'City View, King Bed, 35m²', 1500000],
                            ['Superior Room', 'Garden View, Twin Bed, 40m²', 2000000],
                            ['Suite', 'Ocean View, King Bed, Living Area, 60m²', 3500000],
                        ] as $room)
                            <div class="card rounded-xl p-6 flex flex-col md:flex-row items-center justify-between gap-4">
                                <div>
                                    <h4 class="font-bold mb-1" style="color: var(--text-primary)">{{ $room[0] }}</h4>
                                    <p class="text-sm" style="color: var(--text-muted)">{{ $room[1] }}</p>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="text-right">
                                        <span class="text-sm" style="color: var(--text-muted)">Per night</span>
                                        <div class="text-xl font-bold text-gradient">Rp {{ number_format($room[2], 0, ',', '.') }}</div>
                                    </div>
                                    <button class="btn-primary px-6 py-3 rounded-xl font-medium">Book</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-28">
                    <div class="card rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex text-amber-400">
                                @for($i = 0; $i < ($hotel->bintang ?? 5); $i++) ★ @endfor
                            </div>
                            <div class="flex items-center px-2 py-1 rounded" style="background: rgba(16,185,129,0.1)">
                                <i class="fas fa-star mr-1" style="color: var(--primary)"></i>
                                <span class="font-bold" style="color: var(--primary)">{{ $hotel->rating ?? '4.8' }}</span>
                            </div>
                        </div>

                        <h3 class="font-bold mb-2" style="color: var(--text-primary)">{{ $hotel->nama }}</h3>
                        <p class="text-sm mb-4" style="color: var(--text-muted)">
                            <i class="fas fa-map-marker-alt mr-1"></i>{{ $hotel->lokasi }}
                        </p>

                        <div class="mb-6">
                            <span class="text-sm" style="color: var(--text-muted)">Starting from</span>
                            <div class="text-2xl font-bold text-gradient">Rp {{ number_format($hotel->harga ?? 1500000, 0, ',', '.') }}<span class="text-sm font-normal" style="color: var(--text-muted)">/night</span></div>
                        </div>

                        <a href="{{ route('hotel.booking', $hotel) }}" class="btn-primary w-full py-4 rounded-xl font-semibold flex items-center justify-center">
                            <i class="fas fa-calendar-check mr-2"></i>Book Now
                        </a>

                        <div class="mt-4 text-center">
                            <a href="tel:+6281234567890" class="text-sm font-medium" style="color: var(--text-muted)">
                                <i class="fas fa-phone mr-1"></i>Call for Reservations
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

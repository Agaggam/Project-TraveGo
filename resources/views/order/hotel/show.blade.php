@extends('layouts.app')

@section('title', 'Hotel Booking Details - TraveGo')

@section('content')
<section class="py-12" style="background: var(--bg-primary)">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('booking.hotel') }}" class="inline-flex items-center text-sm font-medium mb-6" style="color: var(--primary)">
            <i class="fas fa-arrow-left mr-2"></i>Back to Bookings
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="card rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-serif text-xl font-bold" style="color: var(--text-primary)">Booking #{{ $order->id ?? '0' }}</h2>
                        <span class="px-3 py-1 rounded-full text-sm font-bold" style="background: rgba(16,185,129,0.1); color: #10b981">
                            {{ $order->status ?? 'confirmed' }}
                        </span>
                    </div>
                    <p class="text-sm" style="color: var(--text-muted)">Booked on {{ $order->created_at->format('d F Y, H:i') ?? '-' }}</p>
                </div>

                @if(isset($order->hotel))
                <div class="card rounded-2xl overflow-hidden">
                    <div class="aspect-video">
                        @if($order->hotel->gambar_url)
                            <img src="{{ $order->hotel->gambar_url }}" alt="" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                                <i class="fas fa-hotel text-4xl" style="color: var(--text-muted)"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <div class="flex text-amber-400 text-sm mb-2">@for($i = 0; $i < ($order->hotel->bintang ?? 5); $i++) ★ @endfor</div>
                        <h3 class="font-serif text-2xl font-bold mb-2" style="color: var(--text-primary)">{{ $order->hotel->nama }}</h3>
                        <p class="text-sm" style="color: var(--text-muted)"><i class="fas fa-map-marker-alt mr-1"></i>{{ $order->hotel->lokasi }}</p>
                    </div>
                </div>
                @endif

                <div class="card rounded-2xl p-6">
                    <h3 class="font-bold mb-4" style="color: var(--text-primary)">Stay Details</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl" style="background: var(--bg-tertiary)">
                            <span class="text-sm" style="color: var(--text-muted)">Check-in</span>
                            <p class="font-bold" style="color: var(--text-primary)">{{ $order->check_in ?? '-' }}</p>
                        </div>
                        <div class="p-4 rounded-xl" style="background: var(--bg-tertiary)">
                            <span class="text-sm" style="color: var(--text-muted)">Check-out</span>
                            <p class="font-bold" style="color: var(--text-primary)">{{ $order->check_out ?? '-' }}</p>
                        </div>
                        <div class="p-4 rounded-xl" style="background: var(--bg-tertiary)">
                            <span class="text-sm" style="color: var(--text-muted)">Room Type</span>
                            <p class="font-bold" style="color: var(--text-primary)">{{ $order->tipe_kamar ?? 'Deluxe' }}</p>
                        </div>
                        <div class="p-4 rounded-xl" style="background: var(--bg-tertiary)">
                            <span class="text-sm" style="color: var(--text-muted)">Guests</span>
                            <p class="font-bold" style="color: var(--text-primary)">{{ $order->jumlah_tamu ?? 2 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-28">
                    <div class="card rounded-2xl p-6">
                        <h3 class="font-bold mb-4" style="color: var(--text-primary)">Payment Summary</h3>
                        <div class="flex justify-between items-center">
                            <span class="font-bold" style="color: var(--text-primary)">Total</span>
                            <span class="text-2xl font-bold text-gradient">Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

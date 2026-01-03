@extends('layouts.app')

@section('title', 'Ticket Booking Details - TraveGo')

@section('content')
<section class="py-12" style="background: var(--bg-primary)">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('booking.tiket') }}" class="inline-flex items-center text-sm font-medium mb-6" style="color: var(--primary)">
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

                <div class="card rounded-2xl p-6">
                    <h3 class="font-bold mb-6" style="color: var(--text-primary)">Trip Details</h3>
                    <div class="flex items-center justify-between mb-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold" style="color: var(--text-primary)">{{ $order->ticket->waktu_berangkat ?? '08:00' }}</div>
                            <div class="font-medium" style="color: var(--text-secondary)">{{ $order->ticket->asal ?? 'Jakarta' }}</div>
                        </div>
                        <div class="flex-1 mx-8 relative">
                            <div class="border-t-2 border-dashed" style="border-color: var(--border)"></div>
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-10 h-10 rounded-full flex items-center justify-center" style="background: var(--bg-secondary)">
                                <i class="fas fa-plane" style="color: var(--primary)"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold" style="color: var(--text-primary)">{{ $order->ticket->waktu_tiba ?? '10:30' }}</div>
                            <div class="font-medium" style="color: var(--text-secondary)">{{ $order->ticket->tujuan ?? 'Bali' }}</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="p-4 rounded-xl text-center" style="background: var(--bg-tertiary)">
                            <span class="text-xs" style="color: var(--text-muted)">Date</span>
                            <p class="font-bold" style="color: var(--text-primary)">{{ $order->tanggal ?? '-' }}</p>
                        </div>
                        <div class="p-4 rounded-xl text-center" style="background: var(--bg-tertiary)">
                            <span class="text-xs" style="color: var(--text-muted)">Passengers</span>
                            <p class="font-bold" style="color: var(--text-primary)">{{ $order->jumlah_penumpang ?? 1 }}</p>
                        </div>
                        <div class="p-4 rounded-xl text-center" style="background: var(--bg-tertiary)">
                            <span class="text-xs" style="color: var(--text-muted)">Operator</span>
                            <p class="font-bold" style="color: var(--text-primary)">{{ $order->ticket->operator ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="card rounded-2xl p-6">
                    <h3 class="font-bold mb-4" style="color: var(--text-primary)">Passenger Info</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Name</span>
                            <span style="color: var(--text-primary)">{{ $order->nama ?? Auth::user()->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Email</span>
                            <span style="color: var(--text-primary)">{{ $order->email ?? Auth::user()->email }}</span>
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

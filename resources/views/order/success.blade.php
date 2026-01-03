@extends('layouts.app')

@section('title', 'Order Successful - TraveGo')

@section('content')
<section class="min-h-screen flex items-center justify-center py-20" style="background: var(--bg-primary)">
    <div class="max-w-lg mx-auto px-4 text-center">
        <!-- Success Icon -->
        <div class="w-24 h-24 mx-auto mb-8 rounded-full flex items-center justify-center" style="background: rgba(16,185,129,0.1)">
            <i class="fas fa-check text-4xl" style="color: var(--primary)"></i>
        </div>

        <h1 class="font-serif text-4xl font-bold mb-4" style="color: var(--text-primary)">Payment Successful!</h1>
        <p class="text-lg mb-8" style="color: var(--text-muted)">
            Thank you for your booking. Your order has been confirmed and a confirmation email has been sent to your email address.
        </p>

        <!-- Order Details -->
        @if(isset($order))
        <div class="card rounded-2xl p-6 mb-8 text-left">
            <div class="flex items-center justify-between mb-4 pb-4" style="border-bottom: 1px solid var(--border)">
                <span style="color: var(--text-muted)">Order ID</span>
                <span class="font-bold" style="color: var(--text-primary)">#{{ $order->kode_booking ?? $order->order_id }}</span>
            </div>
            @if(isset($type) && $type == 'hotel')
            {{-- HOTEL DETAILS --}}
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                    @if($order->hotel->foto ?? $order->hotel->gambar_url)
                        <img src="{{ $order->hotel->foto ?? $order->hotel->gambar_url }}" alt="" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                            <i class="fas fa-hotel" style="color: var(--text-muted)"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <h4 class="font-bold" style="color: var(--text-primary)">{{ $order->hotel->nama_hotel }}</h4>
                    <p class="text-sm" style="color: var(--text-muted)">
                        <span class="capitalize">{{ $order->tipe_kamar }}</span> • {{ $order->jumlah_malam }} Malam
                    </p>
                </div>
            </div>
            @elseif(isset($type) && $type == 'ticket')
            {{-- TICKET DETAILS --}}
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--bg-tertiary)">
                    @if($order->ticket->jenis_transportasi == 'pesawat')
                        <i class="fas fa-plane text-2xl" style="color: var(--primary)"></i>
                    @elseif($order->ticket->jenis_transportasi == 'kereta')
                        <i class="fas fa-train text-2xl" style="color: var(--accent)"></i>
                    @else
                        <i class="fas fa-bus text-2xl" style="color: var(--text-muted)"></i>
                    @endif
                </div>
                <div>
                    <h4 class="font-bold" style="color: var(--text-primary)">{{ $order->ticket->nama_transportasi }}</h4>
                    <p class="text-sm" style="color: var(--text-muted)">
                        {{ $order->ticket->asal }} <i class="fas fa-arrow-right mx-1 text-xs"></i> {{ $order->ticket->tujuan }}
                    </p>
                </div>
            </div>
            @elseif(isset($order->paketWisata))
            {{-- PAKET DETAILS --}}
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                    @if($order->paketWisata->gambar_url)
                        <img src="{{ $order->paketWisata->gambar_url }}" alt="" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                            <i class="fas fa-image" style="color: var(--text-muted)"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <h4 class="font-bold" style="color: var(--text-primary)">{{ $order->paketWisata->nama_paket }}</h4>
                    <p class="text-sm" style="color: var(--text-muted)">{{ $order->jumlah_peserta }} traveler(s)</p>
                </div>
            </div>
            @endif
            <div class="mt-4 pt-4 flex justify-between" style="border-top: 1px solid var(--border)">
                <span class="font-bold" style="color: var(--text-primary)">Total Paid</span>
                <span class="text-xl font-bold text-gradient">Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @php
                $historyRoute = route('order.history');
                if(isset($type)) {
                    if($type == 'hotel') $historyRoute = route('booking.hotel');
                    elseif($type == 'ticket') $historyRoute = route('booking.tiket');
                }
            @endphp
            <a href="{{ $historyRoute }}" class="btn-primary px-8 py-4 rounded-xl font-semibold">
                <i class="fas fa-receipt mr-2"></i>View My Orders
            </a>
            <a href="{{ route('home') }}" class="px-8 py-4 rounded-xl font-semibold transition-colors" style="background: var(--bg-tertiary); color: var(--text-primary)">
                Back to Home
            </a>
        </div>

        <!-- Support Info -->
        <div class="mt-12 p-4 rounded-xl" style="background: var(--bg-tertiary)">
            <p class="text-sm" style="color: var(--text-muted)">
                <i class="fas fa-info-circle mr-2" style="color: var(--primary)"></i>
                Need help? Contact us at <a href="mailto:support@travego.id" style="color: var(--primary)">support@travego.id</a>
            </p>
        </div>
    </div>
</section>
@endsection

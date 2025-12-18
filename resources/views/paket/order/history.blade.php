@extends('layouts.app')

@section('title', 'Pesanan Saya - TraveGo')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-heading font-bold text-gray-900 dark:text-white mb-8">Pesanan Saya</h1>
    
    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-200 dark:border-dark-700 p-6 hover:border-primary-500/50 transition-colors">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <!-- Order Info -->
                        <div class="flex items-start space-x-4">
                            <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                                @if($order->paketWisata->gambar_url)
                                    <img src="{{ $order->paketWisata->gambar_url }}" alt="{{ $order->paketWisata->nama_paket }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-primary-500 to-accent-500"></div>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-dark-400 mb-1">{{ $order->order_id }}</p>
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $order->paketWisata->nama_paket }}</h3>
                                <p class="text-sm text-gray-500 dark:text-dark-400">
                                    {{ $order->tanggal_berangkat->format('d M Y') }} - {{ $order->jumlah_peserta }} orang
                                </p>
                            </div>
                        </div>
                        
                        <!-- Status & Price -->
                        <div class="flex items-center justify-between md:flex-col md:items-end gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                @if($order->status === 'paid') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                @elseif($order->status === 'expired') bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400
                                @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                @endif">
                                @if($order->status === 'paid') Lunas
                                @elseif($order->status === 'pending') Menunggu Pembayaran
                                @elseif($order->status === 'expired') Kedaluwarsa
                                @elseif($order->status === 'cancelled') Dibatalkan
                                @else {{ ucfirst($order->status) }}
                                @endif
                            </span>
                            <span class="text-lg font-bold text-primary-500">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('order.show', $order) }}" class="px-4 py-2 text-sm font-medium text-primary-500 hover:bg-primary-500/10 rounded-lg transition-colors">
                                Detail
                            </a>
                            @if($order->status === 'pending' && $order->snap_token)
                                <button onclick="payNow('{{ $order->snap_token }}', '{{ $order->order_id }}')" class="px-4 py-2 text-sm font-medium bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors">
                                    Bayar
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <div class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-200 dark:border-dark-700 p-12 text-center">
            <div class="w-20 h-20 bg-gray-100 dark:bg-dark-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-400 dark:text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Pesanan</h2>
            <p class="text-gray-500 dark:text-dark-400 mb-6">Anda belum memiliki pesanan. Mulai jelajahi paket wisata kami!</p>
            <a href="{{ route('paket.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-xl transition-all duration-300">
                Jelajahi Paket Wisata
            </a>
        </div>
    @endif
</div>

<script>
    function payNow(snapToken, orderId) {
        snap.pay(snapToken, {
            onSuccess: function(result) {
                window.location.href = '{{ route("order.success") }}?order_id=' + orderId;
            },
            onPending: function(result) {
                window.location.reload();
            },
            onError: function(result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {}
        });
    }
</script>
@endsection

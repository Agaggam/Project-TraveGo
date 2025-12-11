@extends('layouts.app')

@section('title', 'Detail Pesanan - TraveGo')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-dark-400">
            <li><a href="/" class="hover:text-primary-500">Beranda</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('order.history') }}" class="hover:text-primary-500">Pesanan Saya</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900 dark:text-white">{{ $order->order_id }}</li>
        </ol>
    </nav>

    <div class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-200 dark:border-dark-700 overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200 dark:border-dark-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-dark-400 mb-1">No. Pesanan</p>
                    <h1 class="text-2xl font-heading font-bold text-gray-900 dark:text-white">{{ $order->order_id }}</h1>
                </div>
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium self-start
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
            </div>
        </div>
        
        <!-- Paket Info -->
        <div class="p-6 border-b border-gray-200 dark:border-dark-700">
            <h2 class="font-semibold text-gray-900 dark:text-white mb-4">Paket Wisata</h2>
            <div class="flex items-start space-x-4">
                <div class="w-24 h-24 rounded-xl overflow-hidden flex-shrink-0">
                    @if($order->paketWisata->gambar_url)
                        <img src="{{ $order->paketWisata->gambar_url }}" alt="{{ $order->paketWisata->nama_paket }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-primary-500 to-accent-500"></div>
                    @endif
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white text-lg">{{ $order->paketWisata->nama_paket }}</h3>
                    <p class="text-gray-500 dark:text-dark-400">{{ $order->paketWisata->lokasi }}</p>
                    <p class="text-gray-500 dark:text-dark-400">{{ $order->paketWisata->durasi }}</p>
                </div>
            </div>
        </div>
        
        <!-- Details Grid -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-200 dark:border-dark-700">
            <div>
                <h2 class="font-semibold text-gray-900 dark:text-white mb-4">Data Pemesan</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-dark-400">Nama</span>
                        <span class="text-gray-900 dark:text-white">{{ $order->nama_pemesan }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-dark-400">Email</span>
                        <span class="text-gray-900 dark:text-white">{{ $order->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-dark-400">Telepon</span>
                        <span class="text-gray-900 dark:text-white">{{ $order->phone }}</span>
                    </div>
                </div>
            </div>
            
            <div>
                <h2 class="font-semibold text-gray-900 dark:text-white mb-4">Detail Perjalanan</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-dark-400">Tanggal Berangkat</span>
                        <span class="text-gray-900 dark:text-white">{{ $order->tanggal_berangkat->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-dark-400">Jumlah Peserta</span>
                        <span class="text-gray-900 dark:text-white">{{ $order->jumlah_peserta }} orang</span>
                    </div>
                    @if($order->catatan)
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-dark-400">Catatan</span>
                        <span class="text-gray-900 dark:text-white">{{ $order->catatan }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Payment Info -->
        <div class="p-6 border-b border-gray-200 dark:border-dark-700">
            <h2 class="font-semibold text-gray-900 dark:text-white mb-4">Informasi Pembayaran</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-dark-400">Harga per orang</span>
                    <span class="text-gray-900 dark:text-white">Rp {{ number_format($order->paketWisata->harga, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-dark-400">Jumlah peserta</span>
                    <span class="text-gray-900 dark:text-white">x {{ $order->jumlah_peserta }}</span>
                </div>
                @if($order->payment_type)
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-dark-400">Metode Pembayaran</span>
                    <span class="text-gray-900 dark:text-white">{{ ucwords(str_replace('_', ' ', $order->payment_type)) }}</span>
                </div>
                @endif
                @if($order->paid_at)
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-dark-400">Dibayar pada</span>
                    <span class="text-gray-900 dark:text-white">{{ $order->paid_at->format('d M Y H:i') }}</span>
                </div>
                @endif
                <div class="flex justify-between pt-3 border-t border-gray-200 dark:border-dark-600">
                    <span class="font-semibold text-gray-900 dark:text-white">Total</span>
                    <span class="text-xl font-bold text-primary-500">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="p-6 flex flex-col sm:flex-row gap-4">
            <a href="{{ route('order.history') }}" class="px-6 py-3 border border-gray-300 dark:border-dark-600 text-gray-700 dark:text-dark-300 rounded-xl hover:bg-gray-50 dark:hover:bg-dark-700 transition-all duration-300 font-medium text-center">
                Kembali ke Daftar Pesanan
            </a>
            @if($order->status === 'pending' && $order->snap_token)
                <button onclick="payNow('{{ $order->snap_token }}', '{{ $order->order_id }}')" class="px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-xl transition-all duration-300 text-center">
                    Bayar Sekarang
                </button>
            @endif
        </div>
    </div>
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

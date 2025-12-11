@extends('layouts.app')

@section('title', 'Pesanan Berhasil - TraveGo')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-200 dark:border-dark-700 p-8 text-center">
        <!-- Success Icon -->
        <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        
        <h1 class="text-3xl font-heading font-bold text-gray-900 dark:text-white mb-4">
            @if($order->status === 'paid')
                Pembayaran Berhasil!
            @else
                Pesanan Diterima!
            @endif
        </h1>
        
        <p class="text-gray-600 dark:text-dark-300 mb-8">
            @if($order->status === 'paid')
                Terima kasih! Pembayaran Anda telah kami terima.
            @else
                Silakan selesaikan pembayaran Anda untuk mengkonfirmasi pesanan.
            @endif
        </p>
        
        <!-- Order Details -->
        <div class="bg-gray-50 dark:bg-dark-700 rounded-xl p-6 text-left mb-8">
            <h2 class="font-semibold text-gray-900 dark:text-white mb-4">Detail Pesanan</h2>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-dark-400">No. Pesanan</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $order->order_id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-dark-400">Paket</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $order->paketWisata->nama_paket }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-dark-400">Tanggal Berangkat</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $order->tanggal_berangkat->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-dark-400">Jumlah Peserta</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $order->jumlah_peserta }} orang</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-dark-400">Status</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($order->status === 'paid') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                        @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="flex justify-between pt-3 border-t border-gray-200 dark:border-dark-600">
                    <span class="font-semibold text-gray-900 dark:text-white">Total</span>
                    <span class="font-bold text-primary-500">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('order.history') }}" class="px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-xl transition-all duration-300">
                Lihat Pesanan Saya
            </a>
            <a href="{{ route('paket.index') }}" class="px-6 py-3 border border-gray-300 dark:border-dark-600 text-gray-700 dark:text-dark-300 rounded-xl hover:bg-gray-50 dark:hover:bg-dark-700 transition-all duration-300 font-medium">
                Jelajahi Paket Lain
            </a>
        </div>
    </div>
</div>
@endsection

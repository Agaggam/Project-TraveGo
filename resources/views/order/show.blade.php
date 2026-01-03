@extends('layouts.app')

@section('title', 'Order Details - TraveGo')

@section('content')
<section class="py-12" style="background: var(--bg-primary)">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <button onclick="history.back()" class="inline-flex items-center text-sm font-medium mb-6 cursor-pointer bg-transparent border-0 hover:underline" style="color: var(--primary)">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </button>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Status Card -->
                <div class="card rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-serif text-xl font-bold" style="color: var(--text-primary)">Order #{{ $order->order_id ?? $order->id }}</h2>
                        @php
                            $statusColor = match($order->status ?? 'pending') {
                                'paid', 'success' => 'background: rgba(16,185,129,0.1); color: #10b981',
                                'pending' => 'background: rgba(245,158,11,0.1); color: #f59e0b',
                                'cancelled', 'failed' => 'background: rgba(239,68,68,0.1); color: #ef4444',
                                default => 'background: var(--bg-tertiary); color: var(--text-muted)'
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-sm font-bold uppercase" style="{{ $statusColor }}">
                            {{ $order->status ?? 'pending' }}
                        </span>
                    </div>
                    <p class="text-sm" style="color: var(--text-muted)">
                        Ordered on {{ $order->created_at->format('d F Y, H:i') }}
                    </p>
                </div>

                <!-- Package Info -->
                @if($order->paketWisata)
                <div class="card rounded-2xl overflow-hidden">
                    <div class="aspect-video">
                        @if($order->paketWisata->gambar_url)
                            <img src="{{ $order->paketWisata->gambar_url }}" alt="" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                                <i class="fas fa-image text-4xl" style="color: var(--text-muted)"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="font-serif text-2xl font-bold mb-2" style="color: var(--text-primary)">{{ $order->paketWisata->nama_paket }}</h3>
                        <div class="flex flex-wrap gap-4 text-sm" style="color: var(--text-muted)">
                            <span><i class="fas fa-map-marker-alt mr-1" style="color: var(--primary)"></i>{{ $order->paketWisata->lokasi }}</span>
                            <span><i class="fas fa-clock mr-1" style="color: var(--primary)"></i>{{ $order->paketWisata->durasi }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Trip Details -->
                <div class="card rounded-2xl p-6">
                    <h3 class="font-bold mb-4" style="color: var(--text-primary)">Trip Details</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl" style="background: var(--bg-tertiary)">
                            <span class="text-sm" style="color: var(--text-muted)">Departure Date</span>
                            <p class="font-bold" style="color: var(--text-primary)">{{ \Carbon\Carbon::parse($order->tanggal_berangkat)->format('d F Y') }}</p>
                        </div>
                        <div class="p-4 rounded-xl" style="background: var(--bg-tertiary)">
                            <span class="text-sm" style="color: var(--text-muted)">Travelers</span>
                            <p class="font-bold" style="color: var(--text-primary)">{{ $order->jumlah_peserta ?? 1 }} Person(s)</p>
                        </div>
                    </div>
                </div>

                <!-- Personal Info -->
                <div class="card rounded-2xl p-6">
                    <h3 class="font-bold mb-4" style="color: var(--text-primary)">Personal Information</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Name</span>
                            <span style="color: var(--text-primary)">{{ $order->nama ?? Auth::user()->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Email</span>
                            <span style="color: var(--text-primary)">{{ $order->email ?? Auth::user()->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Phone</span>
                            <span style="color: var(--text-primary)">{{ $order->telepon ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="lg:col-span-1">
                <div class="sticky top-28">
                    <div class="card rounded-2xl p-6">
                        <h3 class="font-bold mb-4" style="color: var(--text-primary)">Payment Summary</h3>
                        
                        <div class="space-y-3 mb-4 pb-4" style="border-bottom: 1px solid var(--border)">
                            <div class="flex justify-between">
                                <span style="color: var(--text-muted)">Price per person</span>
                                <span style="color: var(--text-primary)">Rp {{ number_format($order->paketWisata->harga ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span style="color: var(--text-muted)">Travelers</span>
                                <span style="color: var(--text-primary)">x{{ $order->jumlah_peserta ?? 1 }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-6">
                            <span class="font-bold" style="color: var(--text-primary)">Total</span>
                            <span class="text-2xl font-bold text-gradient">Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}</span>
                        </div>

                        @if(($order->status ?? 'pending') == 'pending')
                            <button class="btn-primary w-full py-3 rounded-xl font-semibold">
                                <i class="fas fa-credit-card mr-2"></i>Complete Payment
                            </button>
                        @endif

                        <div class="mt-4 text-center">
                            <a href="https://wa.me/6281234567890?text={{ urlencode('Hi, I need help with order #' . ($order->order_id ?? $order->id)) }}" 
                               class="text-sm font-medium" style="color: var(--text-muted)">
                                <i class="fab fa-whatsapp mr-1"></i>Need Help?
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

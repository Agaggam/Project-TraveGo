@extends('layouts.app')

@section('title', 'Order History - TraveGo')

@section('content')
<!-- Hero Section -->
<section class="py-16" style="background: linear-gradient(135deg, var(--primary), #0d9488)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-serif text-4xl font-bold text-white mb-2">My Orders</h1>
        <p class="text-white/80">View and manage your travel bookings</p>
    </div>
</section>

<section class="py-12" style="background: var(--bg-primary)">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(isset($orders) && $orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="card rounded-2xl overflow-hidden">
                        <div class="flex flex-col md:flex-row">
                            <!-- Image -->
                            <div class="md:w-48 h-32 md:h-auto flex-shrink-0">
                                @if($order->paketWisata && $order->paketWisata->gambar_url)
                                    <img src="{{ $order->paketWisata->gambar_url }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                                        <i class="fas fa-image text-2xl" style="color: var(--text-muted)"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-1 p-6">
                                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="text-xs font-medium px-2 py-1 rounded" style="background: var(--bg-tertiary); color: var(--text-muted)">
                                                #{{ $order->order_id ?? $order->id }}
                                            </span>
                                            @php
                                                $statusColor = match($order->status ?? 'pending') {
                                                    'paid', 'success' => 'background: rgba(16,185,129,0.1); color: #10b981',
                                                    'pending' => 'background: rgba(245,158,11,0.1); color: #f59e0b',
                                                    'cancelled', 'failed' => 'background: rgba(239,68,68,0.1); color: #ef4444',
                                                    default => 'background: var(--bg-tertiary); color: var(--text-muted)'
                                                };
                                            @endphp
                                            <span class="text-xs font-bold px-2 py-1 rounded uppercase" style="{{ $statusColor }}">
                                                {{ $order->status ?? 'pending' }}
                                            </span>
                                        </div>
                                        <h3 class="font-bold text-lg mb-1" style="color: var(--text-primary)">
                                            {{ $order->paketWisata->nama_paket ?? 'Package' }}
                                        </h3>
                                        <div class="flex flex-wrap gap-4 text-sm" style="color: var(--text-muted)">
                                            <span><i class="fas fa-users mr-1"></i>{{ $order->jumlah_peserta ?? 1 }} traveler(s)</span>
                                            <span><i class="fas fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($order->tanggal_berangkat ?? $order->created_at)->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm" style="color: var(--text-muted)">Total</span>
                                        <div class="text-xl font-bold text-gradient">Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}</div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between mt-4 pt-4" style="border-top: 1px solid var(--border)">
                                    <span class="text-xs" style="color: var(--text-muted)">
                                        Ordered on {{ $order->created_at->format('d M Y, H:i') }}
                                    </span>
                                    <div class="flex gap-3">
                                        @if($order->status == 'paid')
                                            @if($order->review)
                                                <div class="flex flex-col items-end mr-4">
                                                    <div class="flex items-center gap-1 text-yellow-400 text-xs">
                                                        @for($i=1; $i<=5; $i++)
                                                             <i class="{{ $i <= $order->review->rating ? 'fas' : 'far' }} fa-star"></i>
                                                        @endfor
                                                        <span class="text-gray-500 font-medium ml-1">{{ $order->review->rating }}.0</span>
                                                    </div>
                                                    <span class="text-[10px] px-2 py-0.5 rounded-full mt-1 font-medium" style="background: rgba(16,185,129,0.1); color: #10b981">
                                                        <i class="fas fa-check-circle mr-1"></i>Reviewed
                                                    </span>
                                                </div>
                                            @else
                                                <!-- Review Button -->
                                                @php
                                                    $type = $order->paket_wisata_id ? 'paketWisata' : ($order->destinasi_id ? 'destinasi' : 'unknown');
                                                    $id = $order->paket_wisata_id ?? $order->destinasi_id;
                                                @endphp
                                                @if($type != 'unknown')
                                                    <a href="{{ route('review.create', ['type' => $type, 'id' => $id, 'booking_type' => 'Order', 'booking_id' => $order->id]) }}" 
                                                    class="text-sm font-medium hover:underline flex items-center" style="color: var(--accent)">
                                                        <i class="fas fa-star mr-1"></i>Beri Review
                                                    </a>
                                                @endif
                                            @endif
                                        @endif
                                        <a href="{{ route('order.show', $order) }}" class="text-sm font-medium flex items-center" style="color: var(--primary)">
                                            View Details <i class="fas fa-arrow-right ml-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                    <i class="fas fa-receipt text-4xl" style="color: var(--text-muted)"></i>
                </div>
                <h3 class="font-serif text-2xl font-bold mb-2" style="color: var(--text-primary)">No Orders Yet</h3>
                <p class="mb-8" style="color: var(--text-muted)">Start exploring and book your first adventure!</p>
                <a href="{{ route('paket.index') }}" class="btn-primary px-8 py-4 rounded-xl font-semibold inline-block">
                    Browse Packages
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

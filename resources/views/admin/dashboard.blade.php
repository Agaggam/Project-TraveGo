@extends('layouts.admin')

@section('title', 'Dashboard - Admin TraveGo')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    @php
        $stats = [
            ['Total Paket', $totalPaket ?? 0, 'fas fa-box', 'primary', '+12% from last month'],
            ['Total Destinasi', $totalDestinasi ?? 0, 'fas fa-map-marker-alt', 'accent', 'Active locations'],
            ['Total Tiket', $totalTicket ?? 0, 'fas fa-ticket-alt', 'primary', 'Available routes'],
            ['Total Hotel', $totalHotel ?? 0, 'fas fa-hotel', 'accent', 'Partner hotels'],
        ];
    @endphp
    @foreach($stats as $stat)
        <div class="card rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba({{ $stat[3] == 'primary' ? '16,185,129' : '245,158,11' }},0.1)">
                    <i class="{{ $stat[2] }} text-xl" style="color: var(--{{ $stat[3] }})"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold mb-1" style="color: var(--text-primary)">{{ number_format($stat[1]) }}</h3>
            <p class="text-sm" style="color: var(--text-muted)">{{ $stat[0] }}</p>
            <p class="text-xs mt-2" style="color: var(--primary)">{{ $stat[4] }}</p>
        </div>
    @endforeach
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-2">
        <div class="card rounded-2xl p-6">
            <h3 class="font-serif text-xl font-bold mb-6" style="color: var(--text-primary)">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.paket.create') }}" class="p-4 rounded-xl text-center transition-all hover:scale-105" style="background: var(--bg-tertiary)">
                    <i class="fas fa-plus text-2xl mb-2" style="color: var(--primary)"></i>
                    <span class="block text-sm font-medium" style="color: var(--text-secondary)">Add Package</span>
                </a>
                <a href="{{ route('admin.destinasi.create') }}" class="p-4 rounded-xl text-center transition-all hover:scale-105" style="background: var(--bg-tertiary)">
                    <i class="fas fa-map-pin text-2xl mb-2" style="color: var(--accent)"></i>
                    <span class="block text-sm font-medium" style="color: var(--text-secondary)">Add Destination</span>
                </a>
                <a href="{{ route('admin.tickets.create') }}" class="p-4 rounded-xl text-center transition-all hover:scale-105" style="background: var(--bg-tertiary)">
                    <i class="fas fa-plane text-2xl mb-2" style="color: var(--primary)"></i>
                    <span class="block text-sm font-medium" style="color: var(--text-secondary)">Add Ticket</span>
                </a>
                <a href="{{ route('admin.hotels.create') }}" class="p-4 rounded-xl text-center transition-all hover:scale-105" style="background: var(--bg-tertiary)">
                    <i class="fas fa-bed text-2xl mb-2" style="color: var(--accent)"></i>
                    <span class="block text-sm font-medium" style="color: var(--text-secondary)">Add Hotel</span>
                </a>
            </div>
        </div>
    </div>
    <div>
        <div class="card rounded-2xl p-6 h-full">
            <h3 class="font-serif text-xl font-bold mb-4" style="color: var(--text-primary)">System Info</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm" style="color: var(--text-muted)">Laravel</span>
                    <span class="text-sm font-medium" style="color: var(--text-primary)">{{ app()->version() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm" style="color: var(--text-muted)">PHP</span>
                    <span class="text-sm font-medium" style="color: var(--text-primary)">{{ phpversion() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm" style="color: var(--text-muted)">Environment</span>
                    <span class="text-sm font-medium px-2 py-1 rounded" style="background: var(--bg-tertiary); color: var(--primary)">{{ app()->environment() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Items -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Packages -->
    <div class="card rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-serif text-xl font-bold" style="color: var(--text-primary)">Recent Packages</h3>
            <a href="{{ route('admin.paket.index') }}" class="text-sm font-medium" style="color: var(--primary)">View All</a>
        </div>
        <div class="space-y-4">
            @forelse($recentPakets ?? [] as $paket)
                <div class="flex items-center space-x-4 p-3 rounded-xl transition-colors hover:bg-[var(--bg-tertiary)]">
                    <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0" style="background: var(--bg-tertiary)">
                        @if($paket->gambar_url)
                            <img src="{{ $paket->gambar_url }}" alt="{{ $paket->nama_paket }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-image" style="color: var(--text-muted)"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-medium truncate" style="color: var(--text-primary)">{{ $paket->nama_paket }}</h4>
                        <p class="text-sm" style="color: var(--text-muted)">{{ $paket->lokasi }}</p>
                    </div>
                    <span class="font-bold" style="color: var(--primary)">Rp {{ number_format($paket->harga/1000) }}K</span>
                </div>
            @empty
                <p class="text-center py-8" style="color: var(--text-muted)">No packages yet</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Destinations -->
    <div class="card rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-serif text-xl font-bold" style="color: var(--text-primary)">Recent Destinations</h3>
            <a href="{{ route('admin.destinasi.index') }}" class="text-sm font-medium" style="color: var(--primary)">View All</a>
        </div>
        <div class="space-y-4">
            @forelse($recentDestinasis ?? [] as $destinasi)
                <div class="flex items-center space-x-4 p-3 rounded-xl transition-colors hover:bg-[var(--bg-tertiary)]">
                    <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0" style="background: var(--bg-tertiary)">
                        @if($destinasi->gambar_url)
                            <img src="{{ $destinasi->gambar_url }}" alt="{{ $destinasi->nama_destinasi }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-image" style="color: var(--text-muted)"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-medium truncate" style="color: var(--text-primary)">{{ $destinasi->nama_destinasi }}</h4>
                        <p class="text-sm" style="color: var(--text-muted)">{{ $destinasi->kategori }}</p>
                    </div>
                    <span class="px-2 py-1 rounded text-xs font-medium" style="background: var(--bg-tertiary); color: var(--text-muted)">{{ $destinasi->kategori }}</span>
                </div>
            @empty
                <p class="text-center py-8" style="color: var(--text-muted)">No destinations yet</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Additional Widgets Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
    <!-- Pending Reviews -->
    <div class="card rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-serif text-xl font-bold" style="color: var(--text-primary)">Pending Reviews</h3>
            <a href="{{ route('admin.reviews.index') }}" class="text-sm font-medium" style="color: var(--primary)">Manage</a>
        </div>
        <div class="flex items-center justify-center py-8">
            <div class="text-center">
                <div class="w-16 h-16 rounded-2xl mx-auto flex items-center justify-center mb-4" style="background: rgba(245,158,11,0.1)">
                    <i class="fas fa-star text-2xl" style="color: var(--accent)"></i>
                </div>
                <p class="text-3xl font-bold" style="color: var(--text-primary)">{{ $pendingReviews ?? 0 }}</p>
                <p class="text-sm" style="color: var(--text-muted)">Menunggu Persetujuan</p>
            </div>
        </div>
    </div>

    <!-- Active Promos -->
    <div class="card rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-serif text-xl font-bold" style="color: var(--text-primary)">Active Promos</h3>
            <a href="{{ route('admin.promos.index') }}" class="text-sm font-medium" style="color: var(--primary)">Manage</a>
        </div>
        <div class="flex items-center justify-center py-8">
            <div class="text-center">
                <div class="w-16 h-16 rounded-2xl mx-auto flex items-center justify-center mb-4" style="background: rgba(16,185,129,0.1)">
                    <i class="fas fa-tags text-2xl" style="color: var(--primary)"></i>
                </div>
                <p class="text-3xl font-bold" style="color: var(--text-primary)">{{ $activePromos ?? 0 }}</p>
                <p class="text-sm" style="color: var(--text-muted)">Promo Aktif</p>
            </div>
        </div>
    </div>

    <!-- Support Tickets -->
    <div class="card rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-serif text-xl font-bold" style="color: var(--text-primary)">Support Chat</h3>
            <a href="{{ route('admin.support-chat.index') }}" class="text-sm font-medium" style="color: var(--primary)">View All</a>
        </div>
        <div class="flex items-center justify-center py-8">
            <div class="text-center">
                <div class="w-16 h-16 rounded-2xl mx-auto flex items-center justify-center mb-4" style="background: rgba(59,130,246,0.1)">
                    <i class="fas fa-headset text-2xl text-blue-500"></i>
                </div>
                <p class="text-3xl font-bold" style="color: var(--text-primary)">{{ $openChats ?? 0 }}</p>
                <p class="text-sm" style="color: var(--text-muted)">Chat Aktif</p>
            </div>
        </div>
    </div>
</div>
@endsection

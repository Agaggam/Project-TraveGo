@extends('layouts.app')

@section('title', 'Tiket Transportasi - TraveGo')

@section('content')
<!-- Hero -->
<section class="relative min-h-[40vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1920" alt="Travel" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-900/90 to-teal-800/80"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center py-20">
        <h1 class="fade-up font-serif text-4xl sm:text-5xl font-bold text-white mb-4">Tiket Transportasi</h1>
        <p class="fade-up text-lg text-white/80 max-w-2xl mx-auto">Pesan tiket pesawat, kereta, dan bus dengan mudah</p>
    </div>
</section>

<!-- Pencarian & Filter -->
<section class="py-6 sticky top-28 z-30" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('tiket.index') }}" method="GET" class="glass rounded-2xl p-4">
            <div class="flex flex-col lg:flex-row gap-4 items-center">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2" style="color: var(--text-muted)"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari transportasi..."
                        class="w-full pl-12 pr-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">
                </div>
                <div class="flex gap-2 flex-wrap">
                    <a href="{{ route('tiket.index') }}" class="px-4 py-2 rounded-xl font-medium text-sm {{ !request('jenis_transportasi') ? 'text-white' : '' }}"
                        style="{{ !request('jenis_transportasi') ? 'background: var(--primary)' : 'background: var(--bg-tertiary); color: var(--text-secondary)' }}">
                        <i class="fas fa-list mr-1"></i>Semua
                    </a>
                    <a href="{{ route('tiket.index', ['jenis_transportasi' => 'pesawat']) }}" 
                        class="px-4 py-2 rounded-xl font-medium text-sm {{ request('jenis_transportasi') == 'pesawat' ? 'text-white' : '' }}"
                        style="{{ request('jenis_transportasi') == 'pesawat' ? 'background: var(--primary)' : 'background: var(--bg-tertiary); color: var(--text-secondary)' }}">
                        <i class="fas fa-plane mr-1"></i>Pesawat
                    </a>
                    <a href="{{ route('tiket.index', ['jenis_transportasi' => 'kereta']) }}"
                        class="px-4 py-2 rounded-xl font-medium text-sm {{ request('jenis_transportasi') == 'kereta' ? 'text-white' : '' }}"
                        style="{{ request('jenis_transportasi') == 'kereta' ? 'background: var(--primary)' : 'background: var(--bg-tertiary); color: var(--text-secondary)' }}">
                        <i class="fas fa-train mr-1"></i>Kereta
                    </a>
                    <a href="{{ route('tiket.index', ['jenis_transportasi' => 'bus']) }}"
                        class="px-4 py-2 rounded-xl font-medium text-sm {{ request('jenis_transportasi') == 'bus' ? 'text-white' : '' }}"
                        style="{{ request('jenis_transportasi') == 'bus' ? 'background: var(--primary)' : 'background: var(--bg-tertiary); color: var(--text-secondary)' }}">
                        <i class="fas fa-bus mr-1"></i>Bus
                    </a>
                </div>
                <button type="submit" class="btn-primary px-6 py-3 rounded-xl font-medium">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Daftar Tiket -->
<section class="py-12" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($tickets->count() > 0)
            <div class="space-y-4">
                @foreach($tickets as $ticket)
                    <div class="card rounded-2xl p-6 hover:shadow-lg transition-all">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                            <!-- Info Transportasi -->
                            <div class="flex items-center space-x-4 lg:w-1/4">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: var(--bg-tertiary)">
                                    @if($ticket->jenis_transportasi == 'pesawat')
                                        <i class="fas fa-plane text-2xl" style="color: var(--primary)"></i>
                                    @elseif($ticket->jenis_transportasi == 'kereta')
                                        <i class="fas fa-train text-2xl" style="color: var(--accent)"></i>
                                    @else
                                        <i class="fas fa-bus text-2xl" style="color: var(--text-muted)"></i>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold" style="color: var(--text-primary)">{{ $ticket->nama_transportasi }}</h3>
                                    <p class="text-sm" style="color: var(--text-muted)">{{ $ticket->kode_transportasi }} • {{ ucfirst($ticket->kelas) }}</p>
                                </div>
                            </div>

                            <!-- Rute -->
                            <div class="flex items-center justify-center lg:w-1/3">
                                <div class="text-center">
                                    <div class="font-bold text-lg" style="color: var(--text-primary)">{{ $ticket->asal }}</div>
                                    <div class="text-xs" style="color: var(--text-muted)">{{ $ticket->waktu_berangkat->format('H:i') }}</div>
                                </div>
                                <div class="flex-1 mx-4 flex items-center">
                                    <div class="h-px flex-1" style="background: var(--border)"></div>
                                    <div class="px-3 py-1 rounded-full text-xs" style="background: var(--bg-tertiary); color: var(--text-muted)">
                                        {{ $ticket->durasi_menit }} menit
                                    </div>
                                    <div class="h-px flex-1" style="background: var(--border)"></div>
                                </div>
                                <div class="text-center">
                                    <div class="font-bold text-lg" style="color: var(--text-primary)">{{ $ticket->tujuan }}</div>
                                    <div class="text-xs" style="color: var(--text-muted)">{{ $ticket->waktu_tiba->format('H:i') }}</div>
                                </div>
                            </div>

                            <!-- Tanggal -->
                            <div class="text-center lg:w-1/6">
                                <div class="text-sm" style="color: var(--text-muted)">{{ $ticket->waktu_berangkat->format('d M Y') }}</div>
                                <div class="text-xs" style="color: var(--text-muted)">{{ $ticket->tersedia }} kursi tersisa</div>
                            </div>

                            <!-- Harga & Pesan -->
                            <div class="flex items-center justify-between lg:justify-end lg:w-1/4 gap-4">
                                <div class="text-right">
                                    <div class="text-xs" style="color: var(--text-muted)">Mulai dari</div>
                                    <div class="text-xl font-bold" style="color: var(--primary)">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</div>
                                </div>
                                <a href="{{ route('tiket.show', $ticket) }}" class="btn-primary px-6 py-3 rounded-xl font-medium">
                                    Pilih
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $tickets->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-ticket-alt text-5xl mb-4" style="color: var(--text-muted)"></i>
                <h3 class="font-serif text-xl font-bold mb-2" style="color: var(--text-primary)">Tidak Ada Tiket</h3>
                <p style="color: var(--text-muted)">Coba ubah filter pencarian Anda</p>
            </div>
        @endif
    </div>
</section>
@endsection

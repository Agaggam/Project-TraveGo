@extends('layouts.app')

@section('title', 'Promo & Voucher - TraveGo')

@section('content')
<section class="py-12 pt-28 min-h-screen" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <span class="fade-up inline-block px-4 py-2 rounded-full text-sm font-medium mb-4" style="background: rgba(245,158,11,0.1); color: var(--accent)">
                <i class="fas fa-tags mr-2"></i>Promo & Voucher
            </span>
            <h1 class="fade-up font-serif text-4xl sm:text-5xl font-bold mb-4" style="color: var(--text-primary)">
                Hemat Lebih Banyak dengan <span class="text-gradient">Promo Spesial</span>
            </h1>
            <p class="fade-up max-w-2xl mx-auto" style="color: var(--text-muted)">
                Klaim promo dan gunakan saat checkout untuk mendapatkan diskon menarik!
            </p>
        </div>

        <!-- Filter -->
        <div class="card rounded-xl p-4 mb-8">
            <form action="{{ route('promo.index') }}" method="GET" class="flex flex-wrap gap-4 items-center">
                <span class="font-medium" style="color: var(--text-primary)">Filter:</span>
                <a href="{{ route('promo.index') }}" class="px-4 py-2 rounded-xl font-medium transition-all {{ !request('category') ? 'btn-primary' : '' }}" 
                   style="{{ !request('category') ? '' : 'background: var(--bg-tertiary); color: var(--text-muted)' }}">
                    Semua
                </a>
                @foreach($categories as $key => $label)
                    <a href="{{ route('promo.index', ['category' => $key]) }}" 
                       class="px-4 py-2 rounded-xl font-medium transition-all {{ request('category') == $key ? 'btn-primary' : '' }}"
                       style="{{ request('category') == $key ? '' : 'background: var(--bg-tertiary); color: var(--text-muted)' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </form>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl mb-6" style="background: rgba(16,185,129,0.1); color: #10b981">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-xl mb-6" style="background: rgba(239,68,68,0.1); color: #ef4444">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Promo Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($promos as $promo)
                <div class="card rounded-2xl overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                    <!-- Promo Header -->
                    <div class="p-6 text-white relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary), var(--accent))">
                        <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full opacity-10" style="background: white"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-4xl font-bold">
                                    @if($promo->type === 'percentage')
                                        {{ intval($promo->value) }}%
                                    @else
                                        Rp {{ number_format($promo->value / 1000, 0) }}K
                                    @endif
                                </span>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/20">
                                    {{ $promo->type === 'percentage' ? 'DISKON' : 'POTONGAN' }}
                                </span>
                            </div>
                            <h3 class="font-bold text-xl mb-1">{{ $promo->name }}</h3>
                            <p class="text-white/80 text-sm">{{ Str::limit($promo->description, 60) }}</p>
                        </div>
                    </div>

                    <!-- Promo Body -->
                    <div class="p-6">
                        <!-- Code -->
                        <div class="flex items-center justify-between p-3 rounded-xl mb-4" style="background: var(--bg-tertiary); border: 2px dashed var(--border)">
                            <span class="font-mono font-bold text-lg" style="color: var(--primary)">{{ $promo->code }}</span>
                            <button onclick="copyCode('{{ $promo->code }}')" class="px-3 py-1 rounded-lg text-sm font-medium" style="background: var(--primary); color: white">
                                <i class="fas fa-copy mr-1"></i>Copy
                            </button>
                        </div>

                        <!-- Details -->
                        <div class="space-y-2 mb-4">
                            @if($promo->min_order > 0)
                                <div class="flex items-center text-sm" style="color: var(--text-muted)">
                                    <i class="fas fa-shopping-cart w-5 mr-2"></i>
                                    Min. order Rp {{ number_format($promo->min_order, 0, ',', '.') }}
                                </div>
                            @endif
                            @if($promo->max_discount)
                                <div class="flex items-center text-sm" style="color: var(--text-muted)">
                                    <i class="fas fa-cut w-5 mr-2"></i>
                                    Max. diskon Rp {{ number_format($promo->max_discount, 0, ',', '.') }}
                                </div>
                            @endif
                            <div class="flex items-center text-sm" style="color: var(--text-muted)">
                                <i class="fas fa-clock w-5 mr-2"></i>
                                Berlaku s/d {{ $promo->end_date->format('d M Y') }}
                            </div>
                            @if($promo->applicable_to && count($promo->applicable_to) > 0)
                                <div class="flex items-center text-sm" style="color: var(--text-muted)">
                                    <i class="fas fa-tag w-5 mr-2"></i>
                                    @foreach($promo->applicable_to as $type)
                                        <span class="px-2 py-0.5 rounded text-xs mr-1" style="background: var(--bg-tertiary)">{{ ucfirst($type) }}</span>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex items-center text-sm" style="color: var(--text-muted)">
                                    <i class="fas fa-check-circle w-5 mr-2"></i>
                                    Berlaku untuk semua produk
                                </div>
                            @endif
                        </div>

                        <!-- Stock -->
                        @if($promo->usage_limit)
                            @php
                                $remaining = $promo->usage_limit - $promo->used_count;
                                $percentage = ($remaining / $promo->usage_limit) * 100;
                            @endphp
                            <div class="mb-4">
                                <div class="flex justify-between text-xs mb-1" style="color: var(--text-muted)">
                                    <span>Sisa kuota</span>
                                    <span>{{ $remaining }}/{{ $promo->usage_limit }}</span>
                                </div>
                                <div class="h-2 rounded-full overflow-hidden" style="background: var(--bg-tertiary)">
                                    <div class="h-full rounded-full transition-all" style="width: {{ $percentage }}%; background: linear-gradient(135deg, var(--primary), var(--accent))"></div>
                                </div>
                            </div>
                        @endif

                        <!-- Action -->
                        @auth
                            @if(in_array($promo->id, $claimedPromoIds))
                                <button disabled class="w-full py-3 rounded-xl font-medium" style="background: var(--bg-tertiary); color: var(--text-muted)">
                                    <i class="fas fa-check mr-2"></i>Sudah Diklaim
                                </button>
                            @elseif(!$promo->canBeUsed(Auth::id()))
                                <button disabled class="w-full py-3 rounded-xl font-medium" style="background: var(--bg-tertiary); color: var(--text-muted)">
                                    <i class="fas fa-times mr-2"></i>Kuota Habis
                                </button>
                            @else
                                <a href="{{ route('promo.claim', $promo) }}" class="btn-primary w-full py-3 rounded-xl font-medium text-center block">
                                    <i class="fas fa-gift mr-2"></i>Klaim Promo
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-primary w-full py-3 rounded-xl font-medium text-center block">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login untuk Klaim
                            </a>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="card rounded-2xl p-12 text-center">
                        <i class="fas fa-tags text-6xl mb-4" style="color: var(--text-muted)"></i>
                        <h3 class="text-xl font-bold mb-2" style="color: var(--text-primary)">Belum Ada Promo</h3>
                        <p style="color: var(--text-muted)">Promo akan segera hadir. Pantau terus halaman ini!</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($promos->hasPages())
            <div class="mt-8">
                {{ $promos->withQueryString()->links() }}
            </div>
        @endif

        <!-- How to Use -->
        <div class="card rounded-2xl p-8 mt-12">
            <h2 class="font-serif text-2xl font-bold mb-6" style="color: var(--text-primary)">
                <i class="fas fa-question-circle mr-2" style="color: var(--primary)"></i>Cara Menggunakan Promo
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @php
                    $steps = [
                        ['fas fa-gift', 'Pilih Promo', 'Pilih promo yang sesuai dengan kebutuhanmu'],
                        ['fas fa-copy', 'Copy Kode', 'Salin kode promo yang tertera'],
                        ['fas fa-shopping-cart', 'Checkout', 'Lakukan checkout produk yang diinginkan'],
                        ['fas fa-tag', 'Masukkan Kode', 'Paste kode promo dan nikmati diskon!'],
                    ];
                @endphp
                @foreach($steps as $index => $step)
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto rounded-xl flex items-center justify-center mb-4" style="background: rgba(16,185,129,0.1)">
                            <i class="{{ $step[0] }} text-2xl" style="color: var(--primary)"></i>
                        </div>
                        <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center mb-3 text-white font-bold" style="background: var(--primary)">{{ $index + 1 }}</div>
                        <h4 class="font-bold mb-1" style="color: var(--text-primary)">{{ $step[1] }}</h4>
                        <p class="text-sm" style="color: var(--text-muted)">{{ $step[2] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<script>
function copyCode(code) {
    navigator.clipboard.writeText(code).then(function() {
        alert('Kode promo "' + code + '" berhasil disalin!');
    });
}
</script>
@endsection

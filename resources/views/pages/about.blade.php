@extends('layouts.app')

@section('title', 'Tentang Kami - TraveGo')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 overflow-hidden" style="background: linear-gradient(135deg, var(--primary), #0d9488)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h1 class="fade-up font-serif text-4xl sm:text-5xl font-bold text-white mb-4">Tentang TraveGo</h1>
        <p class="fade-up text-lg text-white/80 max-w-2xl mx-auto">Partner terpercaya Anda untuk pengalaman perjalanan tak terlupakan di seluruh Indonesia.</p>
    </div>
</section>

<!-- Our Story -->
<section class="py-24" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="fade-up">
                <span class="inline-block px-4 py-2 rounded-full text-sm font-medium mb-4" style="background: rgba(16,185,129,0.1); color: var(--primary)">Cerita Kami</span>
                <h2 class="font-serif text-4xl font-bold mb-6" style="color: var(--text-primary)">
                    Menghubungkan Traveler dengan <span class="text-gradient">Keindahan Indonesia</span>
                </h2>
                <p class="mb-6 leading-relaxed" style="color: var(--text-secondary)">
                    Didirikan pada tahun 2020, TraveGo lahir dari visi sederhana: membuat eksplorasi keberagaman Indonesia yang luar biasa dapat diakses oleh semua orang. Kami percaya bahwa perjalanan memiliki kekuatan untuk mengubah hidup, menciptakan kenangan abadi, dan menjembatani budaya.
                </p>
                <p class="mb-6 leading-relaxed" style="color: var(--text-secondary)">
                    Yang dimulai sebagai tim kecil yang passionate tentang perjalanan telah berkembang menjadi platform travel digital terkemuka di Indonesia, melayani lebih dari 50.000 traveler bahagia.
                </p>
                <div class="flex gap-4">
                    <a href="{{ route('paket.index') }}" class="btn-primary px-6 py-3 rounded-xl font-medium">Jelajahi Paket</a>
                    <a href="{{ route('kontak') }}" class="px-6 py-3 rounded-xl font-medium border" style="border-color: var(--border); color: var(--text-primary)">Hubungi Kami</a>
                </div>
            </div>
            <div class="fade-up">
                <div class="aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800" alt="Travel" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="py-20" style="background: var(--bg-secondary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach([
                ['500+', 'Destinasi', 'fas fa-map-marker-alt'],
                ['50K+', 'Traveler Puas', 'fas fa-users'],
                ['4.9', 'Rating Rata-rata', 'fas fa-star'],
                ['24/7', 'Layanan Pelanggan', 'fas fa-headset'],
            ] as $index => $stat)
                <div class="scale-up text-center" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background: rgba(16,185,129,0.1)">
                        <i class="{{ $stat[2] }} text-2xl" style="color: var(--primary)"></i>
                    </div>
                    <div class="text-4xl font-serif font-bold mb-2" style="color: var(--text-primary)">{{ $stat[0] }}</div>
                    <div style="color: var(--text-muted)">{{ $stat[1] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Vision & Mission -->
<section class="py-24" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="fade-up font-serif text-4xl font-bold" style="color: var(--text-primary)">Visi & Misi</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="scale-up card p-8 rounded-2xl">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6" style="background: rgba(16,185,129,0.1)">
                    <i class="fas fa-eye text-2xl" style="color: var(--primary)"></i>
                </div>
                <h3 class="font-serif text-2xl font-bold mb-4" style="color: var(--text-primary)">Visi Kami</h3>
                <p style="color: var(--text-secondary)">
                    Menjadi platform travel paling terpercaya dan inovatif di Indonesia, membuat pengalaman perjalanan luar biasa dapat diakses oleh semua orang.
                </p>
            </div>
            <div class="scale-up card p-8 rounded-2xl" style="animation-delay: 0.1s">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6" style="background: rgba(245,158,11,0.1)">
                    <i class="fas fa-bullseye text-2xl" style="color: var(--accent)"></i>
                </div>
                <h3 class="font-serif text-2xl font-bold mb-4" style="color: var(--text-primary)">Misi Kami</h3>
                <p style="color: var(--text-secondary)">
                    Menyediakan layanan perjalanan berkualitas tinggi dan seamless sambil mempromosikan pariwisata berkelanjutan dan mendukung komunitas lokal di seluruh Indonesia.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Team -->
<section class="py-24" style="background: var(--bg-secondary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="fade-up inline-block px-4 py-2 rounded-full text-sm font-medium mb-4" style="background: rgba(245,158,11,0.1); color: var(--accent)">Tim Kami</span>
            <h2 class="fade-up font-serif text-4xl font-bold" style="color: var(--text-primary)">Temui Para Ahli</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['Aria Putra', 'CEO & Founder', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400'],
                ['Maya Kusuma', 'Direktur Operasional', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400'],
                ['Reza Firmansyah', 'Kepala Teknologi', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400'],
            ] as $index => $member)
                <div class="scale-up card rounded-2xl overflow-hidden text-center" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="aspect-square">
                        <img src="{{ $member[2] }}" alt="{{ $member[0] }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h4 class="font-serif text-xl font-bold mb-1" style="color: var(--text-primary)">{{ $member[0] }}</h4>
                        <p style="color: var(--text-muted)">{{ $member[1] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20" style="background: linear-gradient(135deg, var(--primary), #0d9488)">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="fade-up font-serif text-4xl font-bold text-white mb-6">Siap Memulai Perjalanan Anda?</h2>
        <p class="fade-up text-lg text-white/80 mb-8">Bergabunglah dengan ribuan traveler bahagia dan buat pengalaman tak terlupakan bersama TraveGo.</p>
        <a href="{{ route('paket.index') }}" class="fade-up inline-block px-8 py-4 bg-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all" style="color: var(--primary)">
            Jelajahi Paket Sekarang
        </a>
    </div>
</section>
@endsection

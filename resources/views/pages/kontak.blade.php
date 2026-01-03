@extends('layouts.app')

@section('title', 'Kontak - TraveGo')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 overflow-hidden" style="background: linear-gradient(135deg, var(--accent), #ea580c)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h1 class="fade-up font-serif text-4xl sm:text-5xl font-bold text-white mb-4">Hubungi Kami</h1>
        <p class="fade-up text-lg text-white/80 max-w-2xl mx-auto">Ada pertanyaan? Kami siap membantu Anda merencanakan perjalanan sempurna.</p>
    </div>
</section>

<!-- Contact Content -->
<section class="py-24" style="background: var(--bg-primary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Contact Info -->
            <div class="lg:col-span-1 space-y-6">
                <div class="fade-up">
                    <h3 class="font-serif text-2xl font-bold mb-6" style="color: var(--text-primary)">Hubungi Kami</h3>
                    <p class="mb-8" style="color: var(--text-secondary)">Siap memulai petualangan Anda? Hubungi kami untuk perencanaan perjalanan yang dipersonalisasi.</p>
                </div>

                <div class="space-y-4">
                    @foreach([
                        ['fas fa-map-marker-alt', 'Alamat', 'Jl. Sudirman No. 123, Jakarta 12930'],
                        ['fas fa-phone', 'Telepon', '+62 812 3456 7890'],
                        ['fas fa-envelope', 'Email', 'hello@travego.id'],
                        ['fas fa-clock', 'Jam Operasional', 'Sen - Sab: 09:00 - 18:00'],
                    ] as $index => $info)
                        <div class="fade-up card p-4 rounded-xl flex items-start space-x-4" style="animation-delay: {{ $index * 0.1 }}s">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(16,185,129,0.1)">
                                <i class="{{ $info[0] }}" style="color: var(--primary)"></i>
                            </div>
                            <div>
                                <h4 class="font-bold mb-1" style="color: var(--text-primary)">{{ $info[1] }}</h4>
                                <p class="text-sm" style="color: var(--text-muted)">{{ $info[2] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Social Media -->
                <div class="fade-up pt-6">
                    <h4 class="font-bold mb-4" style="color: var(--text-primary)">Ikuti Kami</h4>
                    <div class="flex space-x-3">
                        @foreach(['instagram', 'facebook', 'twitter', 'youtube'] as $social)
                            <a href="#" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:scale-110" style="background: var(--bg-tertiary); color: var(--text-muted)">
                                <i class="fab fa-{{ $social }}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="fade-up card p-8 rounded-2xl">
                    <h3 class="font-serif text-2xl font-bold mb-6" style="color: var(--text-primary)">Kirim Pesan</h3>
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Nama Lengkap</label>
                                <input type="text" placeholder="Nama Anda" class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Alamat Email</label>
                                <input type="email" placeholder="email@anda.com" class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Subjek</label>
                            <input type="text" placeholder="Apa yang bisa kami bantu?" class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                style="background: var(--bg-tertiary); color: var(--text-primary)">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Pesan</label>
                            <textarea rows="5" placeholder="Ceritakan lebih lanjut tentang rencana perjalanan Anda..." class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)] resize-none"
                                style="background: var(--bg-tertiary); color: var(--text-primary)"></textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full py-4 rounded-xl font-semibold">
                            Kirim Pesan <i class="fas fa-paper-plane ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map -->
<section class="py-12" style="background: var(--bg-secondary)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="fade-up rounded-2xl overflow-hidden shadow-xl h-96">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.666520095163!2d106.82251631476896!3d-6.175392995519461!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764b12d%3A0x3d2ad6e1e0e9bcc8!2sMonumen%20Nasional!5e0!3m2!1sen!2sid!4v1640000000000!5m2!1sen!2sid" 
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-24" style="background: var(--bg-primary)">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="fade-up inline-block px-4 py-2 rounded-full text-sm font-medium mb-4" style="background: rgba(16,185,129,0.1); color: var(--primary)">FAQ</span>
            <h2 class="fade-up font-serif text-4xl font-bold" style="color: var(--text-primary)">Pertanyaan Umum</h2>
        </div>

        <div class="space-y-4" x-data="{ open: null }">
            @foreach([
                ['Bagaimana cara membooking paket wisata?', 'Pilih paket yang Anda inginkan, isi form pemesanan, dan lakukan pembayaran melalui metode yang tersedia.'],
                ['Metode pembayaran apa saja yang tersedia?', 'Kami menerima transfer bank, kartu kredit/debit, dan berbagai e-wallet populer.'],
                ['Apakah ada kebijakan pembatalan?', 'Ya, pembatalan gratis hingga 7 hari sebelum keberangkatan. Silakan baca syarat & ketentuan untuk detail lengkap.'],
                ['Bagaimana jika saya memerlukan bantuan selama perjalanan?', 'Tim support kami tersedia 24/7 melalui WhatsApp, telepon, atau email untuk membantu Anda.'],
            ] as $index => $faq)
                <div class="fade-up card rounded-xl overflow-hidden" style="animation-delay: {{ $index * 0.1 }}s">
                    <button @click="open = open === {{ $index }} ? null : {{ $index }}" 
                        class="w-full flex items-center justify-between p-5 text-left">
                        <span class="font-medium" style="color: var(--text-primary)">{{ $faq[0] }}</span>
                        <i class="fas fa-chevron-down transition-transform" :class="open === {{ $index }} ? 'rotate-180' : ''" style="color: var(--text-muted)"></i>
                    </button>
                    <div x-show="open === {{ $index }}" x-transition class="px-5 pb-5">
                        <p style="color: var(--text-secondary)">{{ $faq[1] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

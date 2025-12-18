@extends('layouts.app')

@section('title', 'Tentang Kami - TraveGo')

@section('content')
<!-- Hero Section -->
<section class="relative py-24 overflow-hidden">
    <div class="absolute top-1/4 left-10 w-72 h-72 bg-primary-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 right-10 w-96 h-96 bg-accent-500/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <span class="text-primary-500 font-semibold text-sm uppercase tracking-wider">Tentang Kami</span>
            <h1 class="font-heading text-5xl sm:text-6xl font-bold mt-4 mb-6 text-gray-900 dark:text-white">
                Mengenal Lebih Dekat <span class="gradient-text">TraveGo</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-dark-300 max-w-3xl mx-auto leading-relaxed">
                Kami adalah platform travel terpercaya yang berkomitmen menghadirkan pengalaman wisata terbaik untuk menjelajahi keindahan Indonesia.
            </p>
        </div>
    </div>
</section>

<!-- Our Story -->
<section class="py-24 bg-gray-100/50 dark:bg-dark-900/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <span class="text-primary-500 font-semibold text-sm uppercase tracking-wider">Cerita Kami</span>
                <h2 class="font-heading text-4xl font-bold mt-4 mb-6 text-gray-900 dark:text-white">
                    Perjalanan Kami <span class="gradient-text">Dimulai</span>
                </h2>
                <p class="text-gray-600 dark:text-dark-300 mb-6 leading-relaxed">
                    TraveGo didirikan pada tahun 2020 dengan visi sederhana: membuat perjalanan wisata menjadi lebih mudah, terjangkau, dan menyenangkan bagi semua orang.
                </p>
                <p class="text-gray-600 dark:text-dark-300 mb-6 leading-relaxed">
                    Berawal dari kecintaan kami terhadap keindahan alam Indonesia, kami membangun platform yang menghubungkan wisatawan dengan destinasi-destinasi menakjubkan di seluruh Nusantara.
                </p>
                <p class="text-gray-600 dark:text-dark-300 leading-relaxed">
                    Hingga saat ini, kami telah membantu ribuan pelanggan mewujudkan liburan impian mereka dengan layanan yang profesional dan harga yang kompetitif.
                </p>
            </div>
            <div class="relative">
                <div class="aspect-square rounded-3xl bg-gradient-to-br from-primary-500 to-accent-500 p-1">
                    <div class="w-full h-full rounded-3xl bg-gray-200 dark:bg-dark-800 flex items-center justify-center">
                        <svg class="w-32 h-32 text-primary-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center p-8 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50">
                <div class="text-4xl font-heading font-bold gradient-text mb-2">5000+</div>
                <p class="text-gray-500 dark:text-dark-400">Pelanggan Puas</p>
            </div>
            <div class="text-center p-8 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50">
                <div class="text-4xl font-heading font-bold gradient-text mb-2">100+</div>
                <p class="text-gray-500 dark:text-dark-400">Destinasi</p>
            </div>
            <div class="text-center p-8 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50">
                <div class="text-4xl font-heading font-bold gradient-text mb-2">50+</div>
                <p class="text-gray-500 dark:text-dark-400">Paket Wisata</p>
            </div>
            <div class="text-center p-8 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50">
                <div class="text-4xl font-heading font-bold gradient-text mb-2">4.9</div>
                <p class="text-gray-500 dark:text-dark-400">Rating</p>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission -->
<section class="py-24 bg-gray-100/50 dark:bg-dark-900/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-primary-500 font-semibold text-sm uppercase tracking-wider">Visi & Misi</span>
            <h2 class="font-heading text-4xl sm:text-5xl font-bold mt-4 text-gray-900 dark:text-white">
                Komitmen <span class="gradient-text">Kami</span>
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="p-8 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 card-hover transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-500/20 to-primary-600/20 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h3 class="font-heading text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Visi</h3>
                <p class="text-gray-600 dark:text-dark-300 leading-relaxed">
                    Menjadi platform travel terdepan di Indonesia yang menginspirasi jutaan orang untuk menjelajahi keindahan Nusantara dan dunia dengan cara yang mudah, aman, dan menyenangkan.
                </p>
            </div>
            <div class="p-8 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 card-hover transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-accent-500/20 to-accent-600/20 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="font-heading text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Misi</h3>
                <ul class="text-gray-600 dark:text-dark-300 space-y-3">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Menyediakan paket wisata berkualitas dengan harga terjangkau
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Memberikan pelayanan prima dengan dukungan 24/7
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-primary-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Mendukung pariwisata lokal dan pemberdayaan masyarakat
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Team -->
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-primary-500 font-semibold text-sm uppercase tracking-wider">Tim Kami</span>
            <h2 class="font-heading text-4xl sm:text-5xl font-bold mt-4 mb-6 text-gray-900 dark:text-white">
                Orang-Orang di Balik <span class="gradient-text">TraveGo</span>
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-8 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 card-hover transition-all duration-300">
                <div class="w-24 h-24 bg-gradient-to-br from-primary-500 to-accent-500 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <span class="text-3xl font-heading font-bold text-white">A</span>
                </div>
                <h3 class="font-heading text-xl font-semibold text-gray-900 dark:text-white mb-1">Ahmad Pratama</h3>
                <p class="text-primary-500 text-sm mb-4">Founder & CEO</p>
                <p class="text-gray-500 dark:text-dark-400 text-sm">Visioner dengan pengalaman 10+ tahun di industri pariwisata</p>
            </div>
            <div class="text-center p-8 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 card-hover transition-all duration-300">
                <div class="w-24 h-24 bg-gradient-to-br from-accent-500 to-primary-500 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <span class="text-3xl font-heading font-bold text-white">S</span>
                </div>
                <h3 class="font-heading text-xl font-semibold text-gray-900 dark:text-white mb-1">Siti Rahayu</h3>
                <p class="text-primary-500 text-sm mb-4">Head of Operations</p>
                <p class="text-gray-500 dark:text-dark-400 text-sm">Ahli dalam manajemen operasional dan customer experience</p>
            </div>
            <div class="text-center p-8 rounded-2xl bg-white dark:bg-dark-800/50 border border-gray-200 dark:border-dark-700/50 card-hover transition-all duration-300">
                <div class="w-24 h-24 bg-gradient-to-br from-primary-500 to-accent-500 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <span class="text-3xl font-heading font-bold text-white">B</span>
                </div>
                <h3 class="font-heading text-xl font-semibold text-gray-900 dark:text-white mb-1">Budi Santoso</h3>
                <p class="text-primary-500 text-sm mb-4">Head of Technology</p>
                <p class="text-gray-500 dark:text-dark-400 text-sm">Tech enthusiast dengan passion di digital innovation</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-24 bg-gray-100/50 dark:bg-dark-900/50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-heading text-4xl sm:text-5xl font-bold mb-6 text-gray-900 dark:text-white">
            Siap Menjelajah Bersama <span class="gradient-text">Kami</span>?
        </h2>
        <p class="text-gray-600 dark:text-dark-300 text-lg mb-10 max-w-2xl mx-auto">
            Mari wujudkan petualangan impian Anda bersama TraveGo.
        </p>
        <a href="{{ route('paket.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 text-white font-semibold rounded-xl transition-all duration-300 text-lg glow-primary">
            Lihat Paket Wisata
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
        </a>
    </div>
</section>
@endsection

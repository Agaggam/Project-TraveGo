<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TraveGo - Jelajahi Dunia Tanpa Batas</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-text {
            background: linear-gradient(135deg, #00afaf 0%, #ff8c00 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .gradient-border {
            border: 2px solid transparent;
            background: linear-gradient(#0d0d0d, #0d0d0d) padding-box,
                        linear-gradient(135deg, #00afaf 0%, #ff8c00 100%) border-box;
        }
        .glow-primary {
            box-shadow: 0 0 40px rgba(0, 175, 175, 0.3);
        }
        .glow-accent {
            box-shadow: 0 0 40px rgba(255, 140, 0, 0.3);
        }
        .hero-gradient {
            background: radial-gradient(ellipse at top, rgba(0, 175, 175, 0.15) 0%, transparent 50%),
                        radial-gradient(ellipse at bottom right, rgba(255, 140, 0, 0.1) 0%, transparent 50%);
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 175, 175, 0.25);
        }
        .nav-blur {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</head>
<body class="bg-dark-950 text-white antialiased">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 nav-blur bg-dark-950/80 border-b border-dark-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-accent-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-heading font-bold gradient-text">TraveGo</span>
                </a>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-dark-200 hover:text-primary-400 transition-colors font-medium">Beranda</a>
                    <a href="#fitur" class="text-dark-200 hover:text-primary-400 transition-colors font-medium">Fitur</a>
                    <a href="#harga" class="text-dark-200 hover:text-primary-400 transition-colors font-medium">Harga</a>
                    <a href="#tentang" class="text-dark-200 hover:text-primary-400 transition-colors font-medium">Tentang</a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/home') }}" class="px-6 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-xl transition-all duration-300">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-dark-200 hover:text-white transition-colors font-medium">
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-xl transition-all duration-300 glow-primary">
                                    Daftar Gratis
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative min-h-screen flex items-center justify-center hero-gradient overflow-hidden pt-20">
        <!-- Decorative Elements -->
        <div class="absolute top-1/4 left-10 w-72 h-72 bg-primary-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-10 w-96 h-96 bg-accent-500/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-dark-800/80 border border-dark-600 mb-8">
                    <span class="w-2 h-2 bg-primary-500 rounded-full mr-2 animate-pulse"></span>
                    <span class="text-sm text-dark-200">Platform Travel #1 di Indonesia</span>
                </div>
                
                <!-- Headline -->
                <h1 class="font-heading text-5xl sm:text-6xl lg:text-7xl font-bold mb-6 leading-tight">
                    Jelajahi Dunia<br>
                    <span class="gradient-text">Tanpa Batas</span>
                </h1>
                
                <!-- Subheadline -->
                <p class="text-xl text-dark-300 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Temukan destinasi impian Anda dengan mudah. Booking tiket, hotel, dan paket wisata 
                    dengan harga terbaik hanya dalam hitungan menit.
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-xl transition-all duration-300 glow-primary text-lg">
                        Mulai Sekarang
                        <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                    <a href="#fitur" class="px-8 py-4 gradient-border rounded-xl text-white font-semibold hover:bg-dark-800 transition-all duration-300">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                    <div class="text-center">
                        <div class="text-4xl font-heading font-bold gradient-text mb-2">500+</div>
                        <div class="text-dark-400">Destinasi</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-heading font-bold gradient-text mb-2">50K+</div>
                        <div class="text-dark-400">Pengguna</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-heading font-bold gradient-text mb-2">99%</div>
                        <div class="text-dark-400">Kepuasan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-heading font-bold gradient-text mb-2">24/7</div>
                        <div class="text-dark-400">Dukungan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-24 bg-dark-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="text-primary-400 font-semibold text-sm uppercase tracking-wider">Fitur Unggulan</span>
                <h2 class="font-heading text-4xl sm:text-5xl font-bold mt-4 mb-6">
                    Mengapa Memilih <span class="gradient-text">TraveGo</span>?
                </h2>
                <p class="text-dark-300 max-w-2xl mx-auto text-lg">
                    Kami menyediakan berbagai fitur terbaik untuk memastikan perjalanan Anda menyenangkan dan tanpa hambatan.
                </p>
            </div>
            
            <!-- Features Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 rounded-2xl bg-dark-800/50 border border-dark-700/50 card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary-500/20 to-primary-600/20 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-heading text-xl font-semibold mb-3">Pencarian Mudah</h3>
                    <p class="text-dark-400 leading-relaxed">
                        Cari destinasi, hotel, dan tiket dengan fitur pencarian cerdas yang memberikan hasil akurat dalam hitungan detik.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="p-8 rounded-2xl bg-dark-800/50 border border-dark-700/50 card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-accent-500/20 to-accent-600/20 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-heading text-xl font-semibold mb-3">Harga Terbaik</h3>
                    <p class="text-dark-400 leading-relaxed">
                        Dapatkan penawaran harga terbaik dengan perbandingan real-time dari berbagai penyedia layanan travel.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="p-8 rounded-2xl bg-dark-800/50 border border-dark-700/50 card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary-500/20 to-accent-500/20 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="font-heading text-xl font-semibold mb-3">Pembayaran Aman</h3>
                    <p class="text-dark-400 leading-relaxed">
                        Transaksi aman dengan berbagai metode pembayaran terpercaya dan enkripsi data tingkat tinggi.
                    </p>
                </div>
                
                <!-- Feature 4 -->
                <div class="p-8 rounded-2xl bg-dark-800/50 border border-dark-700/50 card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-accent-500/20 to-primary-500/20 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-heading text-xl font-semibold mb-3">Akses Mobile</h3>
                    <p class="text-dark-400 leading-relaxed">
                        Kelola booking Anda kapan saja dan di mana saja melalui website responsif atau aplikasi mobile kami.
                    </p>
                </div>
                
                <!-- Feature 5 -->
                <div class="p-8 rounded-2xl bg-dark-800/50 border border-dark-700/50 card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary-500/20 to-primary-600/20 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-heading text-xl font-semibold mb-3">Dukungan 24/7</h3>
                    <p class="text-dark-400 leading-relaxed">
                        Tim customer service kami siap membantu Anda kapan saja, baik melalui chat, email, atau telepon.
                    </p>
                </div>
                
                <!-- Feature 6 -->
                <div class="p-8 rounded-2xl bg-dark-800/50 border border-dark-700/50 card-hover transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-accent-500/20 to-accent-600/20 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                    </div>
                    <h3 class="font-heading text-xl font-semibold mb-3">Promo Eksklusif</h3>
                    <p class="text-dark-400 leading-relaxed">
                        Nikmati diskon dan penawaran eksklusif setiap bulannya untuk member setia TraveGo.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="harga" class="py-24 relative">
        <!-- Background decorations -->
        <div class="absolute top-1/2 left-0 w-96 h-96 bg-primary-500/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-accent-500/5 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="text-primary-400 font-semibold text-sm uppercase tracking-wider">Pilihan Paket</span>
                <h2 class="font-heading text-4xl sm:text-5xl font-bold mt-4 mb-6">
                    Paket <span class="gradient-text">Membership</span>
                </h2>
                <p class="text-dark-300 max-w-2xl mx-auto text-lg">
                    Pilih paket yang sesuai dengan kebutuhan perjalanan Anda dan nikmati berbagai keuntungan eksklusif.
                </p>
            </div>
            
            <!-- Pricing Cards -->
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Basic Plan -->
                <div class="p-8 rounded-2xl bg-dark-800/50 border border-dark-700/50 transition-all duration-300 hover:border-dark-600">
                    <div class="text-center mb-8">
                        <h3 class="font-heading text-xl font-semibold mb-2">Basic</h3>
                        <p class="text-dark-400 text-sm mb-6">Untuk traveler pemula</p>
                        <div class="flex items-baseline justify-center">
                            <span class="text-dark-400 text-lg">Rp</span>
                            <span class="font-heading text-5xl font-bold mx-1">0</span>
                            <span class="text-dark-400">/bulan</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-dark-300">
                            <svg class="w-5 h-5 text-primary-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Akses destinasi dasar
                        </li>
                        <li class="flex items-center text-dark-300">
                            <svg class="w-5 h-5 text-primary-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Booking tiket & hotel
                        </li>
                        <li class="flex items-center text-dark-300">
                            <svg class="w-5 h-5 text-primary-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Email support
                        </li>
                        <li class="flex items-center text-dark-500">
                            <svg class="w-5 h-5 text-dark-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Diskon member
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-3 text-center rounded-xl border border-dark-600 text-white font-semibold hover:bg-dark-700 transition-all duration-300">
                        Mulai Gratis
                    </a>
                </div>
                
                <!-- Pro Plan (Featured) -->
                <div class="p-8 rounded-2xl bg-gradient-to-b from-dark-800 to-dark-800/50 border-2 border-primary-500/50 relative transform scale-105 glow-primary">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="px-4 py-1 bg-gradient-to-r from-primary-500 to-accent-500 text-white text-sm font-semibold rounded-full">
                            Populer
                        </span>
                    </div>
                    <div class="text-center mb-8">
                        <h3 class="font-heading text-xl font-semibold mb-2">Pro</h3>
                        <p class="text-dark-400 text-sm mb-6">Untuk traveler aktif</p>
                        <div class="flex items-baseline justify-center">
                            <span class="text-dark-400 text-lg">Rp</span>
                            <span class="font-heading text-5xl font-bold gradient-text mx-1">99K</span>
                            <span class="text-dark-400">/bulan</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-dark-300">
                            <svg class="w-5 h-5 text-primary-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Semua fitur Basic
                        </li>
                        <li class="flex items-center text-dark-300">
                            <svg class="w-5 h-5 text-primary-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Diskon 10% semua booking
                        </li>
                        <li class="flex items-center text-dark-300">
                            <svg class="w-5 h-5 text-primary-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Priority support 24/7
                        </li>
                        <li class="flex items-center text-dark-300">
                            <svg class="w-5 h-5 text-primary-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Akses promo eksklusif
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-3 text-center rounded-xl bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold hover:from-primary-600 hover:to-primary-700 transition-all duration-300">
                        Berlangganan
                    </a>
                </div>
                
                <!-- Enterprise Plan -->
                <div class="p-8 rounded-2xl bg-dark-800/50 border border-dark-700/50 transition-all duration-300 hover:border-dark-600">
                    <div class="text-center mb-8">
                        <h3 class="font-heading text-xl font-semibold mb-2">Enterprise</h3>
                        <p class="text-dark-400 text-sm mb-6">Untuk bisnis & korporat</p>
                        <div class="flex items-baseline justify-center">
                            <span class="text-dark-400 text-lg">Rp</span>
                            <span class="font-heading text-5xl font-bold mx-1">499K</span>
                            <span class="text-dark-400">/bulan</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-dark-300">
                            <svg class="w-5 h-5 text-primary-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Semua fitur Pro
                        </li>
                        <li class="flex items-center text-dark-300">
                            <svg class="w-5 h-5 text-primary-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Diskon hingga 25%
                        </li>
                        <li class="flex items-center text-dark-300">
                            <svg class="w-5 h-5 text-primary-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Dedicated account manager
                        </li>
                        <li class="flex items-center text-dark-300">
                            <svg class="w-5 h-5 text-primary-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            API access & integrasi
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-3 text-center rounded-xl border border-dark-600 text-white font-semibold hover:bg-dark-700 transition-all duration-300">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-dark-900/50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-heading text-4xl sm:text-5xl font-bold mb-6">
                Siap Memulai <span class="gradient-text">Petualangan</span>?
            </h2>
            <p class="text-dark-300 text-lg mb-10 max-w-2xl mx-auto">
                Bergabung dengan ribuan traveler lainnya dan mulai jelajahi destinasi impian Anda hari ini.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 text-white font-semibold rounded-xl transition-all duration-300 text-lg">
                    Daftar Sekarang - Gratis!
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="tentang" class="bg-dark-950 border-t border-dark-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <!-- Brand -->
                <div class="md:col-span-1">
                    <a href="/" class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-accent-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-heading font-bold gradient-text">TraveGo</span>
                    </a>
                    <p class="text-dark-400 text-sm leading-relaxed">
                        Platform travel terpercaya untuk menjelajahi dunia tanpa batas. Temukan destinasi impian Anda bersama kami.
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-heading font-semibold mb-6">Tautan Cepat</h4>
                    <ul class="space-y-3">
                        <li><a href="#beranda" class="text-dark-400 hover:text-primary-400 transition-colors">Beranda</a></li>
                        <li><a href="#fitur" class="text-dark-400 hover:text-primary-400 transition-colors">Fitur</a></li>
                        <li><a href="#harga" class="text-dark-400 hover:text-primary-400 transition-colors">Harga</a></li>
                        <li><a href="#" class="text-dark-400 hover:text-primary-400 transition-colors">Tentang Kami</a></li>
                    </ul>
                </div>
                
                <!-- Services -->
                <div>
                    <h4 class="font-heading font-semibold mb-6">Layanan</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-dark-400 hover:text-primary-400 transition-colors">Booking Tiket</a></li>
                        <li><a href="#" class="text-dark-400 hover:text-primary-400 transition-colors">Reservasi Hotel</a></li>
                        <li><a href="#" class="text-dark-400 hover:text-primary-400 transition-colors">Paket Wisata</a></li>
                        <li><a href="#" class="text-dark-400 hover:text-primary-400 transition-colors">Travel Guide</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="font-heading font-semibold mb-6">Kontak</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center text-dark-400">
                            <svg class="w-5 h-5 mr-3 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            info@travego.id
                        </li>
                        <li class="flex items-center text-dark-400">
                            <svg class="w-5 h-5 mr-3 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            +62 812 3456 7890
                        </li>
                        <li class="flex items-start text-dark-400">
                            <svg class="w-5 h-5 mr-3 mt-1 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Jakarta, Indonesia
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Divider -->
            <div class="border-t border-dark-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-dark-500 text-sm mb-4 md:mb-0">
                    &copy; {{ date('Y') }} TraveGo. Seluruh hak cipta dilindungi.
                </p>
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-dark-400 hover:text-primary-400 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="text-dark-400 hover:text-primary-400 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/></svg>
                    </a>
                    <a href="#" class="text-dark-400 hover:text-primary-400 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Midtrans Script -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TraveGo - Jelajahi Indonesia')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Poppins', sans-serif; }
        .gradient-text {
            background: linear-gradient(135deg, #00afaf 0%, #ff8c00 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .gradient-border {
            border: 2px solid transparent;
            background: linear-gradient(var(--bg-color, #0d0d0d), var(--bg-color, #0d0d0d)) padding-box,
                        linear-gradient(135deg, #00afaf 0%, #ff8c00 100%) border-box;
        }
        .dark .gradient-border { --bg-color: #0d0d0d; }
        .gradient-border { --bg-color: #ffffff; }
        .glow-primary { box-shadow: 0 0 40px rgba(0, 175, 175, 0.3); }
        .nav-blur { backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(0, 175, 175, 0.25); }
    </style>
</head>
<body class="min-h-screen antialiased transition-colors duration-300 bg-gray-50 dark:bg-dark-950 text-gray-900 dark:text-white">
    <nav class="fixed top-0 left-0 right-0 z-50 nav-blur border-b transition-colors duration-300 bg-white/80 dark:bg-dark-950/80 border-gray-200 dark:border-dark-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-accent-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-heading font-bold gradient-text">TraveGo</span>
                    </a>
                    <div class="hidden md:flex ml-10 space-x-8">
                        <a href="/" class="text-gray-600 dark:text-dark-200 hover:text-primary-500 dark:hover:text-primary-400 transition-colors font-medium">Beranda</a>
                        <a href="{{ route('paket.index') }}" class="text-gray-600 dark:text-dark-200 hover:text-primary-500 dark:hover:text-primary-400 transition-colors font-medium">Paket Wisata</a>
                        <a href="{{ route('destinasi') }}" class="text-gray-600 dark:text-dark-200 hover:text-primary-500 dark:hover:text-primary-400 transition-colors font-medium">Destinasi</a>
                        <a href="{{ route('about') }}" class="text-gray-600 dark:text-dark-200 hover:text-primary-500 dark:hover:text-primary-400 transition-colors font-medium">Tentang Kami</a>
                        <a href="{{ route('kontak') }}" class="text-gray-600 dark:text-dark-200 hover:text-primary-500 dark:hover:text-primary-400 transition-colors font-medium">Kontak</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Theme Toggle -->
                    <button @click="darkMode = !darkMode" class="p-2 rounded-xl text-gray-500 dark:text-dark-400 hover:bg-gray-100 dark:hover:bg-dark-800 transition-colors">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>
                    
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-600 dark:text-dark-200 hover:text-gray-900 dark:hover:text-white transition-colors font-medium">Masuk</a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-xl transition-all duration-300 glow-primary">Daftar</a>
                    @else
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center text-gray-600 dark:text-dark-200 hover:text-gray-900 dark:hover:text-white py-2 font-medium">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="ml-1 w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white dark:bg-dark-800 border border-gray-200 dark:border-dark-700 rounded-xl shadow-lg py-1 z-50">
                                @if(!Auth::user()->isAdmin())
                                    <a href="{{ route('order.history') }}" class="block px-4 py-2 text-gray-700 dark:text-dark-200 hover:bg-gray-100 dark:hover:bg-dark-700">Pesanan Saya</a>
                                @endif
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 dark:text-dark-200 hover:bg-gray-100 dark:hover:bg-dark-700">Dashboard Admin</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 dark:text-dark-200 hover:bg-gray-100 dark:hover:bg-dark-700">Keluar</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-20">
        @yield('content')
    </main>

    <footer class="border-t py-16 mt-16 transition-colors duration-300 bg-white dark:bg-dark-950 border-gray-200 dark:border-dark-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
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
                    <p class="text-gray-500 dark:text-dark-400 text-sm leading-relaxed">
                        Platform travel terpercaya untuk menjelajahi dunia tanpa batas.
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-heading font-semibold mb-6 text-gray-900 dark:text-white">Tautan Cepat</h4>
                    <ul class="space-y-3">
                        <li><a href="/" class="text-gray-500 dark:text-dark-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('paket.index') }}" class="text-gray-500 dark:text-dark-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">Paket Wisata</a></li>
                        <li><a href="{{ route('destinasi') }}" class="text-gray-500 dark:text-dark-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">Destinasi</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-500 dark:text-dark-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('kontak') }}" class="text-gray-500 dark:text-dark-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">Kontak</a></li>
                    </ul>
                </div>
                
                <!-- Services -->
                <div>
                    <h4 class="font-heading font-semibold mb-6 text-gray-900 dark:text-white">Layanan</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-500 dark:text-dark-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">Booking Tiket</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-dark-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">Reservasi Hotel</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-dark-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">Paket Wisata</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="font-heading font-semibold mb-6 text-gray-900 dark:text-white">Kontak</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-500 dark:text-dark-400">
                            <svg class="w-5 h-5 mr-3 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            info@travego.id
                        </li>
                        <li class="flex items-center text-gray-500 dark:text-dark-400">
                            <svg class="w-5 h-5 mr-3 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            +62 812 3456 7890
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Divider -->
            <div class="border-t border-gray-200 dark:border-dark-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 dark:text-dark-500 text-sm mb-4 md:mb-0">
                    &copy; {{ date('Y') }} TraveGo. Seluruh hak cipta dilindungi.
                </p>
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-gray-400 dark:text-dark-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 dark:text-dark-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
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

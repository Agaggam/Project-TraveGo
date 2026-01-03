<!DOCTYPE html>
<html lang="id" x-data="themeManager()" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TraveGo - Jelajahi Indonesia')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            /* Light Mode */
            --bg-primary: #faf7f2;
            --bg-secondary: #ffffff;
            --bg-tertiary: #f5f0e8;
            --text-primary: #1a1a2e;
            --text-secondary: #4a4a5a;
            --text-muted: #8a8a9a;
            --primary: #047857;
            --primary-light: #10b981;
            --accent: #d97706;
            --accent-light: #f59e0b;
            --border: rgba(0,0,0,0.08);
            --shadow: rgba(0,0,0,0.1);
            --glass-bg: rgba(255,255,255,0.7);
            --glass-border: rgba(255,255,255,0.5);
        }
        
        .dark {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-tertiary: #334155;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --primary: #10b981;
            --primary-light: #34d399;
            --accent: #f59e0b;
            --accent-light: #fbbf24;
            --border: rgba(255,255,255,0.1);
            --shadow: rgba(0,0,0,0.3);
            --glass-bg: rgba(30,41,59,0.8);
            --glass-border: rgba(255,255,255,0.1);
        }

        * { 
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
        h1, h2, h3, .font-serif { font-family: 'Playfair Display', serif; }
        
        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }
        
        /* Glass Effect */
        .glass {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
        }
        
        /* Gradient Text */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(16, 185, 129, 0.3);
        }
        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 5px 20px rgba(16, 185, 129, 0.2);
        }
        
        .btn-accent {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            color: white;
        }
        
        /* Cards */
        .card {
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            transition: all 0.4s ease;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px var(--shadow);
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg-primary); }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 4px; }
        
        /* Animations */
        .fade-up {
            opacity: 0;
            transform: translateY(40px);
        }
        .fade-in {
            opacity: 0;
        }
        .scale-up {
            opacity: 0;
            transform: scale(0.9);
        }
        
        /* Theme Toggle */
        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--bg-tertiary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--text-muted);
        }
        .theme-toggle:hover {
            background: var(--bg-secondary);
            color: var(--primary);
        }
        
        /* Parallax */
        .parallax {
            transform: translateY(calc(var(--scroll) * 0.3px));
        }
        
        /* ClickSpark Effect */
        .click-spark {
            position: fixed;
            pointer-events: none;
            z-index: 9999;
        }
        .spark {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary);
            animation: spark-fade 0.6s ease-out forwards;
        }
        @keyframes spark-fade {
            0% {
                opacity: 1;
                transform: translate(0, 0) scale(1);
            }
            100% {
                opacity: 0;
                transform: translate(var(--tx), var(--ty)) scale(0);
            }
        }
    </style>
</head>
<body x-data="{ mobileMenu: false, scrolled: false }" 
      x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 100 })"
      @scroll.window="scrolled = window.scrollY > 100">
    
    <!-- Navbar - Only visible after scrolling -->
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
         :class="scrolled ? 'translate-y-0 opacity-100' : '-translate-y-full opacity-0'"
         id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="glass rounded-2xl px-6 py-3 shadow-lg">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <a href="/" class="flex items-center space-x-3 group">
                        <div class="w-12 h-12 rounded-xl overflow-hidden shadow-md group-hover:shadow-lg transition-shadow">
                            <img src="{{ asset('images/logo.png') }}" width="48" height="48" style="width:48px;height:48px;" class="w-full h-full object-cover" alt="TraveGo">
                        </div>
                        <div>
                            <span class="text-xl font-serif font-bold" style="color: var(--text-primary)">Trave<span style="color: var(--primary)">Go</span></span>
                            <span class="block text-[10px] font-medium" style="color: var(--text-muted)">Travel Premium</span>
                        </div>
                    </a>

                    <!-- Desktop Menu -->
                    <div class="hidden lg:flex items-center space-x-8">
                        @php
                            $navItems = [
                                ['/', 'Beranda'],
                                [route('destinasi.index'), 'Destinasi'],
                                [route('paket.index'), 'Paket Wisata'],
                                [route('tiket.index'), 'Tiket'],
                                [route('hotel.index'), 'Hotel'],
                                [route('about'), 'Tentang Kami'],
                                [route('kontak'), 'Kontak'],
                            ];
                        @endphp
                        @foreach($navItems as $item)
                            <a href="{{ $item[0] }}" class="text-sm font-medium transition-colors hover:text-[var(--primary)]" style="color: {{ Request::url() == $item[0] ? 'var(--primary)' : 'var(--text-secondary)' }}">
                                {{ $item[1] }}
                            </a>
                        @endforeach
                    </div>

                    <!-- Right Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Theme Toggle -->
                        <button @click="toggleTheme()" class="theme-toggle" aria-label="Toggle theme">
                            <i :class="darkMode ? 'fas fa-sun' : 'fas fa-moon'"></i>
                        </button>

                        @guest
                            <a href="{{ route('login') }}" class="hidden sm:block text-sm font-medium" style="color: var(--text-secondary)">Masuk</a>
                            <a href="{{ route('register') }}" class="btn-accent px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg hover:shadow-xl transition-all">
                                Pesan Sekarang
                            </a>
                        @else
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-3 px-3 py-2 rounded-xl transition-colors" style="background: var(--bg-tertiary)">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-white" style="background: linear-gradient(135deg, var(--primary), var(--accent))">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span class="hidden sm:block text-sm font-medium" style="color: var(--text-primary)">{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down text-xs" style="color: var(--text-muted)"></i>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 glass rounded-xl shadow-2xl py-2 z-50">
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm transition-colors hover:bg-[var(--bg-tertiary)]" style="color: var(--accent)">
                                            <i class="fas fa-shield-alt w-5 mr-3"></i>Panel Admin
                                        </a>
                                    @else
                                        <a href="{{ route('order.history') }}" class="flex items-center px-4 py-3 text-sm transition-colors hover:bg-[var(--bg-tertiary)]" style="color: var(--text-primary)">
                                            <i class="fas fa-receipt w-5 mr-3"></i>Pesanan Saya
                                        </a>
                                    @endif
                                    <hr style="border-color: var(--border)">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-3 text-sm text-red-500 hover:bg-[var(--bg-tertiary)] transition-colors">
                                            <i class="fas fa-sign-out-alt w-5 mr-3"></i>Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endguest

                        <!-- Mobile Menu -->
                        <button @click="mobileMenu = !mobileMenu" class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center" style="background: var(--bg-tertiary); color: var(--text-primary)">
                            <i :class="mobileMenu ? 'fas fa-times' : 'fas fa-bars'"></i>
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu Dropdown -->
                <div x-show="mobileMenu" x-transition class="lg:hidden mt-4 pt-4" style="border-top: 1px solid var(--border)">
                    <div class="space-y-1">
                        @foreach($navItems as $item)
                            <a href="{{ $item[0] }}" class="block px-4 py-3 rounded-xl text-sm font-medium transition-colors" 
                               style="color: {{ Request::url() == $item[0] ? 'var(--primary)' : 'var(--text-secondary)' }}; background: {{ Request::url() == $item[0] ? 'var(--bg-tertiary)' : 'transparent' }}">
                                {{ $item[1] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content - No padding, content starts from top -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background: var(--bg-secondary); border-top: 1px solid var(--border)" class="mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- Company Info -->
                <div class="lg:col-span-1">
                    <a href="/" class="flex items-center space-x-2 mb-6">
                        <img src="{{ asset('images/logo.png') }}" width="40" height="40" style="width:40px;height:40px;" class="rounded-xl" alt="TraveGo">
                        <span class="text-xl font-serif font-bold" style="color: var(--text-primary)">TraveGo</span>
                    </a>
                    <p class="text-sm leading-relaxed mb-6" style="color: var(--text-muted)">
                        Platform travel premium Indonesia dengan pengalaman perjalanan tak terlupakan.
                    </p>
                    <div class="flex space-x-3">
                        @php
                            $socials = [
                                ['instagram', '#E4405F'],
                                ['facebook', '#1877F2'],
                                ['twitter', '#1DA1F2'],
                                ['youtube', '#FF0000']
                            ];
                        @endphp
                        @foreach($socials as $social)
                            <a href="#" class="w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:scale-110 hover:shadow-lg group" 
                               style="background: var(--bg-tertiary);">
                                <i class="fab fa-{{ $social[0] }} transition-colors group-hover:text-white" style="color: var(--text-muted)"></i>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-serif font-bold mb-6" style="color: var(--text-primary)">Tautan Cepat</h4>
                    <ul class="space-y-3">
                        @foreach(['Destinasi' => route('destinasi.index'), 'Paket Wisata' => route('paket.index'), 'Hotel' => route('hotel.index'), 'Tiket' => route('tiket.index')] as $name => $url)
                            <li><a href="{{ $url }}" class="text-sm transition-colors hover:text-[var(--primary)]" style="color: var(--text-muted)">{{ $name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="font-serif font-bold mb-6" style="color: var(--text-primary)">Bantuan</h4>
                    <ul class="space-y-3">
                        @foreach(['Tentang Kami' => route('about'), 'Kontak' => route('kontak'), 'FAQ' => '#', 'Kebijakan Privasi' => '#'] as $name => $url)
                            <li><a href="{{ $url }}" class="text-sm transition-colors hover:text-[var(--primary)]" style="color: var(--text-muted)">{{ $name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="font-serif font-bold mb-6" style="color: var(--text-primary)">Buletin</h4>
                    <p class="text-sm mb-4" style="color: var(--text-muted)">Berlangganan untuk penawaran eksklusif dan tips perjalanan.</p>
                    <form class="flex">
                        <input type="email" placeholder="Email Anda" class="flex-1 px-4 py-3 rounded-l-xl text-sm border-0 focus:ring-2 focus:ring-[var(--primary)]" style="background: var(--bg-tertiary); color: var(--text-primary)">
                        <button type="submit" class="btn-primary px-4 py-3 rounded-r-xl">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>

            <hr class="my-10" style="border-color: var(--border)">

            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm" style="color: var(--text-muted)">&copy; {{ date('Y') }} TraveGo. Hak Cipta Dilindungi.</p>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <i class="fab fa-cc-visa text-2xl" style="color: var(--text-muted)"></i>
                    <i class="fab fa-cc-mastercard text-2xl" style="color: var(--text-muted)"></i>
                    <i class="fas fa-shield-alt text-xl" style="color: var(--primary)"></i>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    
    <script>
        // Theme Manager
        function themeManager() {
            return {
                darkMode: localStorage.getItem('darkMode') === 'true',
                init() {
                    this.$watch('darkMode', val => localStorage.setItem('darkMode', val));
                },
                toggleTheme() {
                    this.darkMode = !this.darkMode;
                }
            }
        }

        // GSAP Animations
        gsap.registerPlugin(ScrollTrigger);

        // Fade up animation
        gsap.utils.toArray('.fade-up').forEach(el => {
            gsap.to(el, {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse'
                }
            });
        });

        // Fade in animation
        gsap.utils.toArray('.fade-in').forEach(el => {
            gsap.to(el, {
                opacity: 1,
                duration: 0.8,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse'
                }
            });
        });

        // Scale up animation
        gsap.utils.toArray('.scale-up').forEach(el => {
            gsap.to(el, {
                opacity: 1,
                scale: 1,
                duration: 0.6,
                ease: 'back.out(1.7)',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse'
                }
            });
        });

        // Parallax effect
        window.addEventListener('scroll', () => {
            document.documentElement.style.setProperty('--scroll', window.scrollY);
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href'))?.scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // ClickSpark Effect
        function createSpark(x, y) {
            const container = document.createElement('div');
            container.className = 'click-spark';
            container.style.left = x + 'px';
            container.style.top = y + 'px';
            
            const sparkCount = 8;
            const colors = ['var(--primary)', 'var(--accent)', '#f59e0b', '#10b981'];
            
            for (let i = 0; i < sparkCount; i++) {
                const spark = document.createElement('div');
                spark.className = 'spark';
                
                const angle = (i / sparkCount) * Math.PI * 2;
                const distance = 30 + Math.random() * 20;
                const tx = Math.cos(angle) * distance;
                const ty = Math.sin(angle) * distance;
                
                spark.style.setProperty('--tx', tx + 'px');
                spark.style.setProperty('--ty', ty + 'px');
                spark.style.background = colors[Math.floor(Math.random() * colors.length)];
                spark.style.animationDelay = (Math.random() * 0.1) + 's';
                
                container.appendChild(spark);
            }
            
            document.body.appendChild(container);
            setTimeout(() => container.remove(), 700);
        }
        
        document.addEventListener('click', (e) => {
            createSpark(e.clientX, e.clientY);
        });
    </script>

    {{-- AI Chatbot Component --}}
    @include('components.chatbot')

    {{-- Live Support Chat Component --}}
    @include('components.support-chat')

    {{-- Scroll to Top Button --}}
    <div x-data="{ showTop: false }" 
         x-init="window.addEventListener('scroll', () => showTop = window.scrollY > 500)"
         @scroll.window="showTop = window.scrollY > 500">
        <button x-show="showTop" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                @click="window.scrollTo({top: 0, behavior: 'smooth'})"
                class="fixed bottom-24 right-6 z-40 w-12 h-12 rounded-full shadow-2xl flex items-center justify-center transition-all hover:scale-110"
                style="background: linear-gradient(135deg, var(--primary), var(--accent))">
            <i class="fas fa-arrow-up text-white text-lg"></i>
        </button>
    </div>

    {{-- Page Loading Overlay --}}
    <div x-data="{ loading: true }" 
         x-init="setTimeout(() => loading = false, 500)"
         x-show="loading"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[9999] flex items-center justify-center"
         style="background: var(--bg-primary)">
        <div class="text-center">
            <div class="relative">
                <img src="{{ asset('images/Gemini_Generated_Image_6nkfue6nkfue6nkf-removebg-preview-removebg-preview.png') }}" 
                     alt="TraveGo" 
                     class="w-20 h-20 mx-auto mb-4 animate-bounce"
                     style="animation: bounce 1s infinite, pulse 2s infinite;">
            </div>
            <p class="text-sm font-medium animate-pulse" style="color: var(--text-muted)">Memuat TraveGo...</p>
        </div>
    </div>

</body>
</html>

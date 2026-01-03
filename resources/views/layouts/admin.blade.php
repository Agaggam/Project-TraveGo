<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', sidebarOpen: true }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - TraveGo')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-primary: #faf7f2;
            --bg-secondary: #ffffff;
            --bg-tertiary: #f5f0e8;
            --text-primary: #1a1a2e;
            --text-secondary: #4a4a5a;
            --text-muted: #8a8a9a;
            --primary: #047857;
            --primary-light: #10b981;
            --accent: #d97706;
            --border: rgba(0,0,0,0.08);
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
            --border: rgba(255,255,255,0.1);
        }
        * { font-family: 'Inter', sans-serif; transition: background-color 0.3s, color 0.3s; }
        h1, h2, h3, .font-serif { font-family: 'Playfair Display', serif; }
        body { background-color: var(--bg-primary); color: var(--text-primary); }
        .text-gradient { background: linear-gradient(135deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .btn-primary { background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; }
        .card { background: var(--bg-secondary); border: 1px solid var(--border); }
        [x-cloak] { display: none !important; }
        
        /* ClickSpark Effect */
        .click-spark { position: fixed; pointer-events: none; z-index: 9999; }
        .spark { position: absolute; width: 8px; height: 8px; border-radius: 50%; background: var(--primary); animation: spark-fade 0.6s ease-out forwards; }
        @keyframes spark-fade { 0% { opacity: 1; transform: translate(0, 0) scale(1); } 100% { opacity: 0; transform: translate(var(--tx), var(--ty)) scale(0); } }
    </style>
</head>
<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="fixed h-screen transition-all duration-300 z-40 flex flex-col" style="background: var(--bg-secondary); border-right: 1px solid var(--border)">
            <div class="p-6 flex items-center space-x-3 flex-shrink-0" style="border-bottom: 1px solid var(--border)">
                <img src="{{ asset('images/logo.png') }}" width="40" height="40" style="width:40px;height:40px;" class="rounded-xl" alt="Logo">
                <span x-show="sidebarOpen" class="text-xl font-serif font-bold" style="color: var(--text-primary)">Trave<span style="color: var(--primary)">Go</span></span>
            </div>

            <nav class="flex-1 mt-6 px-3 overflow-y-auto">
                <span x-show="sidebarOpen" class="text-xs font-medium uppercase tracking-wider mb-3 px-3 block" style="color: var(--text-muted)">Menu</span>

                @php
                    $menuItems = [
                        ['admin.dashboard', 'Dashboard', 'fas fa-home'],
                        ['admin.paket.index', 'Paket Wisata', 'fas fa-box'],
                        ['admin.destinasi.index', 'Destinasi', 'fas fa-map-marker-alt'],
                        ['admin.tickets.index', 'Tiket', 'fas fa-ticket-alt'],
                        ['admin.hotels.index', 'Hotel', 'fas fa-hotel'],
                        ['admin.promos.index', 'Promo', 'fas fa-tags'],
                        ['admin.reviews.index', 'Reviews', 'fas fa-star'],
                        ['admin.support-chat.index', 'Support Chat', 'fas fa-headset'],
                    ];
                @endphp

                @foreach($menuItems as $item)
                    <a href="{{ route($item[0]) }}" class="flex items-center px-3 py-3 mb-1 rounded-xl transition-all" 
                       style="{{ request()->routeIs($item[0].'*') ? 'background: rgba(16,185,129,0.1); color: var(--primary)' : 'color: var(--text-secondary)' }}">
                        <i class="{{ $item[2] }} w-5"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium">{{ $item[1] }}</span>
                    </a>
                @endforeach
            </nav>

            <!-- User Section -->
            <div class="flex-shrink-0 p-4" style="border-top: 1px solid var(--border)">
                <div class="flex items-center" :class="sidebarOpen ? '' : 'justify-center'">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold flex-shrink-0" style="background: linear-gradient(135deg, var(--primary), var(--accent))">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div x-show="sidebarOpen" x-cloak class="ml-3 overflow-hidden">
                        <p class="text-sm font-medium truncate" style="color: var(--text-primary)">{{ Auth::user()->name }}</p>
                        <p class="text-xs" style="color: var(--text-muted)">Administrator</p>
                    </div>
                </div>
                <div x-show="sidebarOpen" x-cloak class="flex items-center mt-3 space-x-3">
                    <a href="/" class="text-sm transition-colors hover:text-[var(--primary)]" style="color: var(--text-muted)">Website</a>
                    <span style="color: var(--text-muted)">|</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm transition-colors hover:text-red-500" style="color: var(--text-muted)">Logout</button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main :class="sidebarOpen ? 'ml-64' : 'ml-20'" class="flex-1 transition-all duration-300">
            <!-- Top Bar -->
            <header class="sticky top-0 z-30 px-6 py-4 flex items-center justify-between" style="background: var(--bg-secondary); border-bottom: 1px solid var(--border)">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl transition-colors hover:bg-[var(--bg-tertiary)]" style="color: var(--text-muted)">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="text-xl font-serif font-bold" style="color: var(--text-primary)">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center space-x-3">
                    <button @click="darkMode = !darkMode" class="p-2 rounded-xl transition-colors hover:bg-[var(--bg-tertiary)]" style="color: var(--text-muted)">
                        <i :class="darkMode ? 'fas fa-sun' : 'fas fa-moon'"></i>
                    </button>
                </div>
            </header>

            <!-- Content -->
            <div class="p-6">
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl flex items-center" style="background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: var(--primary)">
                        <i class="fas fa-check-circle mr-3"></i>{{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-xl flex items-center" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #ef4444">
                        <i class="fas fa-exclamation-circle mr-3"></i>{{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
    
    <script>
        // ClickSpark Effect
        function createSpark(x, y) {
            const container = document.createElement('div');
            container.className = 'click-spark';
            container.style.left = x + 'px';
            container.style.top = y + 'px';
            const colors = ['var(--primary)', 'var(--accent)', '#f59e0b', '#10b981'];
            for (let i = 0; i < 8; i++) {
                const spark = document.createElement('div');
                spark.className = 'spark';
                const angle = (i / 8) * Math.PI * 2;
                const distance = 30 + Math.random() * 20;
                spark.style.setProperty('--tx', Math.cos(angle) * distance + 'px');
                spark.style.setProperty('--ty', Math.sin(angle) * distance + 'px');
                spark.style.background = colors[Math.floor(Math.random() * colors.length)];
                container.appendChild(spark);
            }
            document.body.appendChild(container);
            setTimeout(() => container.remove(), 700);
        }
        document.addEventListener('click', (e) => createSpark(e.clientX, e.clientY));
    </script>
</body>
</html>

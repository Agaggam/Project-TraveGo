<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TraveGo')</title>

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
            --glass-bg: rgba(255,255,255,0.95);
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
            --glass-bg: rgba(30,41,59,0.95);
        }
        * { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-serif { font-family: 'Playfair Display', serif; }
        body { background-color: var(--bg-primary); color: var(--text-primary); }
        .text-gradient { background: linear-gradient(135deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .btn-primary { background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; transition: all 0.3s; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 40px rgba(16, 185, 129, 0.3); }
        
        /* Decorative elements */
        .auth-decoration { position: absolute; border-radius: 50%; }
        .auth-dots { display: grid; grid-template-columns: repeat(4, 8px); gap: 8px; }
        .auth-dots span { width: 8px; height: 8px; background: rgba(255,255,255,0.4); border-radius: 50%; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .float-animation { animation: float 4s ease-in-out infinite; }
    </style>
</head>
<body class="min-h-screen flex">
    <!-- Left Side - Decorative Background -->
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary), #0d9488, var(--primary-light))">
        <!-- Decorative Elements -->
        <div class="absolute inset-0">
            <!-- Large circle -->
            <div class="auth-decoration w-96 h-96 -bottom-20 -left-20" style="background: rgba(255,255,255,0.1)"></div>
            <div class="auth-decoration w-64 h-64 top-20 -right-10" style="background: rgba(255,255,255,0.05)"></div>
            
            <!-- Floating circles -->
            <div class="auth-decoration w-16 h-16 top-1/4 left-1/4 float-animation" style="background: rgba(255,255,255,0.2); animation-delay: 0s"></div>
            <div class="auth-decoration w-10 h-10 bottom-1/3 left-1/3 float-animation" style="background: var(--accent); animation-delay: 1s"></div>
            <div class="auth-decoration w-8 h-8 top-1/3 right-1/4 float-animation" style="background: rgba(255,255,255,0.3); animation-delay: 2s"></div>
            
            <!-- Dots pattern -->
            <div class="auth-dots absolute bottom-32 left-12">
                @for($i = 0; $i < 16; $i++)<span></span>@endfor
            </div>
            
            <!-- Lines decoration -->
            <div class="absolute top-20 left-1/3">
                <div class="w-1 h-24 rounded-full" style="background: rgba(255,255,255,0.3)"></div>
            </div>
            <div class="absolute top-32 left-1/3 ml-4">
                <div class="w-1 h-16 rounded-full" style="background: rgba(255,255,255,0.2)"></div>
            </div>
            
            <!-- Arc decoration at bottom -->
            <div class="absolute bottom-0 right-0 w-48 h-48">
                <svg viewBox="0 0 100 100" class="w-full h-full">
                    <circle cx="100" cy="100" r="80" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="4"/>
                    <circle cx="100" cy="100" r="60" fill="none" stroke="var(--accent)" stroke-width="3"/>
                </svg>
            </div>
        </div>
        
        <!-- Content -->
        <div class="relative z-10 flex flex-col justify-center p-12 text-white">
            <h2 class="font-serif text-5xl font-bold leading-tight mb-6">
                Petualangan<br>dimulai disini
            </h2>
            <p class="text-lg text-white/80 max-w-sm leading-relaxed">
                Bergabunglah dengan komunitas traveler kami dan temukan keindahan Indonesia bersama TraveGo.
            </p>
            
            <!-- Stats -->
            <div class="flex gap-8 mt-12">
                <div>
                    <div class="text-3xl font-bold">10K+</div>
                    <div class="text-sm text-white/60">Traveler</div>
                </div>
                <div>
                    <div class="text-3xl font-bold">500+</div>
                    <div class="text-sm text-white/60">Destinasi</div>
                </div>
                <div>
                    <div class="text-3xl font-bold">4.9</div>
                    <div class="text-sm text-white/60">Rating</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Form -->
    <div class="w-full lg:w-1/2 flex flex-col relative" style="background: var(--bg-primary)">
        <!-- Decorative arc for right side -->
        <div class="hidden lg:block absolute top-0 right-0 w-32 h-32 opacity-20">
            <svg viewBox="0 0 100 100" class="w-full h-full">
                <circle cx="100" cy="0" r="80" fill="none" stroke="var(--primary)" stroke-width="2"/>
            </svg>
        </div>
        <div class="hidden lg:block absolute bottom-0 right-0 w-16 h-16">
            <div class="auth-dots opacity-30">
                @for($i = 0; $i < 16; $i++)<span style="background: var(--primary)"></span>@endfor
            </div>
        </div>
        
        <!-- Header -->
        <div class="flex items-center justify-between p-6">
            <a href="/" class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg">
                    <i class="fas fa-plane text-white"></i>
                </div>
                <span class="text-xl font-serif font-bold" style="color: var(--text-primary)">Trave<span style="color: var(--primary)">Go</span></span>
            </a>
            <div class="flex items-center space-x-4">
                <button @click="darkMode = !darkMode" class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors" style="background: var(--bg-tertiary); color: var(--text-secondary)">
                    <i :class="darkMode ? 'fas fa-sun' : 'fas fa-moon'"></i>
                </button>
                <a href="/" class="text-sm font-medium flex items-center hover:text-[var(--primary)] transition-colors" style="color: var(--text-muted)">
                    <i class="fas fa-home mr-2"></i>Beranda
                </a>
            </div>
        </div>

        <!-- Form Content -->
        <div class="flex-1 flex items-center justify-center p-6">
            <div class="w-full max-w-md">
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        <div class="p-6 text-center text-sm" style="color: var(--text-muted)">
            &copy; {{ date('Y') }} TraveGo. All rights reserved.
        </div>
    </div>
</body>
</html>

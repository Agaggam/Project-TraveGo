@extends('layouts.guest')

@section('title', 'Masuk - TraveGo')

@section('content')
<div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-xl" style="background: var(--bg-secondary)">
    <!-- Logo -->
    <div class="text-center mb-8">
        <div class="w-20 h-20 mx-auto mb-4 rounded-2xl overflow-hidden shadow-lg" style="background: var(--bg-tertiary)">
            <img src="{{ asset('images/logo.png') }}" alt="TraveGo" class="w-full h-full object-contain p-1">
        </div>
        <h1 class="font-serif text-2xl font-bold" style="color: var(--text-primary)">Halo! Selamat Datang</h1>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Email</label>
            <div class="relative">
                <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2" style="color: var(--primary)"></i>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="w-full pl-12 pr-4 py-3.5 rounded-xl border focus:ring-2 focus:ring-[var(--primary)] focus:border-[var(--primary)] transition-all"
                    style="background: var(--bg-tertiary); border-color: var(--border); color: var(--text-primary)"
                    placeholder="Masukkan alamat email">
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div x-data="{ showPassword: false }">
            <label for="password" class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Password</label>
            <div class="relative">
                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2" style="color: var(--primary)"></i>
                <input :type="showPassword ? 'text' : 'password'" name="password" id="password" required
                    class="w-full pl-12 pr-12 py-3.5 rounded-xl border focus:ring-2 focus:ring-[var(--primary)] focus:border-[var(--primary)] transition-all"
                    style="background: var(--bg-tertiary); border-color: var(--border); color: var(--text-primary)"
                    placeholder="••••••••••••">
                <button type="button" @click="showPassword = !showPassword" 
                    class="absolute right-4 top-1/2 -translate-y-1/2 transition-colors" 
                    style="color: var(--text-muted)">
                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                </button>
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember & Forgot -->
        <div class="flex items-center justify-between">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-[var(--primary)] focus:ring-[var(--primary)]">
                <span class="ml-2 text-sm" style="color: var(--text-muted)">Ingat saya</span>
            </label>
            <a href="#" class="text-sm font-medium" style="color: var(--primary)">Lupa Password?</a>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-primary w-full py-4 rounded-xl font-semibold text-white flex items-center justify-center gap-2"
            x-data="{ loading: false }" @click="loading = true" :disabled="loading">
            <i x-show="loading" class="fas fa-spinner fa-spin"></i>
            <span x-text="loading ? 'Memproses...' : 'Login'"></span>
        </button>
    </form>

    <!-- Divider -->
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t" style="border-color: var(--border)"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-4" style="background: var(--bg-secondary); color: var(--text-muted)">atau</span>
        </div>
    </div>

    <!-- Social Login -->
    <div class="flex justify-center gap-4">
        <button class="w-14 h-14 rounded-xl border-2 flex items-center justify-center transition-all hover:border-[var(--primary)] hover:-translate-y-1" style="border-color: var(--border)">
            <img src="https://www.google.com/favicon.ico" alt="Google" class="w-6 h-6">
        </button>
        <button class="w-14 h-14 rounded-xl border-2 flex items-center justify-center transition-all hover:border-[var(--primary)] hover:-translate-y-1" style="border-color: var(--border)">
            <i class="fab fa-facebook text-2xl text-blue-600"></i>
        </button>
        <button class="w-14 h-14 rounded-xl border-2 flex items-center justify-center transition-all hover:border-[var(--primary)] hover:-translate-y-1" style="border-color: var(--border)">
            <i class="fab fa-apple text-2xl" style="color: var(--text-primary)"></i>
        </button>
    </div>

    <!-- Register Link -->
    <div class="mt-8 text-center">
        <p style="color: var(--text-muted)">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-semibold" style="color: var(--primary)">Buat Akun</a>
        </p>
    </div>
</div>
@endsection

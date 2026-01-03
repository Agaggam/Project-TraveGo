@extends('layouts.guest')

@section('title', 'Daftar - TraveGo')

@section('content')
<div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-xl" style="background: var(--bg-secondary)"
    x-data="{
        email: '{{ old('email') }}',
        password: '',
        passwordConfirm: '',
        emailStatus: null,
        emailMessage: '',
        passwordStrength: 0,
        passwordLevel: '',
        passwordSuggestions: [],
        emailLoading: false,
        passwordMatch: true,
        debounceTimer: null,
        
        async checkEmail() {
            if (!this.email || !this.email.includes('@')) {
                this.emailStatus = null;
                return;
            }
            
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(async () => {
                this.emailLoading = true;
                try {
                    const response = await fetch('/api/validate/email', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ email: this.email })
                    });
                    const data = await response.json();
                    this.emailStatus = data.valid;
                    this.emailMessage = data.message;
                } catch (e) {
                    this.emailStatus = null;
                }
                this.emailLoading = false;
            }, 500);
        },
        
        async checkPassword() {
            if (!this.password) {
                this.passwordStrength = 0;
                return;
            }
            
            try {
                const response = await fetch('/api/validate/password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ password: this.password })
                });
                const data = await response.json();
                this.passwordStrength = data.strength;
                this.passwordLevel = data.level;
                this.passwordSuggestions = data.suggestions;
            } catch (e) {}
            
            this.checkPasswordMatch();
        },
        
        checkPasswordMatch() {
            this.passwordMatch = !this.passwordConfirm || this.password === this.passwordConfirm;
        }
    }">
    <!-- Logo -->
    <div class="text-center mb-8">
        <div class="w-20 h-20 mx-auto mb-4 rounded-2xl overflow-hidden shadow-lg" style="background: var(--bg-tertiary)">
            <img src="{{ asset('images/logo.png') }}" alt="TraveGo" class="w-full h-full object-contain p-1">
        </div>
        <h1 class="font-serif text-2xl font-bold" style="color: var(--text-primary)">Buat Akun Baru</h1>
        <p class="text-sm mt-1" style="color: var(--text-muted)">Mulai petualanganmu bersama TraveGo</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Nama Lengkap</label>
            <div class="relative">
                <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2" style="color: var(--primary)"></i>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                    class="w-full pl-12 pr-4 py-3.5 rounded-xl border focus:ring-2 focus:ring-[var(--primary)] focus:border-[var(--primary)] transition-all"
                    style="background: var(--bg-tertiary); border-color: var(--border); color: var(--text-primary)"
                    placeholder="Masukkan nama lengkap">
            </div>
            @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email with Real-time Validation -->
        <div>
            <label for="email" class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Email</label>
            <div class="relative">
                <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2" style="color: var(--primary)"></i>
                <input type="email" name="email" id="email" x-model="email" @input="checkEmail()" required
                    class="w-full pl-12 pr-10 py-3.5 rounded-xl border focus:ring-2 focus:ring-[var(--primary)] focus:border-[var(--primary)] transition-all"
                    :style="'background: var(--bg-tertiary); color: var(--text-primary); border-color: ' + (emailStatus === false ? '#ef4444' : emailStatus === true ? '#10b981' : 'var(--border)')"
                    placeholder="Masukkan alamat email">
                <!-- Status indicator -->
                <div class="absolute right-4 top-1/2 -translate-y-1/2">
                    <i x-show="emailLoading" class="fas fa-spinner fa-spin text-gray-400"></i>
                    <i x-show="!emailLoading && emailStatus === true" class="fas fa-check text-green-500"></i>
                    <i x-show="!emailLoading && emailStatus === false" class="fas fa-times text-red-500"></i>
                </div>
            </div>
            <p x-show="emailMessage && !emailLoading" x-text="emailMessage" 
                :class="emailStatus ? 'text-green-500' : 'text-red-500'" class="mt-1 text-sm"></p>
            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password with Strength Indicator -->
        <div>
            <label for="password" class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Password</label>
            <div class="relative">
                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2" style="color: var(--primary)"></i>
                <input type="password" name="password" id="password" x-model="password" @input="checkPassword()" required
                    class="w-full pl-12 pr-4 py-3.5 rounded-xl border focus:ring-2 focus:ring-[var(--primary)] focus:border-[var(--primary)] transition-all"
                    style="background: var(--bg-tertiary); border-color: var(--border); color: var(--text-primary)"
                    placeholder="Minimal 8 karakter">
            </div>
            <!-- Password Strength Bar -->
            <div x-show="password" class="mt-2">
                <div class="h-1.5 w-full rounded-full overflow-hidden" style="background: var(--bg-tertiary)">
                    <div class="h-full transition-all duration-300 rounded-full"
                        :style="'width: ' + passwordStrength + '%; background: ' + (passwordLevel === 'strong' ? '#10b981' : passwordLevel === 'medium' ? '#f59e0b' : '#ef4444')"></div>
                </div>
                <div class="flex justify-between mt-1">
                    <span class="text-xs" :style="'color: ' + (passwordLevel === 'strong' ? '#10b981' : passwordLevel === 'medium' ? '#f59e0b' : '#ef4444')" x-text="passwordLevel === 'strong' ? 'Kuat' : passwordLevel === 'medium' ? 'Sedang' : 'Lemah'"></span>
                    <span class="text-xs" style="color: var(--text-muted)" x-text="passwordSuggestions.join(', ')"></span>
                </div>
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Konfirmasi Password</label>
            <div class="relative">
                <i class="fas fa-shield-alt absolute left-4 top-1/2 -translate-y-1/2" style="color: var(--primary)"></i>
                <input type="password" name="password_confirmation" id="password_confirmation" x-model="passwordConfirm" @input="checkPasswordMatch()" required
                    class="w-full pl-12 pr-10 py-3.5 rounded-xl border focus:ring-2 focus:ring-[var(--primary)] focus:border-[var(--primary)] transition-all"
                    :style="'background: var(--bg-tertiary); color: var(--text-primary); border-color: ' + (passwordConfirm && !passwordMatch ? '#ef4444' : 'var(--border)')"
                    placeholder="Ulangi password">
                <div class="absolute right-4 top-1/2 -translate-y-1/2">
                    <i x-show="passwordConfirm && passwordMatch" class="fas fa-check text-green-500"></i>
                    <i x-show="passwordConfirm && !passwordMatch" class="fas fa-times text-red-500"></i>
                </div>
            </div>
            <p x-show="passwordConfirm && !passwordMatch" class="mt-1 text-sm text-red-500">Password tidak cocok</p>
        </div>

        <!-- Terms -->
        <div class="flex items-start">
            <input type="checkbox" name="terms" class="w-4 h-4 mt-1 rounded border-gray-300 text-[var(--primary)] focus:ring-[var(--primary)]" required>
            <span class="ml-2 text-sm" style="color: var(--text-muted)">
                Saya setuju dengan <a href="#" style="color: var(--primary)">Syarat & Ketentuan</a> dan <a href="#" style="color: var(--primary)">Kebijakan Privasi</a>
            </span>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-primary w-full py-4 rounded-xl font-semibold text-white"
            :disabled="emailStatus === false || !passwordMatch || passwordStrength < 50"
            :class="{'opacity-50 cursor-not-allowed': emailStatus === false || !passwordMatch || passwordStrength < 50}">
            Daftar Sekarang
        </button>
    </form>

    <!-- Login Link -->
    <div class="mt-6 text-center">
        <p style="color: var(--text-muted)">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold" style="color: var(--primary)">Masuk</a>
        </p>
    </div>
</div>
@endsection

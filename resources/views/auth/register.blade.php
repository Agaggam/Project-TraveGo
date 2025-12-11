@extends('layouts.guest')

@section('title', 'Daftar - TraveGo')

@section('content')
<div class="bg-white dark:bg-dark-800 rounded-2xl shadow-xl dark:shadow-none border border-gray-100 dark:border-dark-700 p-8">
    <h2 class="text-2xl font-heading font-bold text-center text-gray-800 dark:text-white mb-6">Buat Akun Baru</h2>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="mb-5">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-dark-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('name') border-red-500 dark:border-red-500 @enderror"
                placeholder="Masukkan nama lengkap">
            @error('name')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-dark-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('email') border-red-500 dark:border-red-500 @enderror"
                placeholder="nama@email.com">
            @error('email')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Password</label>
            <input type="password" name="password" id="password" required
                class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-dark-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('password') border-red-500 dark:border-red-500 @enderror"
                placeholder="Minimal 8 karakter">
            @error('password')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-dark-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                placeholder="Ulangi password">
        </div>

        <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-xl transition-all duration-300 glow-primary">
            Daftar
        </button>
    </form>

    <p class="mt-6 text-center text-gray-600 dark:text-dark-400">
        Sudah punya akun? 
        <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-400 font-semibold">Masuk</a>
    </p>
</div>
@endsection

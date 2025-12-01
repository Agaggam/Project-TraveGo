@extends('layouts.guest')

@section('title', 'Daftar - TraveGo')

@section('content')
<div class="bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Buat Akun Baru</h2>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" name="password" id="password" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('password') border-red-500 @enderror">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
        </div>

        <button type="submit" class="w-full bg-primary-600 text-white py-2 px-4 rounded-lg hover:bg-primary-700 transition font-medium">
            Daftar
        </button>
    </form>

    <p class="mt-6 text-center text-gray-600">
        Sudah punya akun? 
        <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-medium">Masuk</a>
    </p>
</div>
@endsection

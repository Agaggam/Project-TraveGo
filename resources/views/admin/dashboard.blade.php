@extends('layouts.admin')

@section('title', 'Dashboard - Admin TraveGo')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-100 dark:border-dark-700 p-6 transition-colors">
        <div class="flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-primary-500/20 to-primary-600/20 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 dark:text-dark-400">Total Paket Wisata</p>
                <p class="text-3xl font-heading font-bold text-gray-900 dark:text-white">{{ $totalPaket }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-100 dark:border-dark-700 p-6 transition-colors">
        <div class="flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-accent-500/20 to-accent-600/20 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 dark:text-dark-400">Total Pengguna</p>
                <p class="text-3xl font-heading font-bold text-gray-900 dark:text-white">{{ $totalUser }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-100 dark:border-dark-700 p-6 transition-colors">
        <div class="flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-primary-500/20 to-accent-500/20 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 dark:text-dark-400">Selamat Datang</p>
                <p class="text-xl font-heading font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-100 dark:border-dark-700 p-6 mb-8 transition-colors">
    <h2 class="text-lg font-heading font-semibold text-gray-900 dark:text-white mb-4">Aksi Cepat</h2>
    <div class="flex flex-wrap gap-4">
        <a href="{{ route('admin.paket.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl transition-all duration-300 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Paket Wisata
        </a>
        <a href="{{ route('admin.paket.index') }}" class="inline-flex items-center px-5 py-2.5 border border-gray-300 dark:border-dark-600 text-gray-700 dark:text-dark-300 rounded-xl hover:bg-gray-50 dark:hover:bg-dark-700 transition-all duration-300 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
            Kelola Paket Wisata
        </a>
    </div>
</div>

<!-- Latest Packages -->
<div class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-100 dark:border-dark-700 overflow-hidden transition-colors">
    <div class="p-6 border-b border-gray-100 dark:border-dark-700">
        <h2 class="text-lg font-heading font-semibold text-gray-900 dark:text-white">Paket Wisata Terbaru</h2>
    </div>
    @if($latestPakets->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-dark-700/50">
                    <tr>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600 dark:text-dark-300">Nama Paket</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600 dark:text-dark-300">Lokasi</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600 dark:text-dark-300">Harga</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600 dark:text-dark-300">Rating</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600 dark:text-dark-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-dark-700">
                    @foreach($latestPakets as $paket)
                        <tr class="hover:bg-gray-50 dark:hover:bg-dark-700/50 transition-colors">
                            <td class="py-4 px-6 text-gray-900 dark:text-white font-medium">{{ $paket->nama_paket }}</td>
                            <td class="py-4 px-6 text-gray-600 dark:text-dark-300">{{ $paket->lokasi }}</td>
                            <td class="py-4 px-6 text-gray-600 dark:text-dark-300">Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                            <td class="py-4 px-6">
                                <span class="flex items-center text-gray-600 dark:text-dark-300">
                                    <svg class="w-4 h-4 text-accent-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    {{ number_format($paket->rating, 1) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <a href="{{ route('admin.paket.edit', $paket) }}" class="text-primary-500 hover:text-primary-400 font-medium">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="p-6 text-center text-gray-500 dark:text-dark-400">
            Belum ada paket wisata.
        </div>
    @endif
</div>
@endsection

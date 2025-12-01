@extends('layouts.admin')

@section('title', 'Dashboard - Admin TraveGo')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Total Paket Wisata</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalPaket }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Total User</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalUser }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Selamat Datang</p>
                <p class="text-lg font-bold text-gray-800">{{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h2>
    <div class="flex space-x-4">
        <a href="{{ route('admin.paket.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Paket Wisata
        </a>
        <a href="{{ route('admin.paket.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
            Kelola Paket Wisata
        </a>
    </div>
</div>

<!-- Latest Packages -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Paket Wisata Terbaru</h2>
    @if($latestPakets->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Nama Paket</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Lokasi</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Harga</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Rating</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestPakets as $paket)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $paket->nama_paket }}</td>
                            <td class="py-3 px-4">{{ $paket->lokasi }}</td>
                            <td class="py-3 px-4">Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    {{ number_format($paket->rating, 1) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.paket.edit', $paket) }}" class="text-primary-600 hover:text-primary-700">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-600">Belum ada paket wisata.</p>
    @endif
</div>
@endsection

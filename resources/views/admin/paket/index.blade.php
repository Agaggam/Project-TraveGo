@extends('layouts.admin')

@section('title', 'Kelola Paket Wisata - Admin TraveGo')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Kelola Paket Wisata</h1>
    <a href="{{ route('admin.paket.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Paket
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    @if($paketWisatas->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">ID</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Nama Paket</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Lokasi</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Durasi</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Harga</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Rating</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($paketWisatas as $paket)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 text-sm text-gray-600">{{ $paket->id }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-200 rounded-lg mr-3 overflow-hidden">
                                        @if($paket->gambar_url)
                                            <img src="{{ $paket->gambar_url }}" alt="{{ $paket->nama_paket }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-r from-primary-400 to-primary-600"></div>
                                        @endif
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $paket->nama_paket }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-600">{{ $paket->lokasi }}</td>
                            <td class="py-3 px-4 text-sm text-gray-600">{{ $paket->durasi }}</td>
                            <td class="py-3 px-4 text-sm text-gray-600">Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                <span class="flex items-center text-sm">
                                    <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    {{ number_format($paket->rating, 1) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.paket.edit', $paket) }}" class="text-primary-600 hover:text-primary-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.paket.destroy', $paket) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus paket ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t">
            {{ $paketWisatas->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <p class="text-gray-600 mb-4">Belum ada paket wisata.</p>
            <a href="{{ route('admin.paket.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                Tambah Paket Pertama
            </a>
        </div>
    @endif
</div>
@endsection

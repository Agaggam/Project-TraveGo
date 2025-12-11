@extends('layouts.admin')

@section('title', 'Kelola Paket Wisata - Admin TraveGo')
@section('page-title', 'Kelola Paket Wisata')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-600 dark:text-dark-400">Kelola semua paket wisata yang tersedia</p>
    <a href="{{ route('admin.paket.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl transition-all duration-300 font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Paket
    </a>
</div>

<div class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-100 dark:border-dark-700 overflow-hidden transition-colors">
    @if($paketWisatas->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-dark-700/50">
                    <tr>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600 dark:text-dark-300">ID</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600 dark:text-dark-300">Nama Paket</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600 dark:text-dark-300">Lokasi</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600 dark:text-dark-300">Durasi</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600 dark:text-dark-300">Harga</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600 dark:text-dark-300">Rating</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600 dark:text-dark-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-dark-700">
                    @foreach($paketWisatas as $paket)
                        <tr class="hover:bg-gray-50 dark:hover:bg-dark-700/50 transition-colors">
                            <td class="py-4 px-6 text-sm text-gray-500 dark:text-dark-400">{{ $paket->id }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden mr-4 flex-shrink-0">
                                        @if($paket->gambar_url)
                                            <img src="{{ $paket->gambar_url }}" alt="{{ $paket->nama_paket }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-primary-500 to-accent-500"></div>
                                        @endif
                                    </div>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $paket->nama_paket }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-gray-600 dark:text-dark-300">{{ $paket->lokasi }}</td>
                            <td class="py-4 px-6 text-gray-600 dark:text-dark-300">{{ $paket->durasi }}</td>
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
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('paket.show', $paket) }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-500/10 transition-colors" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.paket.edit', $paket) }}" class="p-2 rounded-lg text-primary-500 hover:bg-primary-500/10 transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.paket.destroy', $paket) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus paket ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-red-500 hover:bg-red-500/10 transition-colors" title="Hapus">
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
        <div class="px-6 py-4 border-t border-gray-100 dark:border-dark-700">
            {{ $paketWisatas->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-20 h-20 bg-gray-100 dark:bg-dark-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-400 dark:text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <p class="text-gray-600 dark:text-dark-400 mb-6">Belum ada paket wisata.</p>
            <a href="{{ route('admin.paket.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-xl transition-all duration-300 font-medium">
                Tambah Paket Pertama
            </a>
        </div>
    @endif
</div>
@endsection

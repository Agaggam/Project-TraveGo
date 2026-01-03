@extends('layouts.admin')

@section('title', 'Kelola Destinasi - Admin')
@section('page-title', 'Destinasi')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
    <div>
        <h2 class="font-serif text-2xl font-bold" style="color: var(--text-primary)">Kelola Destinasi</h2>
        <p class="text-sm" style="color: var(--text-muted)">Total: {{ $destinasis->total() }} destinasi</p>
    </div>
    <a href="{{ route('admin.destinasi.create') }}" class="btn-primary px-6 py-3 rounded-xl font-medium mt-4 md:mt-0 inline-flex items-center">
        <i class="fas fa-plus mr-2"></i>Tambah Destinasi
    </a>
</div>

@if(session('success'))
    <div class="p-4 rounded-xl text-green-800 bg-green-100 mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif

<!-- Table -->
<div class="card rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr style="background: var(--bg-tertiary)">
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Destinasi</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Harga</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Stok</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Rating</th>
                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y" style="border-color: var(--border)">
                @forelse($destinasis as $destinasi)
                    <tr class="hover:bg-[var(--bg-tertiary)] transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-12 rounded-lg overflow-hidden flex-shrink-0" style="background: var(--bg-tertiary)">
                                    @if($destinasi->gambar_url)
                                        <img src="{{ $destinasi->gambar_url }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-image" style="color: var(--text-muted)"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-medium" style="color: var(--text-primary)">{{ $destinasi->nama_destinasi }}</div>
                                    <div class="text-sm" style="color: var(--text-muted)">{{ $destinasi->lokasi }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-medium" style="background: var(--bg-tertiary); color: var(--text-muted)">
                                {{ ucfirst($destinasi->kategori) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-gradient">Rp {{ number_format($destinasi->harga, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-bold {{ $destinasi->stok > 10 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                {{ $destinasi->stok }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-amber-500"><i class="fas fa-star mr-1"></i>{{ number_format($destinasi->rating, 1) }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('destinasi.show', $destinasi->slug) }}" target="_blank" class="p-2 rounded-lg hover:bg-[var(--bg-tertiary)] transition-colors" style="color: var(--text-muted)" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.destinasi.edit', $destinasi) }}" class="p-2 rounded-lg hover:bg-[var(--bg-tertiary)] transition-colors" style="color: var(--primary)" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.destinasi.destroy', $destinasi) }}" method="POST" class="inline" onsubmit="return confirm('Hapus destinasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg hover:bg-red-50 text-red-500 transition-colors" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center" style="color: var(--text-muted)">
                            <i class="fas fa-map-marker-alt text-4xl mb-4 block"></i>
                            Belum ada destinasi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($destinasis->hasPages())
        <div class="px-6 py-4" style="border-top: 1px solid var(--border)">
            {{ $destinasis->links() }}
        </div>
    @endif
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Kelola Paket Wisata - Admin')
@section('page-title', 'Paket Wisata')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
    <div>
        <h2 class="font-serif text-2xl font-bold" style="color: var(--text-primary)">Manage Packages</h2>
        <p class="text-sm" style="color: var(--text-muted)">Create and manage travel packages</p>
    </div>
    <a href="{{ route('admin.paket.create') }}" class="btn-primary px-6 py-3 rounded-xl font-medium mt-4 md:mt-0 inline-flex items-center">
        <i class="fas fa-plus mr-2"></i>Add Package
    </a>
</div>

<!-- Search & Filter -->
<div class="card rounded-xl p-4 mb-6">
    <form class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2" style="color: var(--text-muted)"></i>
            <input type="text" name="search" placeholder="Search packages..." value="{{ request('search') }}"
                class="w-full pl-12 pr-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                style="background: var(--bg-tertiary); color: var(--text-primary)">
        </div>
        <button type="submit" class="btn-primary px-6 py-3 rounded-xl font-medium">Search</button>
    </form>
</div>

<!-- Table -->
<div class="card rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr style="background: var(--bg-tertiary)">
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Package</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Price</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Duration</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Stock</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Rating</th>
                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y" style="border-color: var(--border)">
                @forelse($paketWisatas ?? [] as $paket)
                    <tr class="hover:bg-[var(--bg-tertiary)] transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-12 rounded-lg overflow-hidden flex-shrink-0" style="background: var(--bg-tertiary)">
                                    @if($paket->gambar_url)
                                        <img src="{{ $paket->gambar_url }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-image" style="color: var(--text-muted)"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-medium" style="color: var(--text-primary)">{{ $paket->nama_paket }}</div>
                                    <div class="text-sm" style="color: var(--text-muted)">{{ $paket->lokasi }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-gradient">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4" style="color: var(--text-secondary)">{{ $paket->durasi }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-bold" style="background: {{ $paket->stok > 5 ? 'rgba(16,185,129,0.1); color: #10b981' : 'rgba(239,68,68,0.1); color: #ef4444' }}">
                                {{ $paket->stok }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-amber-500"><i class="fas fa-star mr-1"></i>{{ number_format($paket->rating, 1) }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('paket.show', $paket) }}" target="_blank" class="p-2 rounded-lg hover:bg-[var(--bg-tertiary)] transition-colors" style="color: var(--text-muted)" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.paket.edit', $paket) }}" class="p-2 rounded-lg hover:bg-[var(--bg-tertiary)] transition-colors" style="color: var(--primary)" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.paket.destroy', $paket) }}" method="POST" class="inline" onsubmit="return confirm('Delete this package?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg hover:bg-red-50 text-red-500 transition-colors" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center" style="color: var(--text-muted)">
                            <i class="fas fa-box-open text-4xl mb-4 block"></i>
                            No packages found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(isset($paketWisatas) && $paketWisatas->hasPages())
        <div class="px-6 py-4" style="border-top: 1px solid var(--border)">
            {{ $paketWisatas->links() }}
        </div>
    @endif
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Kelola Promo - Admin')
@section('page-title', 'Promo')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
    <div>
        <h2 class="font-serif text-2xl font-bold" style="color: var(--text-primary)">Kelola Promo</h2>
        <p class="text-sm" style="color: var(--text-muted)">Total: {{ $promos->total() }} promo</p>
    </div>
    <a href="{{ route('admin.promos.create') }}" class="btn-primary px-6 py-3 rounded-xl font-medium mt-4 md:mt-0 inline-flex items-center">
        <i class="fas fa-plus mr-2"></i>Tambah Promo
    </a>
</div>

<!-- Filters -->
<div class="card rounded-xl p-4 mb-6">
    <form action="{{ route('admin.promos.index') }}" method="GET" class="flex flex-wrap gap-4 items-center">
        <select name="status" class="px-4 py-2 rounded-xl border-0" style="background: var(--bg-tertiary); color: var(--text-primary)">
            <option value="">Semua Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
        </select>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode promo..." 
            class="px-4 py-2 rounded-xl border-0 flex-1" style="background: var(--bg-tertiary); color: var(--text-primary)">
        <button type="submit" class="btn-primary px-6 py-2 rounded-xl font-medium">
            <i class="fas fa-search mr-2"></i>Filter
        </button>
    </form>
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
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Kode</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Diskon</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Periode</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Penggunaan</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y" style="border-color: var(--border)">
                @forelse($promos as $promo)
                    <tr class="hover:bg-[var(--bg-tertiary)] transition-colors">
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-lg font-mono font-bold text-sm" style="background: var(--primary); color: white">
                                {{ $promo->code }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium" style="color: var(--text-primary)">{{ $promo->name }}</div>
                            @if($promo->applicable_to)
                                <div class="flex gap-1 mt-1">
                                    @foreach($promo->applicable_to as $type)
                                        <span class="px-1.5 py-0.5 rounded text-[10px]" style="background: var(--bg-tertiary); color: var(--text-muted)">{{ ucfirst($type) }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs" style="color: var(--text-muted)">Semua produk</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-gradient">{{ $promo->formatted_value }}</span>
                            @if($promo->type === 'percentage' && $promo->max_discount)
                                <div class="text-xs" style="color: var(--text-muted)">Max: Rp {{ number_format($promo->max_discount, 0, ',', '.') }}</div>
                            @endif
                            @if($promo->min_order > 0)
                                <div class="text-xs" style="color: var(--text-muted)">Min: Rp {{ number_format($promo->min_order, 0, ',', '.') }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm" style="color: var(--text-primary)">{{ $promo->start_date->format('d M Y') }}</div>
                            <div class="text-xs" style="color: var(--text-muted)">s/d {{ $promo->end_date->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold" style="color: var(--text-primary)">{{ $promo->used_count }}</span>
                            @if($promo->usage_limit)
                                <span style="color: var(--text-muted)">/ {{ $promo->usage_limit }}</span>
                            @else
                                <span class="text-xs" style="color: var(--text-muted)">(unlimited)</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($promo->end_date < now())
                                <span class="px-2 py-1 rounded text-xs font-bold bg-gray-100 text-gray-600">Expired</span>
                            @elseif($promo->is_active && $promo->isValid())
                                <span class="px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-600">Aktif</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs font-bold bg-red-100 text-red-600">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <form action="{{ route('admin.promos.toggle-status', $promo) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 rounded-lg hover:bg-[var(--bg-tertiary)] transition-colors" 
                                        style="color: {{ $promo->is_active ? 'var(--text-muted)' : 'var(--primary)' }}" 
                                        title="{{ $promo->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas fa-{{ $promo->is_active ? 'toggle-on' : 'toggle-off' }}"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.promos.edit', $promo) }}" class="p-2 rounded-lg hover:bg-[var(--bg-tertiary)] transition-colors" style="color: var(--primary)" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST" class="inline" onsubmit="return confirm('Hapus promo ini?')">
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
                        <td colspan="7" class="px-6 py-12 text-center" style="color: var(--text-muted)">
                            <i class="fas fa-tags text-4xl mb-4 block"></i>
                            Belum ada promo
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($promos->hasPages())
        <div class="px-6 py-4" style="border-top: 1px solid var(--border)">
            {{ $promos->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection

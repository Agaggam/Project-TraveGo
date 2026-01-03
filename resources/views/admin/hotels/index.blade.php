@extends('layouts.admin')

@section('title', 'Kelola Hotel - Admin')
@section('page-title', 'Hotel')

@section('content')
<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
    <div>
        <h2 class="font-serif text-2xl font-bold" style="color: var(--text-primary)">Kelola Hotel</h2>
        <p class="text-sm" style="color: var(--text-muted)">Total: {{ $hotels->total() }} hotel</p>
    </div>
    <a href="{{ route('admin.hotels.create') }}" class="btn-primary px-6 py-3 rounded-xl font-medium mt-4 md:mt-0 inline-flex items-center">
        <i class="fas fa-plus mr-2"></i>Tambah Hotel
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
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Hotel</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Harga/Malam</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Kamar</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Fasilitas</th>
                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Rating</th>
                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y" style="border-color: var(--border)">
                @forelse($hotels as $hotel)
                    <tr class="hover:bg-[var(--bg-tertiary)] transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-12 rounded-lg overflow-hidden flex-shrink-0" style="background: var(--bg-tertiary)">
                                    @if($hotel->gambar_url ?? $hotel->foto)
                                        <img src="{{ $hotel->gambar_url ?? $hotel->foto }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-hotel" style="color: var(--text-muted)"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-medium" style="color: var(--text-primary)">{{ $hotel->nama_hotel ?? $hotel->nama }}</div>
                                    <div class="text-sm" style="color: var(--text-muted)">{{ $hotel->lokasi }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-gradient">Rp {{ number_format($hotel->harga_per_malam, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-bold {{ $hotel->kamar_tersedia > 5 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                {{ $hotel->kamar_tersedia }}/{{ $hotel->kamar_total }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @if($hotel->wifi)<span class="px-1.5 py-0.5 rounded text-[10px]" style="background: var(--bg-tertiary); color: var(--text-muted)">WiFi</span>@endif
                                @if($hotel->kolam_renang)<span class="px-1.5 py-0.5 rounded text-[10px]" style="background: var(--bg-tertiary); color: var(--text-muted)">Pool</span>@endif
                                @if($hotel->restoran)<span class="px-1.5 py-0.5 rounded text-[10px]" style="background: var(--bg-tertiary); color: var(--text-muted)">Resto</span>@endif
                                @if($hotel->gym)<span class="px-1.5 py-0.5 rounded text-[10px]" style="background: var(--bg-tertiary); color: var(--text-muted)">Gym</span>@endif
                                @if($hotel->parkir)<span class="px-1.5 py-0.5 rounded text-[10px]" style="background: var(--bg-tertiary); color: var(--text-muted)">Parkir</span>@endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-amber-500"><i class="fas fa-star mr-1"></i>{{ number_format($hotel->rating, 1) }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('hotel.show', $hotel) }}" target="_blank" class="p-2 rounded-lg hover:bg-[var(--bg-tertiary)] transition-colors" style="color: var(--text-muted)" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.hotels.edit', $hotel) }}" class="p-2 rounded-lg hover:bg-[var(--bg-tertiary)] transition-colors" style="color: var(--primary)" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.hotels.destroy', $hotel) }}" method="POST" class="inline" onsubmit="return confirm('Hapus hotel ini?')">
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
                            <i class="fas fa-hotel text-4xl mb-4 block"></i>
                            Belum ada hotel
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($hotels->hasPages())
        <div class="px-6 py-4" style="border-top: 1px solid var(--border)">
            {{ $hotels->links() }}
        </div>
    @endif
</div>
@endsection

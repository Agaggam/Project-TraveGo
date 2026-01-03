@extends('layouts.admin')

@section('title', 'Kelola Tiket - Admin')
@section('page-title', 'Kelola Tiket')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <p style="color: var(--text-muted)">Total: {{ $tickets->total() }} tiket</p>
        <a href="{{ route('admin.tickets.create') }}" class="btn-primary px-6 py-3 rounded-xl font-semibold inline-flex items-center">
            <i class="fas fa-plus mr-2"></i>Tambah Tiket
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl text-green-800 bg-green-100">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead style="background: var(--bg-tertiary)">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase" style="color: var(--text-muted)">Transportasi</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase" style="color: var(--text-muted)">Rute</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase" style="color: var(--text-muted)">Jadwal</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase" style="color: var(--text-muted)">Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase" style="color: var(--text-muted)">Tersedia</th>
                        <th class="px-6 py-4 text-left text-xs font-medium uppercase" style="color: var(--text-muted)">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-medium uppercase" style="color: var(--text-muted)">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color: var(--border)">
                    @forelse($tickets as $ticket)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: var(--bg-tertiary)">
                                        @if($ticket->jenis_transportasi == 'pesawat')
                                            <i class="fas fa-plane" style="color: var(--primary)"></i>
                                        @elseif($ticket->jenis_transportasi == 'kereta')
                                            <i class="fas fa-train" style="color: var(--accent)"></i>
                                        @else
                                            <i class="fas fa-bus" style="color: var(--text-muted)"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-medium" style="color: var(--text-primary)">{{ $ticket->nama_transportasi }}</div>
                                        <div class="text-xs" style="color: var(--text-muted)">{{ $ticket->kode_transportasi }} • {{ ucfirst($ticket->kelas) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <span style="color: var(--text-primary)">{{ $ticket->asal }}</span>
                                    <i class="fas fa-arrow-right mx-2 text-xs" style="color: var(--text-muted)"></i>
                                    <span style="color: var(--text-primary)">{{ $ticket->tujuan }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div style="color: var(--text-primary)">{{ $ticket->waktu_berangkat->format('d M Y') }}</div>
                                <div class="text-xs" style="color: var(--text-muted)">{{ $ticket->waktu_berangkat->format('H:i') }} - {{ $ticket->waktu_tiba->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold" style="color: var(--primary)">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span style="color: var(--text-primary)">{{ $ticket->tersedia }}/{{ $ticket->kapasitas }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($ticket->aktif)
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.tickets.edit', $ticket) }}" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" title="Edit">
                                        <i class="fas fa-edit" style="color: var(--primary)"></i>
                                    </a>
                                    <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" onsubmit="return confirm('Yakin hapus tiket ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" title="Hapus">
                                            <i class="fas fa-trash text-red-500"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center" style="color: var(--text-muted)">
                                <i class="fas fa-ticket-alt text-4xl mb-3"></i>
                                <p>Belum ada tiket</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $tickets->links() }}
    </div>
</div>
@endsection

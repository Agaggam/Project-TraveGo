@extends('layouts.admin')

@section('title', isset($ticket) ? 'Edit Tiket' : 'Tambah Tiket' . ' - Admin')
@section('page-title', isset($ticket) ? 'Edit Tiket' : 'Tambah Tiket')

@section('content')
<div class="max-w-4xl">
    <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center text-sm font-medium mb-6" style="color: var(--primary)">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>

    <div class="card rounded-2xl p-8">
        <form action="{{ isset($ticket) ? route('admin.tickets.update', $ticket) : route('admin.tickets.store') }}" method="POST">
            @csrf
            @if(isset($ticket)) @method('PUT') @endif

            <div class="space-y-6">
                <!-- Transport Type -->
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Jenis Transportasi *</label>
                    <div class="flex gap-4">
                        @foreach(['pesawat' => 'Pesawat', 'kereta' => 'Kereta', 'bus' => 'Bus'] as $val => $label)
                            <label class="flex items-center px-4 py-3 rounded-xl cursor-pointer transition-colors" style="background: var(--bg-tertiary)">
                                <input type="radio" name="jenis_transportasi" value="{{ $val }}" 
                                    {{ old('jenis_transportasi', $ticket->jenis_transportasi ?? 'pesawat') == $val ? 'checked' : '' }} required>
                                <span class="ml-2" style="color: var(--text-secondary)">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('jenis_transportasi')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Nama Transportasi *</label>
                        <input type="text" name="nama_transportasi" value="{{ old('nama_transportasi', $ticket->nama_transportasi ?? '') }}" required
                            placeholder="contoh: Garuda Indonesia" class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('nama_transportasi')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Kode *</label>
                        <input type="text" name="kode_transportasi" value="{{ old('kode_transportasi', $ticket->kode_transportasi ?? '') }}" required
                            placeholder="contoh: GA-123" class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('kode_transportasi')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Kota Asal *</label>
                        <input type="text" name="asal" value="{{ old('asal', $ticket->asal ?? '') }}" required placeholder="contoh: Jakarta"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('asal')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Kota Tujuan *</label>
                        <input type="text" name="tujuan" value="{{ old('tujuan', $ticket->tujuan ?? '') }}" required placeholder="contoh: Bali"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('tujuan')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Waktu Berangkat *</label>
                        <input type="datetime-local" name="waktu_berangkat" 
                            value="{{ old('waktu_berangkat', isset($ticket) ? $ticket->waktu_berangkat->format('Y-m-d\TH:i') : '') }}" required
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('waktu_berangkat')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Waktu Tiba *</label>
                        <input type="datetime-local" name="waktu_tiba" 
                            value="{{ old('waktu_tiba', isset($ticket) ? $ticket->waktu_tiba->format('Y-m-d\TH:i') : '') }}" required
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('waktu_tiba')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Durasi (menit) *</label>
                        <input type="number" name="durasi_menit" value="{{ old('durasi_menit', $ticket->durasi_menit ?? 60) }}" required min="1"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('durasi_menit')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Harga (IDR) *</label>
                        <input type="number" name="harga" value="{{ old('harga', $ticket->harga ?? '') }}" required min="0"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('harga')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Kapasitas *</label>
                        <input type="number" name="kapasitas" value="{{ old('kapasitas', $ticket->kapasitas ?? 100) }}" required min="1"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Tersedia *</label>
                        <input type="number" name="tersedia" value="{{ old('tersedia', $ticket->tersedia ?? 100) }}" required min="0"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Kelas *</label>
                        <select name="kelas" required class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                            @foreach(['ekonomi' => 'Ekonomi', 'bisnis' => 'Bisnis', 'eksekutif' => 'Eksekutif'] as $val => $label)
                                <option value="{{ $val }}" {{ old('kelas', $ticket->kelas ?? 'ekonomi') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center">
                        <label class="flex items-center cursor-pointer mt-6">
                            <input type="checkbox" name="aktif" value="1" {{ old('aktif', $ticket->aktif ?? true) ? 'checked' : '' }}
                                class="rounded" style="color: var(--primary)">
                            <span class="ml-2" style="color: var(--text-secondary)">Aktif</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Fasilitas</label>
                    <textarea name="fasilitas" rows="3" placeholder="contoh: Bagasi 20kg, Makanan, WiFi"
                        class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)] resize-none"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">{{ old('fasilitas', $ticket->fasilitas ?? '') }}</textarea>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-6" style="border-top: 1px solid var(--border)">
                    <a href="{{ route('admin.tickets.index') }}" class="px-6 py-3 rounded-xl font-medium" style="color: var(--text-muted)">Batal</a>
                    <button type="submit" class="btn-primary px-8 py-3 rounded-xl font-semibold">
                        <i class="fas fa-save mr-2"></i>{{ isset($ticket) ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

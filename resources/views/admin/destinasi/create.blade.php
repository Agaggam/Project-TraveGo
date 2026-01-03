@extends('layouts.admin')

@section('title', isset($destinasi) ? 'Edit Destinasi' : 'Tambah Destinasi' . ' - Admin')
@section('page-title', isset($destinasi) ? 'Edit Destinasi' : 'Tambah Destinasi')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.destinasi.index') }}" class="inline-flex items-center text-sm font-medium mb-6" style="color: var(--primary)">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>

    <div class="card rounded-2xl p-8">
        <form action="{{ isset($destinasi) ? route('admin.destinasi.update', $destinasi) : route('admin.destinasi.store') }}" method="POST">
            @csrf
            @if(isset($destinasi)) @method('PUT') @endif

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Nama Destinasi *</label>
                    <input type="text" name="nama_destinasi" value="{{ old('nama_destinasi', $destinasi->nama_destinasi ?? '') }}" required
                        class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">
                    @error('nama_destinasi')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Kategori *</label>
                        <select name="kategori" required class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                            @foreach(['pantai' => 'Pantai', 'gunung' => 'Gunung', 'kota' => 'Kota', 'alam' => 'Alam', 'budaya' => 'Budaya', 'kuliner' => 'Kuliner', 'petualangan' => 'Petualangan'] as $val => $label)
                                <option value="{{ $val }}" {{ old('kategori', $destinasi->kategori ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('kategori')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Lokasi *</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi', $destinasi->lokasi ?? '') }}" required
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('lokasi')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Harga (IDR) *</label>
                        <input type="number" name="harga" value="{{ old('harga', $destinasi->harga ?? 0) }}" required min="0"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('harga')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Stok *</label>
                        <input type="number" name="stok" value="{{ old('stok', $destinasi->stok ?? 0) }}" required min="0"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('stok')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Rating</label>
                        <input type="number" name="rating" value="{{ old('rating', $destinasi->rating ?? 4.5) }}" step="0.1" min="0" max="5"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Deskripsi *</label>
                    <textarea name="deskripsi" rows="4" required class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)] resize-none"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">{{ old('deskripsi', $destinasi->deskripsi ?? '') }}</textarea>
                    @error('deskripsi')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">URL Gambar</label>
                    @if(isset($destinasi) && $destinasi->gambar_url)
                        <img src="{{ $destinasi->gambar_url }}" alt="" class="w-40 h-28 object-cover rounded-xl mb-3">
                    @endif
                    <input type="url" name="gambar_url" value="{{ old('gambar_url', $destinasi->gambar_url ?? '') }}" placeholder="https://example.com/image.jpg"
                        class="w-full px-4 py-3 rounded-xl border-0" style="background: var(--bg-tertiary); color: var(--text-primary)">
                </div>

                <div class="flex items-center">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $destinasi->is_featured ?? false) ? 'checked' : '' }}
                            class="rounded" style="color: var(--primary)">
                        <span class="ml-2" style="color: var(--text-secondary)">Tampilkan di Homepage (Featured)</span>
                    </label>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-6" style="border-top: 1px solid var(--border)">
                    <a href="{{ route('admin.destinasi.index') }}" class="px-6 py-3 rounded-xl font-medium" style="color: var(--text-muted)">Batal</a>
                    <button type="submit" class="btn-primary px-8 py-3 rounded-xl font-semibold">
                        <i class="fas fa-save mr-2"></i>{{ isset($destinasi) ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

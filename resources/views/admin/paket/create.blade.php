@extends('layouts.admin')

@section('title', isset($paketWisata) ? 'Edit Paket' : 'Tambah Paket' . ' - Admin')
@section('page-title', isset($paketWisata) ? 'Edit Paket' : 'Tambah Paket')

@section('content')
<div class="max-w-4xl">
    <!-- Back -->
    <a href="{{ route('admin.paket.index') }}" class="inline-flex items-center text-sm font-medium mb-6" style="color: var(--primary)">
        <i class="fas fa-arrow-left mr-2"></i>Back to Packages
    </a>

    <div class="card rounded-2xl p-8">
        <form action="{{ isset($paketWisata) ? route('admin.paket.update', $paketWisata) : route('admin.paket.store') }}" method="POST">
            @csrf
            @if(isset($paketWisata))
                @method('PUT')
            @endif

            <div class="space-y-6">
                <!-- Package Name -->
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Package Name *</label>
                    <input type="text" name="nama_paket" value="{{ old('nama_paket', $paketWisata->nama_paket ?? '') }}" required
                        class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">
                    @error('nama_paket')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Location -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Location *</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi', $paketWisata->lokasi ?? '') }}" required
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('lokasi')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <!-- Duration -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Duration *</label>
                        <input type="text" name="durasi" value="{{ old('durasi', $paketWisata->durasi ?? '') }}" required placeholder="e.g. 3 Days 2 Nights"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('durasi')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Price (IDR) *</label>
                        <input type="number" name="harga" value="{{ old('harga', $paketWisata->harga ?? '') }}" required min="0"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('harga')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Available Stock *</label>
                        <input type="number" name="stok" value="{{ old('stok', $paketWisata->stok ?? 10) }}" required min="0"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('stok')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <!-- Rating -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Rating</label>
                        <input type="number" name="rating" value="{{ old('rating', $paketWisata->rating ?? 4.5) }}" step="0.1" min="0" max="5"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Description *</label>
                    <textarea name="deskripsi" rows="5" required
                        class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)] resize-none"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">{{ old('deskripsi', $paketWisata->deskripsi ?? '') }}</textarea>
                    @error('deskripsi')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <!-- Image URL -->
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Image URL</label>
                    @if(isset($paketWisata) && $paketWisata->gambar_url)
                        <div class="mb-3">
                            <img src="{{ $paketWisata->gambar_url }}" alt="" class="w-40 h-28 object-cover rounded-xl">
                        </div>
                    @endif
                    <input type="url" name="gambar_url" value="{{ old('gambar_url', $paketWisata->gambar_url ?? '') }}" placeholder="https://example.com/image.jpg"
                        class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">
                    <p class="text-xs mt-1" style="color: var(--text-muted)">Paste image URL from web (e.g. Unsplash)</p>
                </div>

                <!-- Destinations -->
                @if(isset($destinasis) && $destinasis->count() > 0)
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Included Destinations</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($destinasis as $destinasi)
                            <label class="flex items-center p-3 rounded-xl cursor-pointer transition-colors hover:bg-opacity-80" style="background: var(--bg-tertiary)">
                                <input type="checkbox" name="destinasi_ids[]" value="{{ $destinasi->id }}"
                                    {{ (isset($paketWisata) && $paketWisata->destinasis->contains($destinasi->id)) || (is_array(old('destinasi_ids')) && in_array($destinasi->id, old('destinasi_ids'))) ? 'checked' : '' }}
                                    class="rounded" style="color: var(--primary)">
                                <span class="ml-2 text-sm" style="color: var(--text-secondary)">{{ $destinasi->nama_destinasi }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Submit -->
                <div class="flex items-center justify-end space-x-4 pt-6" style="border-top: 1px solid var(--border)">
                    <a href="{{ route('admin.paket.index') }}" class="px-6 py-3 rounded-xl font-medium" style="color: var(--text-muted)">Cancel</a>
                    <button type="submit" class="btn-primary px-8 py-3 rounded-xl font-semibold">
                        <i class="fas fa-save mr-2"></i>{{ isset($paketWisata) ? 'Update' : 'Create' }} Package
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

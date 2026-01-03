@extends('layouts.admin')

@section('title', isset($hotel) ? 'Edit Hotel' : 'Tambah Hotel' . ' - Admin')
@section('page-title', isset($hotel) ? 'Edit Hotel' : 'Tambah Hotel')

@section('content')
<div class="max-w-4xl">
    <a href="{{ route('admin.hotels.index') }}" class="inline-flex items-center text-sm font-medium mb-6" style="color: var(--primary)">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>

    <div class="card rounded-2xl p-8">
        <form action="{{ isset($hotel) ? route('admin.hotels.update', $hotel) : route('admin.hotels.store') }}" method="POST">
            @csrf
            @if(isset($hotel)) @method('PUT') @endif

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Nama Hotel *</label>
                    <input type="text" name="nama_hotel" value="{{ old('nama_hotel', $hotel->nama_hotel ?? '') }}" required
                        class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">
                    @error('nama_hotel')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Lokasi *</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi', $hotel->lokasi ?? '') }}" required placeholder="contoh: Bali, Indonesia"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('lokasi')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Tipe Kamar</label>
                        <input type="text" name="tipe_kamar" value="{{ old('tipe_kamar', $hotel->tipe_kamar ?? '') }}" placeholder="contoh: Deluxe, Suite"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Standard Room -->
                    <div class="space-y-4 p-4 rounded-xl border border-[var(--border)] bg-[var(--bg-tertiary)]">
                        <h4 class="font-bold text-[var(--primary)]">Standard Room</h4>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Harga (IDR)</label>
                            <input type="number" name="harga_standard" value="{{ old('harga_standard', $hotel->harga_standard ?? '') }}" min="0"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                style="background: var(--bg-secondary); color: var(--text-primary)">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Jumlah Kamar</label>
                            <input type="number" name="kamar_standard" value="{{ old('kamar_standard', $hotel->kamar_standard ?? 0) }}" min="0"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                style="background: var(--bg-secondary); color: var(--text-primary)">
                        </div>
                    </div>

                    <!-- Deluxe Room -->
                    <div class="space-y-4 p-4 rounded-xl border border-[var(--border)] bg-[var(--bg-tertiary)]">
                        <h4 class="font-bold text-[var(--primary)]">Deluxe Room</h4>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Harga (IDR)</label>
                            <input type="number" name="harga_deluxe" value="{{ old('harga_deluxe', $hotel->harga_deluxe ?? '') }}" min="0"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                style="background: var(--bg-secondary); color: var(--text-primary)">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Jumlah Kamar</label>
                            <input type="number" name="kamar_deluxe" value="{{ old('kamar_deluxe', $hotel->kamar_deluxe ?? 0) }}" min="0"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                style="background: var(--bg-secondary); color: var(--text-primary)">
                        </div>
                    </div>

                    <!-- Suite Room -->
                    <div class="space-y-4 p-4 rounded-xl border border-[var(--border)] bg-[var(--bg-tertiary)]">
                        <h4 class="font-bold text-[var(--primary)]">Suite Room</h4>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Harga (IDR)</label>
                            <input type="number" name="harga_suite" value="{{ old('harga_suite', $hotel->harga_suite ?? '') }}" min="0"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                style="background: var(--bg-secondary); color: var(--text-primary)">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Jumlah Kamar</label>
                            <input type="number" name="kamar_suite" value="{{ old('kamar_suite', $hotel->kamar_suite ?? 0) }}" min="0"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                style="background: var(--bg-secondary); color: var(--text-primary)">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Harga Dasar (Start From) *</label>
                        <input type="number" name="harga_per_malam" value="{{ old('harga_per_malam', $hotel->harga_per_malam ?? '') }}" required min="0"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                        @error('harga_per_malam')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Rating</label>
                        <input type="number" name="rating" value="{{ old('rating', $hotel->rating ?? 4.5) }}" step="0.1" min="0" max="5"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Total Kamar (Display)</label>
                        <input type="number" name="kamar_total" value="{{ old('kamar_total', $hotel->kamar_total ?? 50) }}" required min="0"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Kamar Tersedia (Display)</label>
                        <input type="number" name="kamar_tersedia" value="{{ old('kamar_tersedia', $hotel->kamar_tersedia ?? 50) }}" required min="0"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)] resize-none"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">{{ old('deskripsi', $hotel->deskripsi ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">URL Foto</label>
                    @if(isset($hotel) && $hotel->foto)
                        <img src="{{ $hotel->foto }}" alt="" class="w-40 h-28 object-cover rounded-xl mb-3">
                    @endif
                    <input type="url" name="foto" value="{{ old('foto', $hotel->foto ?? '') }}" placeholder="https://example.com/image.jpg"
                        class="w-full px-4 py-3 rounded-xl border-0" style="background: var(--bg-tertiary); color: var(--text-primary)">
                </div>

                <!-- Fasilitas -->
                <div>
                    <label class="block text-sm font-medium mb-3" style="color: var(--text-secondary)">Fasilitas</label>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        @foreach(['wifi' => 'WiFi', 'kolam_renang' => 'Kolam Renang', 'restoran' => 'Restoran', 'gym' => 'Gym', 'parkir' => 'Parkir'] as $key => $label)
                            <label class="flex items-center p-3 rounded-xl cursor-pointer" style="background: var(--bg-tertiary)">
                                <input type="checkbox" name="{{ $key }}" value="1" {{ old($key, $hotel->$key ?? false) ? 'checked' : '' }}
                                    class="rounded" style="color: var(--primary)">
                                <span class="ml-2 text-sm" style="color: var(--text-secondary)">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Status *</label>
                    <select name="status" required class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">
                        <option value="active" {{ old('status', $hotel->status ?? 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $hotel->status ?? '') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-6" style="border-top: 1px solid var(--border)">
                    <a href="{{ route('admin.hotels.index') }}" class="px-6 py-3 rounded-xl font-medium" style="color: var(--text-muted)">Batal</a>
                    <button type="submit" class="btn-primary px-8 py-3 rounded-xl font-semibold">
                        <i class="fas fa-save mr-2"></i>{{ isset($hotel) ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

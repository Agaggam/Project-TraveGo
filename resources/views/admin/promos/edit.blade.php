@extends('layouts.admin')

@section('title', 'Edit Promo - Admin')
@section('page-title', 'Edit Promo')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.promos.index') }}" class="inline-flex items-center text-sm font-medium mb-4" style="color: var(--primary)">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
        <h2 class="font-serif text-2xl font-bold" style="color: var(--text-primary)">Edit Promo: {{ $promo->code }}</h2>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-xl bg-red-100 text-red-800 mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.promos.update', $promo) }}" method="POST" class="card rounded-2xl p-6 space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Kode Promo *</label>
                <input type="text" name="code" value="{{ old('code', $promo->code) }}" required
                    class="w-full px-4 py-3 rounded-xl border-0 uppercase font-mono"
                    style="background: var(--bg-tertiary); color: var(--text-primary)">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Nama Promo *</label>
                <input type="text" name="name" value="{{ old('name', $promo->name) }}" required
                    class="w-full px-4 py-3 rounded-xl border-0"
                    style="background: var(--bg-tertiary); color: var(--text-primary)">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Deskripsi</label>
            <textarea name="description" rows="2" class="w-full px-4 py-3 rounded-xl border-0 resize-none"
                style="background: var(--bg-tertiary); color: var(--text-primary)">{{ old('description', $promo->description) }}</textarea>
        </div>

        <!-- Discount Settings -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Tipe Diskon *</label>
                <select name="type" required class="w-full px-4 py-3 rounded-xl border-0"
                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                    <option value="percentage" {{ old('type', $promo->type) == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                    <option value="fixed_amount" {{ old('type', $promo->type) == 'fixed_amount' ? 'selected' : '' }}>Nominal Tetap (Rp)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Nilai Diskon *</label>
                <input type="number" name="value" value="{{ old('value', $promo->value) }}" required min="0" step="0.01"
                    class="w-full px-4 py-3 rounded-xl border-0"
                    style="background: var(--bg-tertiary); color: var(--text-primary)">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Max Diskon (untuk %)</label>
                <input type="number" name="max_discount" value="{{ old('max_discount', $promo->max_discount) }}" min="0"
                    class="w-full px-4 py-3 rounded-xl border-0"
                    style="background: var(--bg-tertiary); color: var(--text-primary)">
            </div>
        </div>

        <!-- Constraints -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Min. Order (Rp)</label>
                <input type="number" name="min_order" value="{{ old('min_order', $promo->min_order) }}" min="0"
                    class="w-full px-4 py-3 rounded-xl border-0"
                    style="background: var(--bg-tertiary); color: var(--text-primary)">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Limit Penggunaan</label>
                <input type="number" name="usage_limit" value="{{ old('usage_limit', $promo->usage_limit) }}" min="1"
                    class="w-full px-4 py-3 rounded-xl border-0"
                    style="background: var(--bg-tertiary); color: var(--text-primary)"
                    placeholder="Kosong = unlimited">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Limit Per User *</label>
                <input type="number" name="usage_limit_per_user" value="{{ old('usage_limit_per_user', $promo->usage_limit_per_user) }}" required min="1"
                    class="w-full px-4 py-3 rounded-xl border-0"
                    style="background: var(--bg-tertiary); color: var(--text-primary)">
            </div>
        </div>

        <!-- Period -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Tanggal Mulai *</label>
                <input type="date" name="start_date" value="{{ old('start_date', $promo->start_date->format('Y-m-d')) }}" required
                    class="w-full px-4 py-3 rounded-xl border-0"
                    style="background: var(--bg-tertiary); color: var(--text-primary)">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Tanggal Berakhir *</label>
                <input type="date" name="end_date" value="{{ old('end_date', $promo->end_date->format('Y-m-d')) }}" required
                    class="w-full px-4 py-3 rounded-xl border-0"
                    style="background: var(--bg-tertiary); color: var(--text-primary)">
            </div>
        </div>

        <!-- Applicable To -->
        <div>
            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Berlaku Untuk (Kosong = Semua)</label>
            <div class="flex flex-wrap gap-4">
                @foreach(['destinasi', 'hotel', 'tiket', 'paket'] as $type)
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="applicable_to[]" value="{{ $type }}" 
                            {{ in_array($type, old('applicable_to', $promo->applicable_to ?? [])) ? 'checked' : '' }}
                            class="w-5 h-5 rounded" style="accent-color: var(--primary)">
                        <span style="color: var(--text-primary)">{{ ucfirst($type) }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Status -->
        <div>
            <label class="flex items-center space-x-3 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $promo->is_active) ? 'checked' : '' }}
                    class="w-5 h-5 rounded" style="accent-color: var(--primary)">
                <span class="font-medium" style="color: var(--text-primary)">Aktifkan Promo</span>
            </label>
        </div>

        <!-- Stats -->
        <div class="p-4 rounded-xl" style="background: var(--bg-tertiary)">
            <p class="text-sm" style="color: var(--text-muted)">
                <i class="fas fa-chart-bar mr-2"></i>
                Sudah digunakan: <strong>{{ $promo->used_count }}</strong> kali
            </p>
        </div>

        <!-- Submit -->
        <div class="flex gap-4 pt-4">
            <a href="{{ route('admin.promos.index') }}" class="flex-1 py-3 rounded-xl font-medium text-center"
                style="background: var(--bg-tertiary); color: var(--text-primary)">
                Batal
            </a>
            <button type="submit" class="flex-1 btn-primary py-3 rounded-xl font-medium">
                <i class="fas fa-save mr-2"></i>Update Promo
            </button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Checkout ' . $destinasi->nama_destinasi . ' - TraveGo')

@section('content')
<section class="py-12 pt-28" style="background: var(--bg-primary)">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('destinasi.show', $destinasi->slug) }}" class="inline-flex items-center text-sm font-medium mb-4" style="color: var(--primary)">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <h1 class="font-serif text-3xl font-bold" style="color: var(--text-primary)">Pesan Tiket Destinasi</h1>
        </div>

        <form id="checkout-form">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Visitor Info -->
                    <div class="card rounded-2xl p-6">
                        <h3 class="font-serif text-xl font-bold mb-6" style="color: var(--text-primary)">
                            <i class="fas fa-user mr-2" style="color: var(--primary)"></i>Informasi Pengunjung
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Nama Lengkap</label>
                                <input type="text" name="nama_pemesan" value="{{ Auth::user()->name ?? '' }}" required
                                    class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Email</label>
                                <input type="email" name="email" value="{{ Auth::user()->email ?? '' }}" required
                                    class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Telepon</label>
                                <input type="tel" name="phone" required
                                    class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)"
                                    placeholder="08xxxxxxxxxx">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Jumlah Pengunjung</label>
                                <select name="jumlah_peserta" id="jumlah_peserta" required class="w-full px-4 py-3 rounded-xl border-0"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)"
                                    onchange="updateTotal()">
                                    @for($i = 1; $i <= min(10, $destinasi->stok ?? 10); $i++)
                                        <option value="{{ $i }}">{{ $i }} Orang</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Visit Date -->
                    <div class="card rounded-2xl p-6">
                        <h3 class="font-serif text-xl font-bold mb-6" style="color: var(--text-primary)">
                            <i class="fas fa-calendar mr-2" style="color: var(--primary)"></i>Tanggal Kunjungan
                        </h3>
                        <input type="date" name="tanggal_berangkat" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            value="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                            style="background: var(--bg-tertiary); color: var(--text-primary)">
                    </div>
                    
                    <!-- Catatan -->
                    <div class="card rounded-2xl p-6">
                        <h3 class="font-serif text-xl font-bold mb-6" style="color: var(--text-primary)">
                            <i class="fas fa-sticky-note mr-2" style="color: var(--primary)"></i>Catatan (Opsional)
                        </h3>
                        <textarea name="catatan" rows="3" 
                            class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)] resize-none"
                            style="background: var(--bg-tertiary); color: var(--text-primary)"
                            placeholder="Catatan khusus untuk kunjungan Anda..."></textarea>
                    </div>
                </div>

                <!-- Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-28">
                        <div class="card rounded-2xl p-6 shadow-xl">
                            <h3 class="font-serif text-xl font-bold mb-6" style="color: var(--text-primary)">Ringkasan Pesanan</h3>
                            
                            <!-- Destinasi Info -->
                            <div class="flex items-center space-x-4 mb-6 pb-6" style="border-bottom: 1px solid var(--border)">
                                <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0">
                                    @if($destinasi->gambar_url)
                                        <img src="{{ $destinasi->gambar_url }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                                            <i class="fas fa-map-marker-alt text-2xl" style="color: var(--text-muted)"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold" style="color: var(--text-primary)">{{ $destinasi->nama_destinasi }}</h4>
                                    <p class="text-sm" style="color: var(--text-muted)">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $destinasi->lokasi }}
                                    </p>
                                    <span class="inline-block px-2 py-0.5 rounded text-xs mt-1" style="background: var(--bg-tertiary); color: var(--text-muted)">
                                        {{ ucfirst($destinasi->kategori) }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Price Breakdown -->
                            <div class="space-y-3 mb-6 pb-6" style="border-bottom: 1px solid var(--border)">
                                <div class="flex justify-between">
                                    <span style="color: var(--text-muted)">Harga per orang</span>
                                    <span style="color: var(--text-primary)">Rp {{ number_format($destinasi->harga ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span style="color: var(--text-muted)">Jumlah pengunjung</span>
                                    <span id="display-qty" style="color: var(--text-primary)">1 orang</span>
                                </div>
                            </div>
                            
                            <!-- Total -->
                            <div class="flex justify-between items-center mb-6">
                                <span class="font-bold" style="color: var(--text-primary)">Total</span>
                                <span class="text-2xl font-bold text-gradient" id="display-total">Rp {{ number_format($destinasi->harga ?? 0, 0, ',', '.') }}</span>
                            </div>
                            
                            <button type="submit" id="pay-button" class="btn-primary w-full py-4 rounded-xl font-semibold">
                                <i class="fas fa-lock mr-2"></i>Bayar Sekarang
                            </button>
                            
                            <p class="text-center text-xs mt-4" style="color: var(--text-muted)">
                                <i class="fas fa-shield-alt mr-1"></i>Pembayaran aman & terverifikasi
                            </p>
                            
                            <!-- Error Message -->
                            <div id="error-message" class="hidden mt-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Midtrans -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    const hargaPerOrang = {{ $destinasi->harga ?? 0 }};
    
    function updateTotal() {
        const qty = document.getElementById('jumlah_peserta').value;
        const total = hargaPerOrang * qty;
        
        document.getElementById('display-qty').textContent = qty + ' orang';
        document.getElementById('display-total').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        updateTotal();
        
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const button = document.getElementById('pay-button');
            const errorDiv = document.getElementById('error-message');
            
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            errorDiv.classList.add('hidden');
            
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => data[key] = value);
            
            fetch('{{ route("order.destinasi.store", $destinasi->slug) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success && result.snap_token) {
                    snap.pay(result.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = '{{ route("order.history") }}';
                        },
                        onPending: function(result) {
                            window.location.href = '{{ route("order.history") }}';
                        },
                        onError: function(result) {
                            errorDiv.textContent = 'Pembayaran gagal. Silakan coba lagi.';
                            errorDiv.classList.remove('hidden');
                            button.disabled = false;
                            button.innerHTML = '<i class="fas fa-lock mr-2"></i>Bayar Sekarang';
                        },
                        onClose: function() {
                            button.disabled = false;
                            button.innerHTML = '<i class="fas fa-lock mr-2"></i>Bayar Sekarang';
                        }
                    });
                } else {
                    throw new Error(result.message || 'Terjadi kesalahan');
                }
            })
            .catch(error => {
                errorDiv.textContent = error.message || 'Terjadi kesalahan. Silakan coba lagi.';
                errorDiv.classList.remove('hidden');
                button.disabled = false;
                button.innerHTML = '<i class="fas fa-lock mr-2"></i>Bayar Sekarang';
            });
        });
    });
</script>
@endsection

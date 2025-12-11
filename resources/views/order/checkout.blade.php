@extends('layouts.app')

@section('title', 'Checkout - ' . $paketWisata->nama_paket)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-dark-400">
            <li><a href="/" class="hover:text-primary-500">Beranda</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('paket.index') }}" class="hover:text-primary-500">Paket Wisata</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('paket.show', $paketWisata) }}" class="hover:text-primary-500">{{ $paketWisata->nama_paket }}</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900 dark:text-white">Checkout</li>
        </ol>
    </nav>

    <h1 class="text-3xl font-heading font-bold text-gray-900 dark:text-white mb-8">Checkout</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form -->
        <div class="lg:col-span-2">
            <form id="checkoutForm" class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-200 dark:border-dark-700 p-6">
                @csrf
                
                <h2 class="text-xl font-heading font-semibold text-gray-900 dark:text-white mb-6">Data Pemesan</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nama_pemesan" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Nama Lengkap *</label>
                        <input type="text" name="nama_pemesan" id="nama_pemesan" required
                            value="{{ auth()->user()->name }}"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Email *</label>
                        <input type="email" name="email" id="email" required
                            value="{{ auth()->user()->email }}"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Nomor Telepon *</label>
                        <input type="tel" name="phone" id="phone" required placeholder="08123456789"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                    </div>
                    
                    <div>
                        <label for="tanggal_berangkat" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Tanggal Berangkat *</label>
                        <input type="date" name="tanggal_berangkat" id="tanggal_berangkat" required
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                    </div>
                </div>
                
                <div class="mb-6">
                    <label for="jumlah_peserta" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Jumlah Peserta *</label>
                    <div class="flex items-center space-x-4">
                        <button type="button" onclick="updateJumlah(-1)" class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-dark-700 text-gray-700 dark:text-dark-300 hover:bg-gray-200 dark:hover:bg-dark-600 transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </button>
                        <input type="number" name="jumlah_peserta" id="jumlah_peserta" value="1" min="1" max="50" required readonly
                            class="w-20 text-center px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white text-lg font-semibold">
                        <button type="button" onclick="updateJumlah(1)" class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-dark-700 text-gray-700 dark:text-dark-300 hover:bg-gray-200 dark:hover:bg-dark-600 transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                        <span class="text-gray-500 dark:text-dark-400">orang</span>
                    </div>
                </div>
                
                <div class="mb-6">
                    <label for="catatan" class="block text-sm font-medium text-gray-700 dark:text-dark-300 mb-2">Catatan (Opsional)</label>
                    <textarea name="catatan" id="catatan" rows="3" placeholder="Permintaan khusus, alergi makanan, dll."
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-dark-700 border border-gray-200 dark:border-dark-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all resize-none"></textarea>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-dark-800 rounded-2xl border border-gray-200 dark:border-dark-700 p-6 sticky top-24">
                <h2 class="text-xl font-heading font-semibold text-gray-900 dark:text-white mb-6">Ringkasan Pesanan</h2>
                
                <!-- Paket Info -->
                <div class="flex items-start space-x-4 pb-6 border-b border-gray-200 dark:border-dark-700">
                    <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0">
                        @if($paketWisata->gambar_url)
                            <img src="{{ $paketWisata->gambar_url }}" alt="{{ $paketWisata->nama_paket }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary-500 to-accent-500"></div>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $paketWisata->nama_paket }}</h3>
                        <p class="text-sm text-gray-500 dark:text-dark-400">{{ $paketWisata->lokasi }}</p>
                        <p class="text-sm text-gray-500 dark:text-dark-400">{{ $paketWisata->durasi }}</p>
                    </div>
                </div>
                
                <!-- Price Details -->
                <div class="py-6 border-b border-gray-200 dark:border-dark-700 space-y-3">
                    <div class="flex justify-between text-gray-600 dark:text-dark-300">
                        <span>Harga per orang</span>
                        <span>Rp {{ number_format($paketWisata->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600 dark:text-dark-300">
                        <span>Jumlah peserta</span>
                        <span id="summaryJumlah">1 orang</span>
                    </div>
                </div>
                
                <!-- Total -->
                <div class="py-6">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">Total</span>
                        <span id="totalHarga" class="text-2xl font-bold text-primary-500">Rp {{ number_format($paketWisata->harga, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <!-- Pay Button -->
                <button type="button" id="payButton" onclick="processPayment()"
                    class="w-full py-4 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-xl transition-all duration-300 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Bayar Sekarang</span>
                </button>
                
                <!-- Secure Badge -->
                <div class="mt-4 flex items-center justify-center text-sm text-gray-500 dark:text-dark-400">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Pembayaran aman dengan Midtrans
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const hargaPerOrang = {{ $paketWisata->harga }};
    
    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    function updateJumlah(delta) {
        const input = document.getElementById('jumlah_peserta');
        let value = parseInt(input.value) + delta;
        if (value < 1) value = 1;
        if (value > 50) value = 50;
        input.value = value;
        updateTotal();
    }
    
    function updateTotal() {
        const jumlah = parseInt(document.getElementById('jumlah_peserta').value);
        const total = hargaPerOrang * jumlah;
        document.getElementById('summaryJumlah').textContent = jumlah + ' orang';
        document.getElementById('totalHarga').textContent = formatRupiah(total);
    }
    
    function processPayment() {
        const form = document.getElementById('checkoutForm');
        const formData = new FormData(form);
        
        // Validate form
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        const payButton = document.getElementById('payButton');
        payButton.disabled = true;
        payButton.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
        
        fetch('{{ route("order.store", $paketWisata) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                nama_pemesan: formData.get('nama_pemesan'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                tanggal_berangkat: formData.get('tanggal_berangkat'),
                jumlah_peserta: formData.get('jumlah_peserta'),
                catatan: formData.get('catatan'),
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = '{{ route("order.success") }}?order_id=' + data.order_id;
                    },
                    onPending: function(result) {
                        window.location.href = '{{ route("order.success") }}?order_id=' + data.order_id;
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal. Silakan coba lagi.');
                        payButton.disabled = false;
                        payButton.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg> Bayar Sekarang';
                    },
                    onClose: function() {
                        payButton.disabled = false;
                        payButton.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg> Bayar Sekarang';
                    }
                });
            } else {
                alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                payButton.disabled = false;
                payButton.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg> Bayar Sekarang';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
            payButton.disabled = false;
            payButton.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg> Bayar Sekarang';
        });
    }
</script>
@endsection

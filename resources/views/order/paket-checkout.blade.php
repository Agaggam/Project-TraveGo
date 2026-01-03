@extends('layouts.app')

@section('title', 'Checkout - ' . $paketWisata->nama_paket)

@section('content')
<section class="py-12 pt-28" style="background: var(--bg-primary)">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center text-sm mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('home') }}" style="color: var(--text-muted)" class="hover:text-[var(--primary)]"><i class="fas fa-home"></i></a></li>
                <li><i class="fas fa-chevron-right text-xs" style="color: var(--border)"></i></li>
                <li><a href="{{ route('paket.index') }}" style="color: var(--text-muted)" class="hover:text-[var(--primary)]">Paket Wisata</a></li>
                <li><i class="fas fa-chevron-right text-xs" style="color: var(--border)"></i></li>
                <li><a href="{{ route('paket.show', $paketWisata) }}" style="color: var(--text-muted)" class="hover:text-[var(--primary)]">{{ Str::limit($paketWisata->nama_paket, 20) }}</a></li>
                <li><i class="fas fa-chevron-right text-xs" style="color: var(--border)"></i></li>
                <li style="color: var(--primary)" class="font-medium">Checkout</li>
            </ol>
        </nav>
        <h1 class="font-serif text-3xl font-bold" style="color: var(--text-primary)">Selesaikan Pemesanan</h1>
        </div>

        <div x-data="checkoutForm()" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Section -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Info -->
                <div class="card rounded-2xl p-6">
                    <h3 class="font-serif text-xl font-bold mb-6" style="color: var(--text-primary)">
                        <i class="fas fa-user mr-2" style="color: var(--primary)"></i>Personal Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Full Name</label>
                            <input type="text" x-model="formData.nama_pemesan" required
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                style="background: var(--bg-tertiary); color: var(--text-primary)">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Email</label>
                            <input type="email" x-model="formData.email" required
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                style="background: var(--bg-tertiary); color: var(--text-primary)">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Phone Number</label>
                            <input type="tel" x-model="formData.phone" required placeholder="+62"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                style="background: var(--bg-tertiary); color: var(--text-primary)">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">ID Type</label>
                            <select x-model="formData.tipe_identitas"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                style="background: var(--bg-tertiary); color: var(--text-primary)">
                                <option value="KTP">KTP</option>
                                <option value="Passport">Passport</option>
                                <option value="SIM">SIM</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">ID Number</label>
                            <input type="text" x-model="formData.nomor_identitas" required
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                style="background: var(--bg-tertiary); color: var(--text-primary)">
                        </div>
                    </div>
                </div>

                <!-- Trip Details -->
                <div class="card rounded-2xl p-6">
                    <h3 class="font-serif text-xl font-bold mb-6" style="color: var(--text-primary)">
                        <i class="fas fa-calendar mr-2" style="color: var(--primary)"></i>Trip Details
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Departure Date</label>
                            <input type="date" x-model="formData.tanggal_berangkat" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                                style="background: var(--bg-tertiary); color: var(--text-primary)">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Number of Travelers</label>
                            <div class="flex items-center space-x-3">
                                <button type="button" @click="formData.jumlah_peserta = Math.max(1, formData.jumlah_peserta - 1)" class="w-12 h-12 rounded-xl flex items-center justify-center transition-colors" style="background: var(--bg-tertiary); color: var(--text-primary)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" x-model="formData.jumlah_peserta" min="1" max="{{ $paketWisata->stok }}" required readonly
                                    class="w-20 text-center py-3 rounded-xl border-0 font-bold"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                                <button type="button" @click="formData.jumlah_peserta = Math.min({{ $paketWisata->stok }}, formData.jumlah_peserta + 1)" class="w-12 h-12 rounded-xl flex items-center justify-center transition-colors" style="background: var(--bg-tertiary); color: var(--text-primary)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <p class="text-xs mt-2" style="color: var(--text-muted)">Max {{ $paketWisata->stok }} slots available</p>
                        </div>
                    </div>
                </div>

                <!-- Special Requests -->
                <div class="card rounded-2xl p-6">
                    <h3 class="font-serif text-xl font-bold mb-6" style="color: var(--text-primary)">
                        <i class="fas fa-comment mr-2" style="color: var(--primary)"></i>Special Requests (Optional)
                    </h3>
                    <textarea x-model="formData.catatan" rows="3" placeholder="Any special requests or notes..."
                        class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)] resize-none"
                        style="background: var(--bg-tertiary); color: var(--text-primary)"></textarea>
                </div>

                <!-- Promo Code -->
                <div class="card rounded-2xl p-6">
                    <h3 class="font-serif text-xl font-bold mb-6" style="color: var(--text-primary)">
                        <i class="fas fa-tags mr-2" style="color: var(--accent)"></i>Kode Promo
                    </h3>
                    
                    <template x-if="!promoApplied">
                        <div>
                            <div class="flex gap-3">
                                <input type="text" x-model="promoCode" placeholder="Masukkan kode promo"
                                    class="flex-1 px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)] uppercase"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)"
                                    @keydown.enter.prevent="applyPromo()">
                                <button type="button" @click="applyPromo()" :disabled="promoLoading"
                                    class="px-6 py-3 rounded-xl font-medium transition-all"
                                    :style="promoLoading ? 'background: var(--bg-tertiary); color: var(--text-muted)' : 'background: var(--primary); color: white'">
                                    <span x-show="!promoLoading">Terapkan</span>
                                    <span x-show="promoLoading"><i class="fas fa-spinner fa-spin"></i></span>
                                </button>
                            </div>
                            <p x-show="promoError" x-text="promoError" class="text-red-500 text-sm mt-2"></p>
                            <a href="{{ route('promo.index') }}" class="inline-flex items-center text-sm mt-3" style="color: var(--primary)">
                                <i class="fas fa-gift mr-2"></i>Lihat promo tersedia
                            </a>
                        </div>
                    </template>
                    
                    <template x-if="promoApplied">
                        <div class="p-4 rounded-xl" style="background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3)">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: var(--primary); color: white">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold" style="color: var(--primary)" x-text="promoApplied.code"></p>
                                        <p class="text-sm" style="color: var(--text-muted)">Diskon <span x-text="promoApplied.formatted_value"></span></p>
                                    </div>
                                </div>
                                <button type="button" @click="removePromo()" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <p class="text-sm mt-2" style="color: var(--primary)">
                                Anda hemat Rp <span x-text="promoDiscount.toLocaleString('id-ID')"></span>!
                            </p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="sticky top-28">
                    <div class="card rounded-2xl p-6 shadow-xl">
                        <h3 class="font-serif text-xl font-bold mb-6" style="color: var(--text-primary)">Order Summary</h3>
                        
                        <!-- Package Info -->
                        <div class="flex items-center space-x-4 mb-6 pb-6" style="border-bottom: 1px solid var(--border)">
                            <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0">
                                @if($paketWisata->gambar_url)
                                    <img src="{{ $paketWisata->gambar_url }}" alt="{{ $paketWisata->nama_paket }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                                        <i class="fas fa-image" style="color: var(--text-muted)"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold" style="color: var(--text-primary)">{{ $paketWisata->nama_paket }}</h4>
                                <p class="text-sm" style="color: var(--text-muted)">{{ $paketWisata->durasi }} • {{ $paketWisata->lokasi }}</p>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span style="color: var(--text-muted)">Price per person</span>
                                <span style="color: var(--text-primary)">Rp {{ number_format($paketWisata->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span style="color: var(--text-muted)">Travelers</span>
                                <span style="color: var(--text-primary)" x-text="formData.jumlah_peserta + ' person(s)'">1 person(s)</span>
                            </div>
                            <div class="flex justify-between">
                                <span style="color: var(--text-muted)">Subtotal</span>
                                <span style="color: var(--text-primary)" x-text="'Rp ' + (formData.jumlah_peserta * {{ $paketWisata->harga }}).toLocaleString('id-ID')"></span>
                            </div>
                            
                            <!-- Promo Discount -->
                            <template x-if="promoApplied">
                                <div class="flex justify-between" style="color: var(--primary)">
                                    <span><i class="fas fa-tag mr-1"></i>Diskon Promo</span>
                                    <span class="font-medium" x-text="'- Rp ' + promoDiscount.toLocaleString('id-ID')"></span>
                                </div>
                            </template>
                        </div>

                        <div class="pt-4 mb-6" style="border-top: 1px solid var(--border)">
                            <div class="flex justify-between items-center">
                                <span class="font-bold" style="color: var(--text-primary)">Total</span>
                                <span class="text-2xl font-bold text-gradient" x-text="'Rp ' + Math.max(0, (formData.jumlah_peserta * {{ $paketWisata->harga }}) - promoDiscount).toLocaleString('id-ID')">Rp {{ number_format($paketWisata->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Error Message -->
                        <div x-show="errorMessage" x-cloak class="mb-4 p-3 rounded-xl text-sm bg-red-100 text-red-600">
                            <i class="fas fa-exclamation-circle mr-2"></i><span x-text="errorMessage"></span>
                        </div>

                        <button type="button" @click="submitOrder()" :disabled="isLoading" class="btn-primary w-full py-4 rounded-xl font-semibold flex items-center justify-center disabled:opacity-50">
                            <i class="fas fa-lock mr-2" x-show="!isLoading"></i>
                            <i class="fas fa-spinner fa-spin mr-2" x-show="isLoading"></i>
                            <span x-text="isLoading ? 'Processing...' : 'Pay Now'">Pay Now</span>
                        </button>

                        <div class="mt-4 flex items-center justify-center text-xs" style="color: var(--text-muted)">
                            <i class="fas fa-shield-alt mr-2" style="color: var(--primary)"></i>
                            Secure payment via Midtrans
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
function checkoutForm() {
    return {
        formData: {
            nama_pemesan: '{{ Auth::user()->name }}',
            email: '{{ Auth::user()->email }}',
            phone: '',
            tipe_identitas: 'KTP',
            nomor_identitas: '',
            tanggal_berangkat: '',
            jumlah_peserta: 1,
            catatan: ''
        },
        isLoading: false,
        errorMessage: '',
        
        // Promo properties
        promoCode: '',
        promoApplied: null,
        promoDiscount: 0,
        promoLoading: false,
        promoError: '',
        
        price: {{ $paketWisata->harga }},
        
        calculateSubtotal() {
            return this.formData.jumlah_peserta * this.price;
        },
        
        async applyPromo() {
            if (!this.promoCode.trim()) {
                this.promoError = 'Masukkan kode promo';
                return;
            }
            this.promoLoading = true;
            this.promoError = '';
            
            try {
                const response = await fetch('/api/promo/validate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Authorization': 'Bearer ' + (localStorage.getItem('token') || '')
                    },
                    body: JSON.stringify({
                        code: this.promoCode,
                        amount: this.calculateSubtotal(),
                        type: 'paket'
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.promoApplied = data.promo;
                    this.promoDiscount = data.discount;
                    this.promoError = '';
                } else {
                    this.promoError = data.message;
                    this.promoApplied = null;
                    this.promoDiscount = 0;
                }
            } catch (error) {
                this.promoError = 'Terjadi kesalahan saat memvalidasi promo';
            }
            
            this.promoLoading = false;
        },
        
        removePromo() {
            this.promoApplied = null;
            this.promoDiscount = 0;
            this.promoCode = '';
            this.promoError = '';
        },

        async submitOrder() {
            // Validate
            if (!this.formData.nama_pemesan || !this.formData.email || !this.formData.phone || !this.formData.tanggal_berangkat) {
                this.errorMessage = 'Please fill in all required fields';
                return;
            }

            this.isLoading = true;
            this.errorMessage = '';
            
            // Add promo data to form
            const orderData = {
                ...this.formData,
                promo_code: this.promoApplied ? this.promoApplied.code : '',
                discount_amount: this.promoDiscount
            };

            try {
                const response = await fetch('{{ route("order.store", $paketWisata) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(orderData)
                });

                const data = await response.json();

                if (data.success && data.snap_token) {
                    // Open Midtrans Snap
                    window.snap.pay(data.snap_token, {
                        onSuccess: (result) => {
                            window.location.href = '{{ route("order.success") }}?order_id=' + data.order_id;
                        },
                        onPending: (result) => {
                            window.location.href = '{{ route("order.success") }}?order_id=' + data.order_id + '&status=pending';
                        },
                        onError: (result) => {
                            this.errorMessage = 'Payment failed. Please try again.';
                            this.isLoading = false;
                        },
                        onClose: () => {
                            this.isLoading = false;
                        }
                    });
                } else {
                    this.errorMessage = data.message || 'Failed to create order';
                    this.isLoading = false;
                }
            } catch (error) {
                console.error('Error:', error);
                this.errorMessage = 'Network error. Please try again.';
                this.isLoading = false;
            }
        }
    }
}
</script>
@endsection

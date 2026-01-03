@extends('layouts.app')

@section('title', 'Book Ticket')

@section('scripts')
<!-- Midtrans Snap.js -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endsection

@section('content')
<section class="py-12" style="background: var(--bg-primary)"
    x-data="{
        passengers: 1,
        price: {{ $ticket->harga }},
        promoCode: '',
        promoApplied: null,
        promoDiscount: 0,
        promoLoading: false,
        promoError: '',
        calculateSubtotal() {
            return this.price * this.passengers;
        },
        calculateTotal() {
            return Math.max(0, this.calculateSubtotal() - this.promoDiscount);
        },
        formatNumber(num) {
            return num.toLocaleString('id-ID');
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
                        type: 'tiket'
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
        }
    }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center text-sm mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('home') }}" style="color: var(--text-muted)" class="hover:text-[var(--primary)]"><i class="fas fa-home"></i></a></li>
                <li><i class="fas fa-chevron-right text-xs" style="color: var(--border)"></i></li>
                <li><a href="{{ route('tiket.index') }}" style="color: var(--text-muted)" class="hover:text-[var(--primary)]">Tiket</a></li>
                <li><i class="fas fa-chevron-right text-xs" style="color: var(--border)"></i></li>
                <li><a href="{{ route('tiket.show', $ticket) }}" style="color: var(--text-muted)" class="hover:text-[var(--primary)]">{{ Str::limit($ticket->nama_transportasi, 20) }}</a></li>
                <li><i class="fas fa-chevron-right text-xs" style="color: var(--border)"></i></li>
                <li style="color: var(--primary)" class="font-medium">Booking</li>
            </ol>
        </nav>
        <h1 class="font-serif text-3xl font-bold mb-8" style="color: var(--text-primary)">Selesaikan Pemesanan Tiket</h1>

        <form action="{{ route('tiket.booking.store', $ticket) }}" method="POST">
            @csrf
            <input type="hidden" name="promo_code" x-bind:value="promoApplied ? promoApplied.code : ''">
            <input type="hidden" name="discount_amount" x-bind:value="promoDiscount">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Passenger Info -->
                    <div class="card rounded-2xl p-6 shadow-sm border border-[var(--border)]">
                        <h3 class="font-serif text-xl font-bold mb-6 flex items-center" style="color: var(--text-primary)">
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: rgba(var(--primary-rgb), 0.1); color: var(--primary)">
                                <i class="fas fa-user text-sm"></i>
                            </span>
                            Informasi Penumpang
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary)">Nama Lengkap</label>
                                <input type="text" name="nama_penumpang" value="{{ old('nama_penumpang', Auth::user()->name ?? '') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-[var(--border)] focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition-all"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary)">Email</label>
                                <input type="email" name="email_penumpang" value="{{ old('email_penumpang', Auth::user()->email ?? '') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-[var(--border)] focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition-all"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary)">Nomor Telepon</label>
                                <input type="tel" name="telepon_penumpang" required
                                    class="w-full px-4 py-3 rounded-xl border border-[var(--border)] focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition-all"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary)">Tipe Identitas</label>
                                <select name="tipe_identitas" required class="w-full px-4 py-3 rounded-xl border border-[var(--border)] focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition-all"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                                    <option value="KTP">KTP</option>
                                    <option value="Paspor">Paspor</option>
                                    <option value="SIM">SIM</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary)">Nomor Identitas</label>
                                <input type="text" name="nomor_identitas" required
                                    class="w-full px-4 py-3 rounded-xl border border-[var(--border)] focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition-all"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                            </div>
                        </div>
                    </div>

                    <!-- Trip Details -->
                    <div class="card rounded-2xl p-6 shadow-sm border border-[var(--border)]">
                        <h3 class="font-serif text-xl font-bold mb-6 flex items-center" style="color: var(--text-primary)">
                             <span class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: rgba(var(--primary-rgb), 0.1); color: var(--primary)">
                                <i class="fas fa-ticket-alt text-sm"></i>
                            </span>
                            Detail Perjalanan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary)">Jumlah Penumpang</label>
                                <select name="jumlah_tiket" x-model="passengers" @change="promoApplied ? applyPromo() : null" required class="w-full px-4 py-3 rounded-xl border border-[var(--border)] focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition-all"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }} Penumpang</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary)">Tanggal Keberangkatan</label>
                                <div class="px-4 py-3 rounded-xl border border-[var(--border)] bg-[var(--bg-tertiary)] text-[var(--text-muted)]">
                                    {{ \Carbon\Carbon::parse($ticket->waktu_berangkat)->format('d F Y, H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Promo Code -->
                    <div class="card rounded-2xl p-6 shadow-sm border border-[var(--border)]">
                        <h3 class="font-serif text-xl font-bold mb-6 flex items-center" style="color: var(--text-primary)">
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: rgba(245,158,11,0.1); color: var(--accent)">
                                <i class="fas fa-tags text-sm"></i>
                            </span>
                            Kode Promo
                        </h3>
                        
                        <template x-if="!promoApplied">
                            <div>
                                <div class="flex gap-3">
                                    <input type="text" x-model="promoCode" placeholder="Masukkan kode promo"
                                        class="flex-1 px-4 py-3 rounded-xl border border-[var(--border)] focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition-all uppercase"
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
                                    Anda hemat Rp <span x-text="formatNumber(promoDiscount)"></span>!
                                </p>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-28">
                        <div class="card rounded-2xl p-6 shadow-xl border border-[var(--border)]">
                            <h3 class="font-serif text-xl font-bold mb-6" style="color: var(--text-primary)">Ringkasan Pesanan</h3>
                            
                            <div class="mb-6 pb-6 border-b border-dashed" style="border-color: var(--border)">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <div class="text-xs text-[var(--text-muted)] uppercase tracking-wider mb-1">Dari</div>
                                        <span class="text-xl font-bold" style="color: var(--text-primary)">{{ $ticket->asal }}</span>
                                    </div>
                                    <i class="fas fa-arrow-right text-[var(--primary)]"></i>
                                    <div class="text-right">
                                        <div class="text-xs text-[var(--text-muted)] uppercase tracking-wider mb-1">Ke</div>
                                        <span class="text-xl font-bold" style="color: var(--text-primary)">{{ $ticket->tujuan }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 text-sm p-3 rounded-lg bg-[var(--bg-tertiary)] border border-[var(--border)]">
                                    <i class="fas fa-bus text-[var(--primary)]"></i>
                                    <span style="color: var(--text-primary)">{{ $ticket->nama_transportasi }}</span>
                                    <span class="mx-1 text-[var(--text-muted)]">•</span>
                                    <span style="color: var(--text-muted)">{{ $ticket->kelas }}</span>
                                </div>
                            </div>

                            <div class="space-y-4 mb-8">
                                <div class="flex justify-between text-sm">
                                    <span style="color: var(--text-muted)">Harga per tiket</span>
                                    <span class="font-medium" style="color: var(--text-primary)">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span style="color: var(--text-muted)">Jumlah Penumpang</span>
                                    <span class="font-medium" style="color: var(--text-primary)"><span x-text="passengers"></span> Orang</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span style="color: var(--text-muted)">Subtotal</span>
                                    <span class="font-medium" style="color: var(--text-primary)">Rp <span x-text="formatNumber(calculateSubtotal())"></span></span>
                                </div>
                                
                                <!-- Promo Discount -->
                                <template x-if="promoApplied">
                                    <div class="flex justify-between text-sm" style="color: var(--primary)">
                                        <span><i class="fas fa-tag mr-1"></i>Diskon Promo</span>
                                        <span class="font-medium">- Rp <span x-text="formatNumber(promoDiscount)"></span></span>
                                    </div>
                                </template>
                                
                                <div class="pt-4 border-t border-dashed" style="border-color: var(--border)">
                                    <div class="flex justify-between items-end">
                                        <span class="font-bold" style="color: var(--text-primary)">Total Pembayaran</span>
                                        <span class="text-xl font-bold" style="color: var(--primary)">Rp <span x-text="formatNumber(calculateTotal())"></span></span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn-primary w-full py-4 rounded-xl font-bold flex items-center justify-center shadow-lg shadow-[var(--primary)]/20 hover:shadow-[var(--primary)]/40 hover:-translate-y-1 transition-all duration-300">
                                <i class="fas fa-credit-card mr-2"></i>Bayar Sekarang
                            </button>

                            <p class="text-xs text-center mt-4" style="color: var(--text-muted)">
                                <i class="fas fa-shield-alt mr-1" style="color: var(--primary)"></i>
                                Pembayaran aman & terpercaya via Midtrans
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection


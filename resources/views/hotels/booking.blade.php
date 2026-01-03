@section('scripts')
<!-- Midtrans Snap.js -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endsection

@section('content')
<section class="py-12" style="background: var(--bg-primary)"
    x-data="{
        checkIn: '',
        checkOut: '',
        roomType: 'standard',
        nights: 0,
        rooms: 1,
        prices: {
            standard: {{ $hotel->harga_standard ?: $hotel->harga_per_malam }},
            deluxe: {{ $hotel->harga_deluxe ?: $hotel->harga_per_malam * 1.5 }},
            suite: {{ $hotel->harga_suite ?: $hotel->harga_per_malam * 2 }}
        },
        promoCode: '',
        promoApplied: null,
        promoDiscount: 0,
        promoLoading: false,
        promoError: '',
        calculateSubtotal() {
            if (this.checkIn && this.checkOut) {
                const start = new Date(this.checkIn);
                const end = new Date(this.checkOut);
                const diffTime = Math.abs(end - start);
                this.nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
                if(this.nights < 1) this.nights = 0;
            } else {
                this.nights = 0;
            }
            return this.prices[this.roomType] * this.nights * this.rooms;
        },
        calculateTotal() {
            return Math.max(0, this.calculateSubtotal() - this.promoDiscount);
        },
        formatNumber(num) {
            return num.toLocaleString('id-ID');
        },
        getPricePerNight() {
            return this.prices[this.roomType].toLocaleString('id-ID');
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
                        type: 'hotel'
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
                this.promoError = 'Terjadi kesalahan';
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
                <li><a href="{{ route('hotel.index') }}" style="color: var(--text-muted)" class="hover:text-[var(--primary)]">Hotel</a></li>
                <li><i class="fas fa-chevron-right text-xs" style="color: var(--border)"></i></li>
                <li><a href="{{ route('hotel.show', $hotel) }}" style="color: var(--text-muted)" class="hover:text-[var(--primary)]">{{ Str::limit($hotel->nama_hotel, 20) }}</a></li>
                <li><i class="fas fa-chevron-right text-xs" style="color: var(--border)"></i></li>
                <li style="color: var(--primary)" class="font-medium">Booking</li>
            </ol>
        </nav>
        <h1 class="font-serif text-3xl font-bold mb-8" style="color: var(--text-primary)">Selesaikan Reservasi Anda</h1>

        <form action="{{ route('hotel.booking.store', $hotel) }}" method="POST">
            @csrf
            <input type="hidden" name="promo_code" x-bind:value="promoApplied ? promoApplied.code : ''">
            <input type="hidden" name="discount_amount" x-bind:value="promoDiscount">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Guest Info -->
                    <div class="card rounded-2xl p-6 shadow-sm border border-[var(--border)]">
                        <h3 class="font-serif text-xl font-bold mb-6 flex items-center" style="color: var(--text-primary)">
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: rgba(var(--primary-rgb), 0.1); color: var(--primary)">
                                <i class="fas fa-user text-sm"></i>
                            </span>
                            Informasi Tamu
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary)">Nama Lengkap</label>
                                <input type="text" name="nama_pemesan" value="{{ old('nama_pemesan', Auth::user()->name) }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-[var(--border)] focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition-all"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary)">Email</label>
                                <input type="email" name="email_pemesan" value="{{ old('email_pemesan', Auth::user()->email) }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-[var(--border)] focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition-all"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary)">Nomor Telepon</label>
                                <input type="tel" name="telepon_pemesan" value="{{ old('telepon_pemesan') }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-[var(--border)] focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition-all"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary)">Jumlah Tamu</label>
                                <select name="jumlah_tamu" required class="w-full px-4 py-3 rounded-xl border border-[var(--border)] focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition-all"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                                    @for($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}">{{ $i }} Orang</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Stay Details -->
                    <div class="card rounded-2xl p-6 shadow-sm border border-[var(--border)]">
                         <h3 class="font-serif text-xl font-bold mb-6 flex items-center" style="color: var(--text-primary)">
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: rgba(var(--primary-rgb), 0.1); color: var(--primary)">
                                <i class="fas fa-calendar-alt text-sm"></i>
                            </span>
                            Detail Menginap
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary)">Tanggal Check-in</label>
                                <input type="date" name="check_in" x-model="checkIn" @change="promoApplied ? applyPromo() : null" required min="{{ date('Y-m-d') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-[var(--border)] focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition-all"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary)">Tanggal Check-out</label>
                                <input type="date" name="check_out" x-model="checkOut" @change="promoApplied ? applyPromo() : null" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-[var(--border)] focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition-all"
                                    style="background: var(--bg-tertiary); color: var(--text-primary)">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold mb-4" style="color: var(--text-secondary)">Pilih Tipe Kamar</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Standard -->
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="tipe_kamar" value="standard" x-model="roomType" @change="promoApplied ? applyPromo() : null" class="peer sr-only">
                                        <div class="p-4 rounded-xl border-2 transition-all"
                                            :class="roomType === 'standard' ? 'border-[var(--primary)] bg-[rgba(16,185,129,0.05)]' : 'border-[var(--border)] bg-[var(--bg-tertiary)] hover:border-[var(--primary)]'">
                                            <div class="font-bold mb-1" style="color: var(--text-primary)">Standard</div>
                                            <div class="text-sm mb-2" style="color: var(--text-muted)">{{ $hotel->kamar_standard }} tersedia</div>
                                            <div class="font-bold text-[var(--primary)]">Rp {{ number_format($hotel->harga_standard ?: $hotel->harga_per_malam, 0, ',', '.') }}</div>
                                        </div>
                                    </label>
                                    
                                    <!-- Deluxe -->
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="tipe_kamar" value="deluxe" x-model="roomType" @change="promoApplied ? applyPromo() : null" class="peer sr-only">
                                        <div class="p-4 rounded-xl border-2 transition-all"
                                            :class="roomType === 'deluxe' ? 'border-[var(--primary)] bg-[rgba(16,185,129,0.05)]' : 'border-[var(--border)] bg-[var(--bg-tertiary)] hover:border-[var(--primary)]'">
                                            <div class="font-bold mb-1" style="color: var(--text-primary)">Deluxe</div>
                                            <div class="text-sm mb-2" style="color: var(--text-muted)">{{ $hotel->kamar_deluxe }} tersedia</div>
                                            <div class="font-bold text-[var(--primary)]">Rp {{ number_format($hotel->harga_deluxe ?: $hotel->harga_per_malam * 1.5, 0, ',', '.') }}</div>
                                        </div>
                                    </label>

                                    <!-- Suite -->
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="tipe_kamar" value="suite" x-model="roomType" @change="promoApplied ? applyPromo() : null" class="peer sr-only">
                                        <div class="p-4 rounded-xl border-2 transition-all"
                                            :class="roomType === 'suite' ? 'border-[var(--primary)] bg-[rgba(16,185,129,0.05)]' : 'border-[var(--border)] bg-[var(--bg-tertiary)] hover:border-[var(--primary)]'">
                                            <div class="font-bold mb-1" style="color: var(--text-primary)">Suite</div>
                                            <div class="text-sm mb-2" style="color: var(--text-muted)">{{ $hotel->kamar_suite }} tersedia</div>
                                            <div class="font-bold text-[var(--primary)]">Rp {{ number_format($hotel->harga_suite ?: $hotel->harga_per_malam * 2, 0, ',', '.') }}</div>
                                        </div>
                                    </label>
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

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-28">
                        <div class="card rounded-2xl p-6 shadow-xl border border-[var(--border)]">
                            <h3 class="font-serif text-xl font-bold mb-6" style="color: var(--text-primary)">Ringkasan Pesanan</h3>
                            
                            <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-dashed" style="border-color: var(--border)">
                                <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0">
                                    @if($hotel->foto)
                                        <img src="{{ $hotel->foto }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                                            <i class="fas fa-hotel text-xl" style="color: var(--text-muted)"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm line-clamp-1" style="color: var(--text-primary)">{{ $hotel->nama_hotel }}</h4>
                                    <p class="text-xs mt-1" style="color: var(--text-muted)">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $hotel->lokasi }}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-4 mb-8">
                                <div class="flex justify-between text-sm">
                                    <span style="color: var(--text-muted)">Tipe Kamar</span>
                                    <span class="font-medium capitalize" style="color: var(--text-primary)" x-text="roomType"></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span style="color: var(--text-muted)">Harga / Malam</span>
                                    <span class="font-medium" style="color: var(--text-primary)">Rp <span x-text="getPricePerNight()"></span></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span style="color: var(--text-muted)">Durasi Menginap</span>
                                    <span class="font-medium" style="color: var(--text-primary)"><span x-text="nights"></span> Malam</span>
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
                                <i class="fas fa-credit-card mr-2"></i>Lanjut Pembayaran
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

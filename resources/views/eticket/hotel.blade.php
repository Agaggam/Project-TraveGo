@extends('layouts.app')

@section('title', 'E-Voucher Hotel - ' . ($booking->hotel->nama_hotel ?? 'Hotel'))

@section('content')
<section class="py-12 pt-28" style="background: var(--bg-primary)">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Print Button -->
        <div class="flex justify-between items-center mb-6 print:hidden">
            <button onclick="history.back()" class="inline-flex items-center text-sm font-medium cursor-pointer bg-transparent border-0 hover:underline" style="color: var(--primary)">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </button>
            <button onclick="window.print()" class="btn-primary px-6 py-2 rounded-xl font-medium">
                <i class="fas fa-print mr-2"></i>Cetak Voucher
            </button>
        </div>

        <!-- E-Voucher Card -->
        <div class="card rounded-2xl overflow-hidden shadow-2xl" id="eticket">
            <!-- Header -->
            <div class="p-6 text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899)">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold">TraveGo</h1>
                        <p class="text-sm opacity-80">Hotel Voucher</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm opacity-80">Kode Booking</p>
                        <p class="text-xl font-mono font-bold">{{ $booking->kode_booking }}</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Hotel Info -->
                <div class="flex items-center gap-4 mb-6 pb-6" style="border-bottom: 2px dashed var(--border)">
                    <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0" style="background: var(--bg-tertiary)">
                        @if($booking->hotel->foto)
                            <img src="{{ $booking->hotel->foto }}" alt="{{ $booking->hotel->nama_hotel }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-hotel text-3xl" style="color: var(--text-muted)"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-xl font-bold" style="color: var(--text-primary)">{{ $booking->hotel->nama_hotel }}</h2>
                        <p style="color: var(--text-muted)"><i class="fas fa-map-marker-alt mr-1"></i>{{ $booking->hotel->lokasi }}</p>
                        <div class="flex items-center text-amber-500 mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-xs {{ $i <= $booking->hotel->rating ? '' : 'opacity-30' }}"></i>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Stay Details -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="p-4 rounded-xl" style="background: var(--bg-tertiary)">
                        <p class="text-xs uppercase tracking-wider" style="color: var(--text-muted)">Check-In</p>
                        <p class="text-2xl font-bold" style="color: var(--text-primary)">{{ $booking->tanggal_checkin->format('d') }}</p>
                        <p class="text-sm" style="color: var(--text-muted)">{{ $booking->tanggal_checkin->format('M Y') }}</p>
                        <p class="text-xs mt-1" style="color: var(--text-muted)">14:00 WIB</p>
                    </div>
                    <div class="p-4 rounded-xl" style="background: var(--bg-tertiary)">
                        <p class="text-xs uppercase tracking-wider" style="color: var(--text-muted)">Check-Out</p>
                        <p class="text-2xl font-bold" style="color: var(--text-primary)">{{ $booking->tanggal_checkout->format('d') }}</p>
                        <p class="text-sm" style="color: var(--text-muted)">{{ $booking->tanggal_checkout->format('M Y') }}</p>
                        <p class="text-xs mt-1" style="color: var(--text-muted)">12:00 WIB</p>
                    </div>
                </div>

                <!-- Booking Info -->
                <div class="grid grid-cols-2 gap-4 mb-6 pb-6" style="border-bottom: 2px dashed var(--border)">
                    <div>
                        <p class="text-xs uppercase tracking-wider" style="color: var(--text-muted)">Nama Tamu</p>
                        <p class="font-bold" style="color: var(--text-primary)">{{ $booking->nama_tamu }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider" style="color: var(--text-muted)">Tipe Kamar</p>
                        <p class="font-bold" style="color: var(--text-primary)">{{ ucfirst($booking->tipe_kamar ?? 'Standard') }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider" style="color: var(--text-muted)">Durasi</p>
                        <p class="font-bold" style="color: var(--text-primary)">{{ $booking->jumlah_malam }} Malam</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider" style="color: var(--text-muted)">Total</p>
                        <p class="font-bold" style="color: var(--primary)">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- QR Code -->
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-wider mb-2" style="color: var(--text-muted)">Scan untuk verifikasi</p>
                        <img src="{{ $qrCodeUrl }}" alt="QR Code" class="w-32 h-32 rounded-lg">
                    </div>
                    <div class="text-right">
                        <p class="text-xs" style="color: var(--text-muted)">Status</p>
                        <span class="px-3 py-1 rounded-full text-sm font-bold" style="background: rgba(16,185,129,0.1); color: #10b981">
                            <i class="fas fa-check-circle mr-1"></i>CONFIRMED
                        </span>
                        <p class="text-xs mt-2" style="color: var(--text-muted)">Token: {{ Str::limit($token, 8) }}...</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-4 text-center text-xs" style="background: var(--bg-tertiary); color: var(--text-muted)">
                <p>Tunjukkan voucher ini saat check-in di hotel.</p>
                <p class="mt-1">© {{ date('Y') }} TraveGo - www.travego.com</p>
            </div>
        </div>
    </div>
</section>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #eticket, #eticket * {
        visibility: visible;
    }
    #eticket {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
    }
}
</style>
@endsection

@extends('layouts.app')

@section('title', 'E-Ticket - ' . ($booking->ticket->nama_transportasi ?? 'Tiket'))

@section('content')
<section class="py-12 pt-28" style="background: var(--bg-primary)">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Print Button -->
        <div class="flex justify-between items-center mb-6 print:hidden">
            <button onclick="history.back()" class="inline-flex items-center text-sm font-medium cursor-pointer bg-transparent border-0 hover:underline" style="color: var(--primary)">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </button>
            <button onclick="window.print()" class="btn-primary px-6 py-2 rounded-xl font-medium">
                <i class="fas fa-print mr-2"></i>Cetak E-Ticket
            </button>
        </div>

        <!-- E-Ticket Card -->
        <div class="card rounded-2xl overflow-hidden shadow-2xl" id="eticket">
            <!-- Header -->
            <div class="p-6 text-white" style="background: linear-gradient(135deg, var(--primary), var(--accent))">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold">TraveGo</h1>
                        <p class="text-sm opacity-80">E-Ticket Transportasi</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm opacity-80">Kode Booking</p>
                        <p class="text-xl font-mono font-bold">{{ $booking->kode_booking }}</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Transport Info -->
                <div class="flex items-center gap-4 mb-6 pb-6" style="border-bottom: 2px dashed var(--border)">
                    <div class="w-16 h-16 rounded-xl flex items-center justify-center" style="background: var(--bg-tertiary)">
                        @if($booking->ticket->jenis_transportasi == 'pesawat')
                            <i class="fas fa-plane text-3xl" style="color: var(--primary)"></i>
                        @elseif($booking->ticket->jenis_transportasi == 'kereta')
                            <i class="fas fa-train text-3xl" style="color: var(--primary)"></i>
                        @else
                            <i class="fas fa-bus text-3xl" style="color: var(--primary)"></i>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-xl font-bold" style="color: var(--text-primary)">{{ $booking->ticket->nama_transportasi }}</h2>
                        <p style="color: var(--text-muted)">{{ $booking->ticket->kode_transportasi }} • {{ ucfirst($booking->ticket->kelas) }}</p>
                    </div>
                </div>

                <!-- Route -->
                <div class="flex items-center justify-between mb-6">
                    <div class="text-center">
                        <p class="text-3xl font-bold" style="color: var(--text-primary)">{{ $booking->ticket->asal }}</p>
                        <p class="text-sm" style="color: var(--text-muted)">{{ $booking->ticket->waktu_berangkat->format('H:i') }}</p>
                        <p class="text-xs" style="color: var(--text-muted)">{{ $booking->ticket->waktu_berangkat->format('d M Y') }}</p>
                    </div>
                    <div class="flex-1 mx-6">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full" style="background: var(--primary)"></div>
                            <div class="flex-1 h-0.5" style="background: var(--border)"></div>
                            <i class="fas fa-{{ $booking->ticket->jenis_transportasi == 'pesawat' ? 'plane' : ($booking->ticket->jenis_transportasi == 'kereta' ? 'train' : 'bus') }} mx-2" style="color: var(--primary)"></i>
                            <div class="flex-1 h-0.5" style="background: var(--border)"></div>
                            <div class="w-3 h-3 rounded-full" style="background: var(--accent)"></div>
                        </div>
                        <p class="text-center text-xs mt-1" style="color: var(--text-muted)">{{ $booking->ticket->durasi_formatted }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold" style="color: var(--text-primary)">{{ $booking->ticket->tujuan }}</p>
                        <p class="text-sm" style="color: var(--text-muted)">{{ $booking->ticket->waktu_tiba->format('H:i') }}</p>
                        <p class="text-xs" style="color: var(--text-muted)">{{ $booking->ticket->waktu_tiba->format('d M Y') }}</p>
                    </div>
                </div>

                <!-- Passenger Info -->
                <div class="grid grid-cols-2 gap-4 mb-6 pb-6" style="border-bottom: 2px dashed var(--border)">
                    <div>
                        <p class="text-xs uppercase tracking-wider" style="color: var(--text-muted)">Nama Penumpang</p>
                        <p class="font-bold" style="color: var(--text-primary)">{{ $booking->nama_penumpang }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider" style="color: var(--text-muted)">{{ $booking->tipe_identitas }}</p>
                        <p class="font-bold" style="color: var(--text-primary)">{{ $booking->nomor_identitas }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider" style="color: var(--text-muted)">Jumlah Tiket</p>
                        <p class="font-bold" style="color: var(--text-primary)">{{ $booking->jumlah_tiket }} Tiket</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider" style="color: var(--text-muted)">Total Harga</p>
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
                            <i class="fas fa-check-circle mr-1"></i>LUNAS
                        </span>
                        <p class="text-xs mt-2" style="color: var(--text-muted)">Token: {{ Str::limit($token, 8) }}...</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-4 text-center text-xs" style="background: var(--bg-tertiary); color: var(--text-muted)">
                <p>Tunjukkan e-ticket ini saat check-in. E-ticket ini sah sebagai bukti pemesanan.</p>
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

@extends('layouts.app')

@section('title', 'Verifikasi E-Ticket')

@section('content')
<section class="py-12 pt-28 min-h-screen flex items-center" style="background: var(--bg-primary)">
    <div class="max-w-xl mx-auto px-4 w-full">
        <div class="card rounded-2xl p-8 text-center">
            @if($valid)
                <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check-circle text-4xl text-green-500"></i>
                </div>
                <h1 class="text-2xl font-bold mb-2" style="color: var(--text-primary)">E-Ticket Valid</h1>
                <p class="mb-6" style="color: var(--text-muted)">{{ $bookingType }}</p>

                <div class="text-left space-y-4 p-4 rounded-xl" style="background: var(--bg-tertiary)">
                    @if($type === 'ticket')
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Kode Booking</span>
                            <span class="font-bold" style="color: var(--text-primary)">{{ $booking->kode_booking }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Nama Penumpang</span>
                            <span class="font-bold" style="color: var(--text-primary)">{{ $booking->nama_penumpang }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Transportasi</span>
                            <span class="font-bold" style="color: var(--text-primary)">{{ $booking->ticket->nama_transportasi }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Rute</span>
                            <span class="font-bold" style="color: var(--text-primary)">{{ $booking->ticket->asal }} → {{ $booking->ticket->tujuan }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Tanggal</span>
                            <span class="font-bold" style="color: var(--text-primary)">{{ $booking->ticket->waktu_berangkat->format('d M Y, H:i') }}</span>
                        </div>
                    @elseif($type === 'hotel')
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Kode Booking</span>
                            <span class="font-bold" style="color: var(--text-primary)">{{ $booking->kode_booking }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Nama Tamu</span>
                            <span class="font-bold" style="color: var(--text-primary)">{{ $booking->nama_tamu }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Hotel</span>
                            <span class="font-bold" style="color: var(--text-primary)">{{ $booking->hotel->nama_hotel }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Check-In</span>
                            <span class="font-bold" style="color: var(--text-primary)">{{ $booking->tanggal_checkin->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Check-Out</span>
                            <span class="font-bold" style="color: var(--text-primary)">{{ $booking->tanggal_checkout->format('d M Y') }}</span>
                        </div>
                    @elseif($type === 'order')
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Order ID</span>
                            <span class="font-bold" style="color: var(--text-primary)">{{ $booking->order_id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Nama Pemesan</span>
                            <span class="font-bold" style="color: var(--text-primary)">{{ $booking->nama_pemesan }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Tanggal</span>
                            <span class="font-bold" style="color: var(--text-primary)">{{ $booking->tanggal_berangkat->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color: var(--text-muted)">Peserta</span>
                            <span class="font-bold" style="color: var(--text-primary)">{{ $booking->jumlah_peserta }} orang</span>
                        </div>
                    @endif
                </div>

                <div class="mt-6 p-3 rounded-xl bg-green-50 text-green-700 text-sm">
                    <i class="fas fa-shield-alt mr-2"></i>
                    E-Ticket ini terverifikasi dan sah
                </div>
            @else
                <div class="w-20 h-20 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-times-circle text-4xl text-red-500"></i>
                </div>
                <h1 class="text-2xl font-bold mb-2" style="color: var(--text-primary)">E-Ticket Tidak Valid</h1>
                <p class="mb-6" style="color: var(--text-muted)">{{ $message }}</p>

                <a href="{{ route('home') }}" class="btn-primary px-6 py-3 rounded-xl font-medium inline-flex items-center">
                    <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                </a>
            @endif
        </div>
    </div>
</section>
@endsection

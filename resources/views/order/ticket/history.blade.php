@extends('layouts.app')

@section('title', 'Ticket Booking History - TraveGo')

@section('content')
<section class="py-16" style="background: linear-gradient(135deg, #6366f1, #8b5cf6)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-serif text-4xl font-bold text-white mb-2">My Ticket Bookings</h1>
        <p class="text-white/80">View your transportation tickets</p>
    </div>
</section>

<section class="py-12" style="background: var(--bg-primary)">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(isset($bookings) && $bookings->count() > 0)
            <div class="space-y-4">
                @foreach($bookings as $booking)
                    <div class="card rounded-2xl p-6 shadow-sm border border-[var(--border)]">
                        <div class="flex flex-col md:flex-row md:items-center gap-6">
                            <div class="w-16 h-16 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--bg-tertiary)">
                                <i class="fas fa-{{ ($booking->ticket->jenis_transportasi ?? 'flight') == 'pesawat' ? 'plane' : (($booking->ticket->jenis_transportasi ?? '') == 'kereta' ? 'train' : 'bus') }} text-3xl" style="color: var(--primary)"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs font-medium px-2 py-1 rounded" style="background: var(--bg-tertiary); color: var(--text-muted)">
                                        #{{ $booking->kode_booking }}
                                    </span>
                                    @php
                                        $statusColor = match($booking->payment_status) {
                                            'paid', 'success' => 'background: rgba(16,185,129,0.1); color: #10b981',
                                            'pending', 'unpaid' => 'background: rgba(245,158,11,0.1); color: #f59e0b',
                                            'cancelled', 'failed', 'expired' => 'background: rgba(239,68,68,0.1); color: #ef4444',
                                            default => 'background: var(--bg-tertiary); color: var(--text-muted)'
                                        };
                                    @endphp
                                    <span class="text-xs font-bold px-2 py-1 rounded uppercase" style="{{ $statusColor }}">
                                        {{ $booking->payment_status }}
                                    </span>
                                </div>
                                <div class="flex items-center space-x-3 mb-1">
                                    <span class="text-xl font-bold" style="color: var(--text-primary)">{{ $booking->ticket->asal ?? 'Origin' }}</span>
                                    <i class="fas fa-arrow-right text-sm" style="color: var(--text-muted)"></i>
                                    <span class="text-xl font-bold" style="color: var(--text-primary)">{{ $booking->ticket->tujuan ?? 'Destination' }}</span>
                                </div>
                                <p class="text-sm" style="color: var(--text-muted)">
                                    <i class="fas fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($booking->ticket->waktu_berangkat)->format('d M Y, H:i') }} • {{ $booking->jumlah_tiket }} Passenger(s)
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="text-sm" style="color: var(--text-muted)">Total Price</span>
                                <div class="text-xl font-bold text-gradient">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-4 pt-4" style="border-top: 1px solid var(--border)">
                            <span class="text-xs" style="color: var(--text-muted)">Booked on {{ $booking->created_at->format('d M Y') }}</span>
                            <div class="flex gap-3">
                                @if($booking->payment_status == 'paid')
                                    @if($booking->review)
                                        <div class="flex flex-col items-end mr-4">
                                            <div class="flex items-center gap-1 text-yellow-400 text-xs">
                                                @for($i=1; $i<=5; $i++)
                                                     <i class="{{ $i <= $booking->review->rating ? 'fas' : 'far' }} fa-star"></i>
                                                @endfor
                                                <span class="text-gray-500 font-medium ml-1">{{ $booking->review->rating }}.0</span>
                                            </div>
                                            <span class="text-[10px] text-green-600 bg-green-50 px-2 py-0.5 rounded-full mt-1">
                                                <i class="fas fa-check-circle mr-1"></i>Reviewed
                                            </span>
                                        </div>
                                    @else
                                        <a href="{{ route('review.create', ['type' => 'ticket', 'id' => $booking->ticket_id, 'booking_type' => 'TicketBooking', 'booking_id' => $booking->id]) }}" 
                                           class="text-sm font-medium hover:underline" style="color: var(--accent)">
                                            <i class="fas fa-star mr-1"></i>Beri Review
                                        </a>
                                    @endif
                                @endif
                                <a href="{{ route('booking.tiket.show', $booking->id) }}" class="text-sm font-medium flex items-center" style="color: var(--primary)">
                                    View Details <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                    <i class="fas fa-ticket-alt text-4xl" style="color: var(--text-muted)"></i>
                </div>
                <h3 class="font-serif text-2xl font-bold mb-2" style="color: var(--text-primary)">No Ticket Bookings</h3>
                <p class="mb-8" style="color: var(--text-muted)">Book your next journey!</p>
                <a href="{{ route('tiket.index') }}" class="btn-primary px-8 py-4 rounded-xl font-semibold inline-block">Browse Tickets</a>
            </div>
        @endif
    </div>
</section>
@endsection

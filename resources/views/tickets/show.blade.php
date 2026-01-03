@extends('layouts.app')

@section('title', $ticket->nama . ' - TraveGo')

@section('content')
<!-- Hero Section -->
<section class="py-16 pt-24" style="background: linear-gradient(135deg, #6366f1, #8b5cf6)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <button onclick="history.back()" class="inline-flex items-center text-white/80 hover:text-white mb-6 transition-colors cursor-pointer bg-transparent border-0">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </button>
        <div class="text-center">
        <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-white mb-6" style="background: rgba(255,255,255,0.2)">
            <i class="fas fa-{{ $ticket->tipe == 'flight' ? 'plane' : ($ticket->tipe == 'train' ? 'train' : 'bus') }} mr-2"></i>
            {{ ucfirst($ticket->tipe ?? 'Flight') }}
        </div>
        <h1 class="font-serif text-4xl font-bold text-white mb-2">{{ $ticket->asal ?? 'Jakarta' }} → {{ $ticket->tujuan ?? 'Bali' }}</h1>
        <p class="text-white/80">{{ $ticket->operator ?? 'Operator' }}</p>
        </div>
    </div>
</section>

<section class="py-12" style="background: var(--bg-primary)">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Flight Details -->
            <div class="lg:col-span-2 space-y-6">
                <div class="card rounded-2xl p-6">
                    <h3 class="font-serif text-xl font-bold mb-6" style="color: var(--text-primary)">Trip Details</h3>
                    
                    <!-- Route Visualization -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold mb-1" style="color: var(--text-primary)">{{ $ticket->waktu_berangkat ?? '08:00' }}</div>
                            <div class="font-medium" style="color: var(--text-secondary)">{{ $ticket->asal ?? 'Jakarta' }}</div>
                            <div class="text-sm" style="color: var(--text-muted)">{{ $ticket->bandara_asal ?? 'CGK' }}</div>
                        </div>
                        <div class="flex-1 mx-8">
                            <div class="relative">
                                <div class="border-t-2 border-dashed" style="border-color: var(--border)"></div>
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white dark:bg-gray-800 px-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: rgba(16,185,129,0.1)">
                                        <i class="fas fa-plane" style="color: var(--primary)"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-2 text-sm" style="color: var(--text-muted)">{{ $ticket->durasi ?? '2h 30m' }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold mb-1" style="color: var(--text-primary)">{{ $ticket->waktu_tiba ?? '10:30' }}</div>
                            <div class="font-medium" style="color: var(--text-secondary)">{{ $ticket->tujuan ?? 'Bali' }}</div>
                            <div class="text-sm" style="color: var(--text-muted)">{{ $ticket->bandara_tujuan ?? 'DPS' }}</div>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach([
                            ['Operator', $ticket->operator ?? 'Garuda Indonesia', 'fas fa-building'],
                            ['Class', $ticket->kelas ?? 'Economy', 'fas fa-chair'],
                            ['Baggage', ($ticket->bagasi ?? '20') . ' kg', 'fas fa-suitcase'],
                            ['Date', $ticket->tanggal ?? date('d M Y'), 'fas fa-calendar'],
                        ] as $detail)
                            <div class="p-4 rounded-xl text-center" style="background: var(--bg-tertiary)">
                                <i class="{{ $detail[2] }} mb-2" style="color: var(--primary)"></i>
                                <div class="text-xs" style="color: var(--text-muted)">{{ $detail[0] }}</div>
                                <div class="font-bold" style="color: var(--text-primary)">{{ $detail[1] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Inclusions -->
                <div class="card rounded-2xl p-6">
                    <h3 class="font-bold mb-4" style="color: var(--text-primary)">What's Included</h3>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach(['Cabin Baggage 7kg', 'Checked Baggage 20kg', 'In-flight Meal', 'Entertainment', 'Travel Insurance', 'Priority Boarding'] as $item)
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-check-circle" style="color: var(--primary)"></i>
                                <span class="text-sm" style="color: var(--text-secondary)">{{ $item }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Booking Card -->
            <div class="lg:col-span-1">
                <div class="sticky top-28">
                    <div class="card rounded-2xl p-6">
                        <div class="text-center mb-6 pb-6" style="border-bottom: 1px solid var(--border)">
                            <span class="text-sm" style="color: var(--text-muted)">Price per person</span>
                            <div class="text-3xl font-bold text-gradient">Rp {{ number_format($ticket->harga ?? 1500000, 0, ',', '.') }}</div>
                        </div>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span style="color: var(--text-muted)">Available Seats</span>
                                <span class="font-medium" style="color: var(--text-primary)">{{ $ticket->kuota ?? 50 }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span style="color: var(--text-muted)">Refundable</span>
                                <span class="font-medium text-green-500">Yes</span>
                            </div>
                        </div>

                        <a href="{{ route('tiket.booking', $ticket) }}" class="btn-primary w-full py-4 rounded-xl font-semibold flex items-center justify-center">
                            <i class="fas fa-ticket-alt mr-2"></i>Book Ticket
                        </a>

                        <p class="text-xs text-center mt-4" style="color: var(--text-muted)">
                            <i class="fas fa-shield-alt mr-1" style="color: var(--primary)"></i>
                            Secure booking & instant confirmation
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

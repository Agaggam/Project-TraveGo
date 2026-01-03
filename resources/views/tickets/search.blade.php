@extends('layouts.app')

@section('title', 'Search Tickets - TraveGo')

@section('content')
<section class="py-16" style="background: linear-gradient(135deg, #6366f1, #8b5cf6)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-serif text-4xl font-bold text-white mb-4">Find Your Ticket</h1>
        <p class="text-white/80">Search flights, trains, and buses across Indonesia</p>
    </div>
</section>

<section class="py-8 -mt-8 relative z-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card rounded-2xl p-6 shadow-xl">
            <div class="flex gap-2 mb-6">
                @foreach(['flight' => 'Plane', 'train' => 'Train', 'bus' => 'Bus'] as $type => $label)
                    <button type="button" class="flex items-center space-x-2 px-4 py-2 rounded-xl font-medium" 
                        style="background: var(--bg-tertiary); color: var(--text-secondary)">
                        <i class="fas fa-{{ $type == 'flight' ? 'plane' : $type }}"></i>
                        <span>{{ $label }}</span>
                    </button>
                @endforeach
            </div>

            <form action="{{ route('tiket.search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">From</label>
                    <input type="text" name="from" placeholder="Origin" value="{{ request('from') }}"
                        class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">To</label>
                    <input type="text" name="to" placeholder="Destination" value="{{ request('to') }}"
                        class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Date</label>
                    <input type="date" name="date" value="{{ request('date') }}" min="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-[var(--primary)]"
                        style="background: var(--bg-tertiary); color: var(--text-primary)">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full py-3 rounded-xl font-semibold">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="py-12" style="background: var(--bg-primary)">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(isset($tickets) && $tickets->count() > 0)
            <h2 class="font-serif text-2xl font-bold mb-6" style="color: var(--text-primary)">{{ $tickets->count() }} Tickets Found</h2>
            <div class="space-y-4">
                @foreach($tickets as $ticket)
                    <div class="card rounded-2xl p-6">
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            <div class="flex-shrink-0 text-center">
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-2" style="background: var(--bg-tertiary)">
                                    <i class="fas fa-plane text-xl" style="color: var(--primary)"></i>
                                </div>
                                <span class="text-xs" style="color: var(--text-muted)">{{ $ticket->operator ?? 'Operator' }}</span>
                            </div>
                            <div class="flex-1 flex items-center justify-center gap-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold" style="color: var(--text-primary)">{{ $ticket->waktu_berangkat ?? '08:00' }}</div>
                                    <div class="text-sm" style="color: var(--text-muted)">{{ $ticket->asal }}</div>
                                </div>
                                <div class="flex-1 relative px-4">
                                    <div class="border-t-2 border-dashed" style="border-color: var(--border)"></div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold" style="color: var(--text-primary)">{{ $ticket->waktu_tiba ?? '10:30' }}</div>
                                    <div class="text-sm" style="color: var(--text-muted)">{{ $ticket->tujuan }}</div>
                                </div>
                            </div>
                            <div class="flex-shrink-0 text-center">
                                <div class="text-2xl font-bold text-gradient mb-2">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</div>
                                <a href="{{ route('tiket.show', $ticket) }}" class="btn-primary px-6 py-2 rounded-xl text-sm font-medium inline-block">Select</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-search text-4xl mb-4" style="color: var(--text-muted)"></i>
                <p style="color: var(--text-muted)">Search for tickets to see results</p>
            </div>
        @endif
    </div>
</section>
@endsection

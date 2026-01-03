@extends('layouts.app')

@section('title', 'Tulis Review - TraveGo')

@section('content')
<!-- Hero Section -->
<section class="py-16" style="background: linear-gradient(135deg, var(--primary), #0d9488)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-serif text-4xl font-bold text-white mb-2">Tulis Review</h1>
        <p class="text-white/80">Bagikan pengalaman perjalanan Anda</p>
    </div>
</section>

<section class="py-12" style="background: var(--bg-primary)" x-data="{ rating: 0, hover: 0 }">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('review.store') }}" method="POST" class="card rounded-2xl p-8 shadow-lg border border-[var(--border)]">
            @csrf
            
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="booking_type" value="{{ $bookingType }}">
            <input type="hidden" name="booking_id" value="{{ $bookingId }}">

            <!-- Item Info -->
            <div class="flex items-center gap-4 mb-8 pb-8 border-b border-dashed" style="border-color: var(--border)">
                <div class="w-20 h-20 rounded-xl overflow-hidden shrink-0 bg-gray-100 flex items-center justify-center">
                    @if($item && isset($item->gambar_url))
                        <img src="{{ $item->gambar_url }}" alt="" class="w-full h-full object-cover">
                    @elseif($item && isset($item->foto)) 
                         <img src="{{ $item->foto }}" alt="" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-image text-3xl text-gray-400"></i>
                    @endif
                </div>
                <div>
                    <div class="text-sm text-[var(--text-muted)] uppercase tracking-wider mb-1">
                        {{ ucfirst($type == 'paketWisata' ? 'Paket Wisata' : $type) }}
                    </div>
                    <h2 class="font-bold text-xl" style="color: var(--text-primary)">
                        {{ $item->nama_paket ?? $item->nama_hotel ?? $item->nama_destinasi ?? $item->nama_transportasi ?? 'Item Name' }}
                    </h2>
                </div>
            </div>

            @if(session('error'))
                <div class="bg-red-50 text-red-500 p-4 rounded-xl mb-6 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Rating -->
            <div class="mb-8 text-center">
                <label class="block text-sm font-bold mb-4" style="color: var(--text-secondary)">Berapa rating Anda?</label>
                <div class="flex justify-center gap-2">
                    <template x-for="star in 5">
                        <button type="button" 
                            @click="rating = star"
                            @mouseenter="hover = star" 
                            @mouseleave="hover = 0"
                            class="text-3xl transition-all transform hover:scale-110 focus:outline-none">
                            <i class="fas fa-star" 
                               :class="(hover || rating) >= star ? 'text-yellow-400' : 'text-gray-300'"></i>
                        </button>
                    </template>
                </div>
                <input type="hidden" name="rating" x-model="rating" required>
                @error('rating')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Comment -->
            <div class="mb-8">
                <label class="block text-sm font-bold mb-2" style="color: var(--text-secondary)">Ceritakan pengalaman Anda</label>
                <textarea name="comment" rows="5" required minlength="10" maxlength="1000"
                    placeholder="Apa yang paling Anda sukai? Bagaimana pelayanannya?"
                    class="w-full px-4 py-3 rounded-xl border border-[var(--border)] focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent transition-all"
                    style="background: var(--bg-tertiary); color: var(--text-primary)"></textarea>
                @error('comment')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
                <p class="text-xs text-right mt-2" style="color: var(--text-muted)">Min. 10 karakter</p>
            </div>

            <button type="submit" 
                class="btn-primary w-full py-4 rounded-xl font-bold text-white shadow-lg shadow-[var(--primary)]/20 hover:shadow-[var(--primary)]/40 hover:-translate-y-1 transition-all duration-300"
                :disabled="rating === 0"
                :class="rating === 0 ? 'opacity-50 cursor-not-allowed' : ''">
                Kirim Review
            </button>
            
            <a href="{{ route('order.history') }}" class="block text-center mt-6 text-sm hover:underline" style="color: var(--text-muted)">
                Kembali
            </a>
        </form>
    </div>
</section>
@endsection

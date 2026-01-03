@extends('layouts.app')

@section('title', 'My Reviews - TraveGo')

@section('content')
<section class="py-16" style="background: linear-gradient(135deg, var(--primary), #0d9488)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-serif text-4xl font-bold text-white mb-2">My Reviews</h1>
        <p class="text-white/80">Riwayat ulasan perjalanan Anda</p>
    </div>
</section>

<section class="py-12" style="background: var(--bg-primary)">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(isset($reviews) && $reviews->count() > 0)
            <div class="space-y-6">
                @foreach($reviews as $review)
                    <div class="card rounded-2xl p-6 shadow-sm border border-[var(--border)]">
                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Item Info -->
                            <div class="md:w-1/4 flex-shrink-0">
                                @php
                                    $item = $review->reviewable;
                                    $image = $item->gambar_url ?? $item->foto ?? null;
                                    $name = $item->nama_paket ?? $item->nama_hotel ?? $item->nama_destinasi ?? $item->nama_transportasi ?? 'Item';
                                @endphp
                                <div class="w-full h-32 rounded-xl overflow-hidden mb-2">
                                    @if($image)
                                        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-2xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="font-bold text-sm" style="color: var(--text-primary)">{{ $name }}</h3>
                                <div class="text-xs mt-1" style="color: var(--text-muted)">
                                    {{ $review->created_at->format('d M Y') }}
                                </div>
                            </div>

                            <!-- Review Content -->
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center text-yellow-400 text-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star text-gray-300"></i>
                                            @endif
                                        @endfor
                                        <span class="ml-2 font-bold text-gray-700">{{ $review->rating }}.0</span>
                                    </div>
                                    <span class="text-xs px-2 py-1 rounded capitalize {{ $review->status == 'approved' ? 'bg-green-100 text-green-700' : ($review->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                        {{ $review->status }}
                                    </span>
                                </div>
                                
                                <p class="text-gray-600 italic">"{{ $review->comment }}"</p>

                                @if($review->status == 'pending')
                                    <p class="text-xs text-yellow-600 mt-4 bg-yellow-50 p-2 rounded">
                                        <i class="fas fa-info-circle mr-1"></i> Review Anda sedang menunggu persetujuan admin.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                    <i class="fas fa-star text-4xl" style="color: var(--text-muted)"></i>
                </div>
                <h3 class="font-serif text-2xl font-bold mb-2" style="color: var(--text-primary)">Belum Ada Review</h3>
                <p class="mb-8" style="color: var(--text-muted)">Anda belum menulis review apapun.</p>
                <a href="{{ route('order.history') }}" class="btn-primary px-8 py-4 rounded-xl font-semibold inline-block">
                    Lihat Pesanan Saya
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

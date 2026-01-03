@extends('layouts.admin')

@section('title', 'Kelola Reviews - Admin')
@section('page-title', 'Reviews')

@section('content')
<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm" style="color: var(--text-muted)">Menunggu Review</p>
                <h3 class="text-2xl font-bold text-amber-500">{{ $stats['pending'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-amber-100">
                <i class="fas fa-clock text-amber-500"></i>
            </div>
        </div>
    </div>
    <div class="card rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm" style="color: var(--text-muted)">Disetujui</p>
                <h3 class="text-2xl font-bold text-green-500">{{ $stats['approved'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-green-100">
                <i class="fas fa-check text-green-500"></i>
            </div>
        </div>
    </div>
    <div class="card rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm" style="color: var(--text-muted)">Ditolak</p>
                <h3 class="text-2xl font-bold text-red-500">{{ $stats['rejected'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-red-100">
                <i class="fas fa-times text-red-500"></i>
            </div>
        </div>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <h2 class="font-serif text-2xl font-bold" style="color: var(--text-primary)">Moderasi Reviews</h2>
</div>

<!-- Filters -->
<div class="card rounded-xl p-4 mb-6">
    <form action="{{ route('admin.reviews.index') }}" method="GET" class="flex flex-wrap gap-4 items-center">
        <select name="status" class="px-4 py-2 rounded-xl border-0" style="background: var(--bg-tertiary); color: var(--text-primary)">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        <select name="type" class="px-4 py-2 rounded-xl border-0" style="background: var(--bg-tertiary); color: var(--text-primary)">
            <option value="">Semua Tipe</option>
            <option value="destinasi" {{ request('type') == 'destinasi' ? 'selected' : '' }}>Destinasi</option>
            <option value="hotel" {{ request('type') == 'hotel' ? 'selected' : '' }}>Hotel</option>
            <option value="paketWisata" {{ request('type') == 'paketWisata' ? 'selected' : '' }}>Paket Wisata</option>
            <option value="ticket" {{ request('type') == 'ticket' ? 'selected' : '' }}>Tiket</option>
        </select>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari review..." 
            class="px-4 py-2 rounded-xl border-0 flex-1" style="background: var(--bg-tertiary); color: var(--text-primary)">
        <button type="submit" class="btn-primary px-6 py-2 rounded-xl font-medium">
            <i class="fas fa-search mr-2"></i>Filter
        </button>
    </form>
</div>

@if(session('success'))
    <div class="p-4 rounded-xl text-green-800 bg-green-100 mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif

<!-- Reviews List -->
<div class="space-y-4">
    @forelse($reviews as $review)
        <div class="card rounded-xl p-6">
            <div class="flex flex-col lg:flex-row lg:items-start gap-6">
                <!-- User Info -->
                <div class="flex items-center space-x-4 lg:w-1/4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold" style="background: var(--primary)">
                        {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-medium" style="color: var(--text-primary)">{{ $review->user->name ?? 'Unknown User' }}</div>
                        <div class="text-xs" style="color: var(--text-muted)">{{ $review->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>

                <!-- Review Content -->
                <div class="flex-1">
                    <!-- Rating & Target -->
                    <div class="flex items-center gap-4 mb-3">
                        <div class="flex items-center text-amber-500">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? '' : 'opacity-30' }}"></i>
                            @endfor
                            <span class="ml-2 font-bold">{{ $review->rating }}/5</span>
                        </div>
                        <span class="px-2 py-1 rounded text-xs font-medium" style="background: var(--bg-tertiary); color: var(--text-muted)">
                            {{ class_basename($review->reviewable_type) }}: {{ $review->reviewable->nama_destinasi ?? $review->reviewable->nama_hotel ?? $review->reviewable->nama_paket ?? $review->reviewable->nama_transportasi ?? 'Unknown' }}
                        </span>
                    </div>

                    <!-- Comment -->
                    <p class="mb-3" style="color: var(--text-secondary)">{{ $review->comment }}</p>

                    <!-- Photos -->
                    @if($review->photos && count($review->photos) > 0)
                        <div class="flex gap-2 mb-3">
                            @foreach($review->photos as $photo)
                                <img src="{{ $photo }}" alt="Review photo" class="w-16 h-16 rounded-lg object-cover">
                            @endforeach
                        </div>
                    @endif

                    <!-- Status Badge -->
                    <div class="flex items-center gap-2">
                        @if($review->status === 'pending')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-600">
                                <i class="fas fa-clock mr-1"></i>Pending
                            </span>
                        @elseif($review->status === 'approved')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-600">
                                <i class="fas fa-check mr-1"></i>Approved
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-600">
                                <i class="fas fa-times mr-1"></i>Rejected
                            </span>
                        @endif

                        @if($review->moderated_by)
                            <span class="text-xs" style="color: var(--text-muted)">
                                oleh {{ $review->moderator->name ?? 'Admin' }} • {{ $review->moderated_at?->format('d M Y') }}
                            </span>
                        @endif
                    </div>

                    @if($review->admin_notes)
                        <div class="mt-2 p-2 rounded-lg text-sm" style="background: var(--bg-tertiary); color: var(--text-muted)">
                            <strong>Catatan Admin:</strong> {{ $review->admin_notes }}
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex lg:flex-col gap-2">
                    @if($review->status === 'pending')
                        <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-lg bg-green-500 text-white font-medium hover:bg-green-600 transition-colors">
                                <i class="fas fa-check mr-1"></i>Approve
                            </button>
                        </form>
                        <button type="button" onclick="openRejectModal({{ $review->id }})" class="px-4 py-2 rounded-lg bg-red-500 text-white font-medium hover:bg-red-600 transition-colors">
                            <i class="fas fa-times mr-1"></i>Reject
                        </button>
                    @endif
                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Hapus review ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 rounded-lg border border-red-500 text-red-500 font-medium hover:bg-red-50 transition-colors">
                            <i class="fas fa-trash mr-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="card rounded-xl p-12 text-center" style="color: var(--text-muted)">
            <i class="fas fa-comments text-4xl mb-4 block"></i>
            Belum ada review
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($reviews->hasPages())
    <div class="mt-8">
        {{ $reviews->withQueryString()->links() }}
    </div>
@endif

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
    <div class="card rounded-2xl p-6 w-full max-w-md mx-4">
        <h3 class="font-serif text-xl font-bold mb-4" style="color: var(--text-primary)">Tolak Review</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2" style="color: var(--text-secondary)">Alasan Penolakan (Opsional)</label>
                <textarea name="admin_notes" rows="3" class="w-full px-4 py-3 rounded-xl border-0" style="background: var(--bg-tertiary); color: var(--text-primary)" placeholder="Tulis alasan penolakan..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeRejectModal()" class="flex-1 px-4 py-3 rounded-xl font-medium" style="background: var(--bg-tertiary); color: var(--text-primary)">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-3 rounded-xl font-medium bg-red-500 text-white">
                    Tolak Review
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(reviewId) {
    document.getElementById('rejectForm').action = `/admin/reviews/${reviewId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectModal').classList.add('flex');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectModal').classList.remove('flex');
}
</script>
@endsection

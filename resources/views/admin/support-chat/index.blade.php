@extends('layouts.admin')

@section('title', 'Support Chat - Admin')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-serif text-2xl font-bold" style="color: var(--text-primary)">
                <i class="fas fa-headset mr-2" style="color: var(--primary)"></i>
                Support Chat
            </h1>
            <p class="text-sm mt-1" style="color: var(--text-muted)">Kelola percakapan dengan pengguna</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="card p-4 rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium" style="color: var(--text-muted)">Total</p>
                    <p class="text-2xl font-bold" style="color: var(--text-primary)">{{ $stats['total'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(59,130,246,0.1)">
                    <i class="fas fa-comments text-blue-500"></i>
                </div>
            </div>
        </div>
        <div class="card p-4 rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium" style="color: var(--text-muted)">Open</p>
                    <p class="text-2xl font-bold text-green-500">{{ $stats['open'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(16,185,129,0.1)">
                    <i class="fas fa-envelope-open text-green-500"></i>
                </div>
            </div>
        </div>
        <div class="card p-4 rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium" style="color: var(--text-muted)">Unread</p>
                    <p class="text-2xl font-bold text-red-500">{{ $stats['unread'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: rgba(239,68,68,0.1)">
                    <i class="fas fa-bell text-red-500"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="flex gap-2">
        <a href="{{ route('admin.support-chat.index') }}" 
            class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $status === 'all' ? 'text-white' : '' }}"
            style="{{ $status === 'all' ? 'background: var(--primary)' : 'background: var(--bg-tertiary); color: var(--text-secondary)' }}">
            Semua
        </a>
        <a href="{{ route('admin.support-chat.index', ['status' => 'open']) }}" 
            class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $status === 'open' ? 'text-white' : '' }}"
            style="{{ $status === 'open' ? 'background: #10b981' : 'background: var(--bg-tertiary); color: var(--text-secondary)' }}">
            Open
        </a>
    </div>

    {{-- Conversations List --}}
    <div class="card rounded-xl overflow-hidden">
        @if($conversations->count() > 0)
            <div class="divide-y" style="border-color: var(--border)">
                @foreach($conversations as $conversation)
                    <div class="relative group border-b last:border-0" style="border-color: var(--border)">
                        <a href="{{ route('admin.support-chat.show', $conversation) }}" 
                            class="block p-4 hover:bg-[var(--bg-tertiary)] transition-colors {{ $conversation->unread_count > 0 ? 'bg-blue-500/5' : '' }}">
                            <div class="flex items-start gap-4">
                                {{-- Avatar --}}
                                <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-white flex-shrink-0"
                                    style="background: linear-gradient(135deg, var(--primary), var(--accent))">
                                    {{ strtoupper(substr($conversation->user->name ?? 'U', 0, 1)) }}
                                </div>
                                
                                {{-- Content --}}
                                <div class="flex-1 min-w-0 pr-8">
                                    <div class="flex items-center justify-between mb-1">
                                        <h3 class="font-semibold truncate {{ $conversation->unread_count > 0 ? 'text-blue-500' : '' }}" 
                                            style="{{ $conversation->unread_count > 0 ? '' : 'color: var(--text-primary)' }}">
                                            {{ $conversation->user->name ?? 'Unknown User' }}
                                        </h3>
                                        <span class="text-xs flex-shrink-0 ml-2" style="color: var(--text-muted)">
                                            {{ $conversation->last_message_at?->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-sm truncate mb-2" style="color: var(--text-muted)">
                                        {{ $conversation->user->email ?? '' }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm truncate {{ $conversation->unread_count > 0 ? 'font-medium' : '' }}" 
                                            style="color: var(--text-secondary)">
                                            {{ Str::limit($conversation->latestMessage?->message ?? 'Tidak ada pesan', 50) }}
                                        </p>
                                        <div class="flex items-center gap-2 flex-shrink-0 ml-2">
                                            @if($conversation->unread_count > 0)
                                                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-red-500 text-white">
                                                    {{ $conversation->unread_count }}
                                                </span>
                                            @endif
                                            <span class="px-2 py-0.5 rounded text-xs font-medium {{ $conversation->status === 'open' ? 'bg-green-500/10 text-green-500' : 'bg-gray-500/10 text-gray-500' }}">
                                                {{ ucfirst($conversation->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                        {{-- Delete Button --}}
                        <form action="{{ route('admin.support-chat.destroy', $conversation) }}" method="POST" 
                            class="absolute right-4 top-4 z-10"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus percakapan ini secara permanen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="w-8 h-8 rounded-full flex items-center justify-center bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-600 transition-colors opacity-0 group-hover:opacity-100"
                                title="Hapus Percakapan">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
            
            <div class="p-4" style="border-top: 1px solid var(--border)">
                {{ $conversations->withQueryString()->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background: var(--bg-tertiary)">
                    <i class="fas fa-inbox text-2xl" style="color: var(--text-muted)"></i>
                </div>
                <h3 class="font-semibold mb-2" style="color: var(--text-primary)">Tidak Ada Percakapan</h3>
                <p class="text-sm" style="color: var(--text-muted)">Belum ada pesan dari pengguna</p>
            </div>
        @endif
    </div>
</div>
@endsection

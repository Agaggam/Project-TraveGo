@extends('layouts.admin')

@section('title', 'Chat dengan ' . $conversation->user->name)

@section('content')
<div x-data="adminChat()" x-init="init()" 
     class="flex flex-col bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden mx-auto max-w-5xl"
     style="height: calc(100vh - 140px);">
    
    {{-- Header (Fixed) --}}
    <div class="flex-none flex items-center justify-between p-4 bg-white border-b border-gray-100 z-10">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.support-chat.index') }}" class="w-10 h-10 rounded-xl flex items-center justify-center bg-gray-50 text-gray-500 hover:bg-blue-50 hover:text-blue-600 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="relative">
                <div class="w-11 h-11 rounded-full flex items-center justify-center font-bold text-white shadow-md"
                    style="background: linear-gradient(135deg, #3b82f6, #1d4ed8)">
                    {{ strtoupper(substr($conversation->user->name, 0, 1)) }}
                </div>
                <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
            </div>
            <div>
                <h2 class="font-bold text-gray-800 leading-none">{{ $conversation->user->name }}</h2>
                <span class="text-xs text-gray-400">{{ $conversation->user->email }}</span>
            </div>
        </div>
        <button type="button" @click="confirmDelete()" class="text-gray-300 hover:text-red-500 p-2 transition">
            <i class="fas fa-trash-alt"></i>
        </button>
    </div>

    {{-- Messages Area (Scrollable) --}}
    {{-- Penting: flex-1 dan overflow-y-auto harus ada di sini --}}
    <div id="admin-messages" class="flex-1 min-h-0 overflow-y-auto p-4 space-y-4 bg-slate-50 custom-scrollbar">
        @php $lastDate = null; @endphp
        @foreach($messages as $message)
            @if($lastDate !== $message->created_at->format('Y-m-d'))
                @php $lastDate = $message->created_at->format('Y-m-d'); @endphp
                <div class="flex justify-center my-6">
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-gray-200 text-gray-500 uppercase tracking-widest shadow-sm">
                        {{ $message->created_at->translatedFormat('d M Y') }}
                    </span>
                </div>
            @endif
            
            <div class="flex {{ $message->isFromAdmin() ? 'justify-end' : 'justify-start' }} items-end gap-2 group animate-fade-in">
                @if($message->isFromUser()) 
                    <div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center text-[10px] font-bold text-white bg-slate-400 shadow-sm">
                        {{ strtoupper(substr($message->sender->name, 0, 2)) }}
                    </div>
                @endif

                <div class="max-w-[75%] px-4 py-2.5 rounded-2xl shadow-sm text-sm {{ $message->isFromAdmin() 
                    ? 'bg-blue-600 text-white rounded-br-none' 
                    : 'bg-white text-gray-700 border border-gray-100 rounded-bl-none' }}">
                    
                    <p class="leading-relaxed whitespace-pre-wrap">{{ $message->message }}</p>
                    
                    <div class="flex items-center justify-end gap-1 mt-1 opacity-60">
                        <span class="text-[9px] font-medium">{{ $message->created_at->format('H:i') }}</span>
                        @if($message->isFromAdmin())
                            <i class="fas fa-check-double text-[9px] {{ $message->is_read ? 'text-blue-200' : 'text-blue-300/50' }}"></i>
                        @endif
                    </div>
                </div>

                @if($message->isFromAdmin())
                    <div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center text-[10px] font-bold text-white bg-blue-800 shadow-sm">
                        AD
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Input Area (Sticky di bawah) --}}
    <div class="flex-none p-4 bg-white border-t border-gray-100 z-20 relative shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
        <form @submit.prevent="sendMessage()" class="flex items-center gap-2">
            <div class="flex-1">
                <input type="text" x-model="newMessage" 
                    placeholder="Ketik pesan..." 
                    :disabled="sending"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all text-sm outline-none"
                >
            </div>
            <button type="submit" 
                :disabled="!newMessage.trim() || sending"
                class="w-12 h-11 flex items-center justify-center rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition-all disabled:opacity-50">
                <i x-show="!sending" class="fas fa-paper-plane"></i>
                <i x-show="sending" class="fas fa-spinner fa-spin"></i>
            </button>
        </form>
    </div>
</div>

<style>
    /* Agar scrollbar cantik */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    
    .animate-fade-in { animation: fadeIn 0.3s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
</style>

<script>
function adminChat() {
    return {
        newMessage: '',
        sending: false,
        conversationId: {{ $conversation->id }},
        lastMessageId: {{ $messages->last()?->id ?? 0 }},

        init() {
            this.scrollToBottom();
            // Polling setiap 5 detik
            setInterval(() => this.pollMessages(), 5000);
        },

        confirmDelete() {
            if(confirm('Hapus chat ini?')) {
                document.getElementById('delete-chat').submit();
            }
        },

        async sendMessage() {
            if (!this.newMessage.trim() || this.sending) return;
            
            const msg = this.newMessage;
            this.sending = true;
            this.newMessage = '';

            try {
                const response = await fetch(`/admin/support-chat/${this.conversationId}/reply`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message: msg })
                });

                const data = await response.json();
                if (data.success) {
                    this.appendMessage(data.data, true);
                    this.lastMessageId = data.data.id;
                }
            } catch (e) {
                this.newMessage = msg;
                console.error(e);
            } finally {
                this.sending = false;
            }
        },

        async pollMessages() {
            try {
                const response = await fetch(`/admin/support-chat/${this.conversationId}/messages?last_id=${this.lastMessageId}`);
                const data = await response.json();
                if (data.success && data.messages.length > 0) {
                    data.messages.forEach(m => {
                        this.appendMessage(m, m.sender_type === 'admin');
                        this.lastMessageId = m.id;
                    });
                }
            } catch (e) {}
        },

        appendMessage(msg, isAdmin) {
            const container = document.getElementById('admin-messages');
            const div = document.createElement('div');
            div.className = `flex ${isAdmin ? 'justify-end' : 'justify-start'} items-end gap-2 group animate-fade-in`;
            
            div.innerHTML = `
                ${!isAdmin ? `<div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center text-[10px] font-bold text-white bg-slate-400 shadow-sm">${msg.sender_name.substring(0,2).toUpperCase()}</div>` : ''}
                <div class="max-w-[75%] px-4 py-2.5 rounded-2xl shadow-sm text-sm ${isAdmin ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white text-gray-700 border border-gray-100 rounded-bl-none'}">
                    <p class="leading-relaxed whitespace-pre-wrap">${msg.message}</p>
                    <div class="flex items-center justify-end gap-1 mt-1 opacity-60">
                        <span class="text-[9px] font-medium">Just now</span>
                        ${isAdmin ? '<i class="fas fa-check-double text-[9px] text-blue-200"></i>' : ''}
                    </div>
                </div>
                ${isAdmin ? `<div class="w-7 h-7 rounded-full flex-shrink-0 flex items-center justify-center text-[10px] font-bold text-white bg-blue-800 shadow-sm">AD</div>` : ''}
            `;
            container.appendChild(div);
            this.scrollToBottom();
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const el = document.getElementById('admin-messages');
                el.scrollTop = el.scrollHeight;
            });
        }
    }
}
</script>
@endsection
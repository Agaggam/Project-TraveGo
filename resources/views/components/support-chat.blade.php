{{-- Support Chat Widget (Chatbot Clone Style) --}}
@auth
<div x-data="supportChat()" x-cloak>
    {{-- Floating Button --}}
    <button 
        @click="toggleChat()" 
        class="support-fab"
        :class="{ 'active': isOpen }"
    >
        <div class="fab-icon">
            <i x-show="!isOpen" class="fas fa-headset"></i>
            <i x-show="isOpen" class="fas fa-times"></i>
        </div>
        <div class="fab-pulse" x-show="!isOpen"></div>
        
        {{-- Unread Badge --}}
        <span x-show="!isOpen && unreadCount > 0" 
              x-text="unreadCount"
              class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 rounded-full text-xs font-bold flex items-center justify-center border-2 border-white animate-bounce shadow-md z-10 text-white">
        </span>
    </button>

    {{-- Chat Window --}}
    <div 
        x-show="isOpen" 
        x-transition:enter="chat-enter"
        x-transition:enter-start="chat-enter-start"
        x-transition:enter-end="chat-enter-end"
        x-transition:leave="chat-leave"
        x-transition:leave-start="chat-leave-start"
        x-transition:leave-end="chat-leave-end"
        class="support-window glass"
    >
        {{-- Header --}}
        <div class="support-header">
            <div class="header-info">
                <div class="support-avatar">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="header-text">
                    <h4>Live Support</h4>
                    <span class="status">
                        <span class="status-dot"></span>
                        Online - Siap membantu!
                    </span>
                </div>
            </div>
            <div class="header-actions">
                <button @click="toggleChat()" class="action-btn close-btn" title="Tutup">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        {{-- Messages Area --}}
        <div class="support-messages" x-ref="messageContainer" id="support-messages">
            {{-- Welcome Message / Empty State --}}
            <template x-if="!hasActiveConversation && messages.length === 0">
                <div class="welcome-message">
                    <div class="welcome-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3>Butuh Bantuan?</h3>
                    <p>Tim support kami siap menjawab pertanyaan Anda seputar travel, pemesanan, dan lainnya.</p>
                </div>
            </template>

            {{-- Messages --}}
            <template x-for="msg in messages" :key="msg.id">
                <div class="message-wrapper" :class="msg.sender_type === 'user' ? 'user' : 'bot'">
                    <div class="message" :class="msg.sender_type === 'user' ? 'user' : 'bot'">
                        <div class="message-content" x-text="msg.message"></div>
                        <span class="message-time" x-text="msg.created_at"></span>
                    </div>
                </div>
            </template>
            
            <template x-if="conversationStatus === 'closed'">
                <div class="text-center py-2 px-4 my-2">
                    <p class="text-xs text-gray-500 bg-gray-100 rounded-full px-3 py-1 inline-block">
                        <i class="fas fa-check-circle text-green-500 mr-1"></i>
                        Percakapan telah ditutup
                    </p>
                </div>
            </template>
        </div>

        {{-- Input Area --}}
        <div class="support-input">
            <div class="input-wrapper">
                <input 
                    type="text" 
                    x-model="newMessage"
                    @keydown.enter="sendMessage()"
                    placeholder="Tulis pesan Anda..."
                    :disabled="sending || conversationStatus === 'closed'"
                    x-ref="chatInput"
                >
                <button 
                    @click="sendMessage()" 
                    class="send-btn"
                    :disabled="!newMessage.trim() || sending"
                    :class="{ 'active': newMessage.trim() && !sending }"
                >
                    <i class="fas fa-paper-plane" :class="sending ? 'fa-spinner fa-spin' : 'fa-paper-plane'"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Support Variables (Blue Theme) */
    .support-window, .support-fab {
        --support-primary: #3b82f6;
        --support-primary-dark: #1d4ed8;
        --support-accent: #60a5fa;
        --support-bg: #ffffff; /* Or var(--bg-secondary) */
        --support-text: #1f2937;
        --support-muted: #6b7280;
    }

    /* Floating Action Button */
    .support-fab {
        position: fixed;
        bottom: 24px; /* Lower than chatbot */
        right: 24px;
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--support-primary), var(--support-primary-dark));
        border: none;
        cursor: pointer;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 32px rgba(59, 130, 246, 0.4);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .support-fab:hover {
        transform: scale(1.1);
        box-shadow: 0 12px 40px rgba(59, 130, 246, 0.5);
    }

    .support-fab.active {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        box-shadow: 0 8px 32px rgba(239, 68, 68, 0.4);
    }

    .fab-icon {
        color: white;
        font-size: 24px;
        z-index: 2;
    }

    .fab-pulse {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: var(--support-primary);
        animation: pulse 2s infinite;
        z-index: 1;
    }

    .support-fab.active .fab-pulse {
        display: none;
    }
    
    [x-cloak] { display: none !important; }

    /* Chat Window */
    .support-window {
        position: fixed;
        bottom: 100px;
        right: 24px;
        width: 400px;
        max-width: calc(100vw - 48px);
        height: 600px;
        max-height: calc(100vh - 140px);
        border-radius: 24px;
        display: flex;
        flex-direction: column;
        z-index: 9999;
        overflow: hidden;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.25);
        background: var(--support-bg);
        border: 1px solid #e5e7eb;
    }
    
    /* Animations */
    .chat-enter { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .chat-enter-start { opacity: 0; transform: translateY(20px) scale(0.95); }
    .chat-enter-end { opacity: 1; transform: translateY(0) scale(1); }
    .chat-leave { transition: all 0.2s ease-in; }
    .chat-leave-start { opacity: 1; transform: translateY(0) scale(1); }
    .chat-leave-end { opacity: 0; transform: translateY(20px) scale(0.95); }

    /* Header */
    .support-header {
        background: linear-gradient(135deg, var(--support-primary), var(--support-primary-dark));
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .support-avatar {
        width: 44px;
        height: 44px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
    }

    .header-text h4 {
        color: white;
        font-size: 16px;
        font-weight: 600;
        margin: 0;
        font-family: sans-serif;
    }

    .header-text .status {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        background: #4ade80;
        border-radius: 50%;
        animation: blink 2s infinite;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border: none;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    
    .action-btn:hover { background: rgba(255, 255, 255, 0.3); transform: scale(1.05); }

    /* Messages */
    .support-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background: #f9fafb;
        scroll-behavior: smooth;
    }
    
    .welcome-message {
        text-align: center;
        padding: 20px;
    }
    
    .welcome-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--support-primary), var(--support-accent));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 32px;
        color: white;
        animation: float 3s ease-in-out infinite;
    }
    
    .welcome-message h3 {
        color: var(--support-text);
        font-size: 20px;
        margin-bottom: 10px;
        font-weight: bold;
    }
    
    .welcome-message p {
        color: var(--support-muted);
        font-size: 14px;
        line-height: 1.6;
    }

    /* Message Bubbles */
    .message-wrapper {
        display: flex;
        margin-bottom: 16px;
    }
    .message-wrapper.user { justify-content: flex-end; }
    .message-wrapper.bot { justify-content: flex-start; }

    .message {
        max-width: 85%;
        padding: 14px 18px;
        border-radius: 20px;
        position: relative;
    }

    .message.user {
        background: linear-gradient(135deg, var(--support-primary), var(--support-primary-dark));
        color: white;
        border-bottom-right-radius: 6px;
    }

    .message.bot {
        background: white;
        color: var(--support-text);
        border-bottom-left-radius: 6px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    
    .message-content { font-size: 14px; line-height: 1.6; }
    .message-time { font-size: 10px; opacity: 0.7; display: block; margin-top: 5px; }
    .message.user .message-time { text-align: right; text-color: white; }

    /* Input Area */
    .support-input {
        padding: 16px 20px;
        background: white;
        border-top: 1px solid #e5e7eb;
    }

    .input-wrapper {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .input-wrapper input {
        flex: 1;
        padding: 14px 20px;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        font-size: 14px;
        background: #f9fafb;
        color: var(--support-text);
        transition: all 0.2s;
        outline: none;
    }

    .input-wrapper input:focus {
        border-color: var(--support-primary);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        background: white;
    }

    .send-btn {
        width: 50px;
        height: 50px;
        border: none;
        border-radius: 16px;
        background: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.2s;
    }

    .send-btn.active {
        background: linear-gradient(135deg, var(--support-primary), var(--support-primary-dark));
        color: white;
        cursor: pointer;
    }
    
    .send-btn.active:hover { transform: scale(1.05); }

    /* Media Query */
    @media (max-width: 480px) {
        .support-window {
            width: calc(100vw - 32px);
            right: 16px;
            bottom: 90px;
            height: calc(100vh - 120px);
        }
    }
</style>

<script>
function supportChat() {
    return {
        isOpen: false,
        messages: [],
        newMessage: '',
        sending: false,
        conversationId: null,
        conversationStatus: 'open',
        hasActiveConversation: false,
        unreadCount: 0,
        pollingInterval: null,

        init() {
            this.loadActiveConversation();
        },

        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.loadActiveConversation();
                this.startPolling();
                this.$nextTick(() => {
                    this.scrollToBottom();
                    this.$refs.chatInput?.focus();
                });
            } else {
                this.stopPolling();
            }
        },

        async loadActiveConversation() {
            try {
                const response = await fetch('/support/active', {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();
                
                if (data.success && data.has_active) {
                    this.hasActiveConversation = true;
                    this.conversationId = data.conversation.id;
                    this.conversationStatus = data.conversation.status;
                    this.messages = data.messages;
                    this.unreadCount = data.unread_count || 0;
                    window.dispatchEvent(new CustomEvent('update-support-badge', { detail: this.unreadCount }));
                    this.$nextTick(() => this.scrollToBottom());
                }
            } catch (e) {
                console.error('Failed to load conversation', e);
            }
        },

        async sendMessage() {
            if (!this.newMessage.trim() || this.sending) return;
            
            this.sending = true;
            const message = this.newMessage;
            this.newMessage = '';

            try {
                const url = this.conversationId 
                    ? `/support/${this.conversationId}/send` 
                    : '/support/start';
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                
                if (data.success) {
                    if (data.conversation_id) {
                        this.conversationId = data.conversation_id;
                        this.hasActiveConversation = true;
                    }
                    this.messages.push(data.data);
                    this.$nextTick(() => this.scrollToBottom());
                }
            } catch (e) {
                console.error('Failed to send message', e);
                this.newMessage = message;
            } finally {
                this.sending = false;
            }
        },

        async pollMessages() {
            if (!this.conversationId) return;

            const lastId = this.messages.length > 0 ? this.messages[this.messages.length - 1].id : 0;
            
            try {
                const response = await fetch(`/support/${this.conversationId}/messages?last_id=${lastId}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();

                if (data.success && data.messages.length > 0) {
                    this.messages.push(...data.messages);
                    this.conversationStatus = data.status;
                    this.$nextTick(() => this.scrollToBottom());
                }
            } catch (e) {
                console.error('Polling failed', e);
            }
        },

        startPolling() {
            this.pollingInterval = setInterval(() => this.pollMessages(), 5000);
        },

        stopPolling() {
            if (this.pollingInterval) {
                clearInterval(this.pollingInterval);
                this.pollingInterval = null;
            }
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messageContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        }
    }
}
</script>
@endauth

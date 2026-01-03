{{-- AI Chatbot Floating Component --}}
@auth
<div id="chatbot-container" x-data="chatbotWidget()" x-cloak>
    {{-- Floating Button --}}
    <button 
        @click="toggleChat()" 
        class="chatbot-fab"
        :class="{ 'active': isOpen }"
        aria-label="Open AI Assistant"
    >
        <div class="fab-icon">
            <i x-show="!isOpen" class="fas fa-robot"></i>
            <i x-show="isOpen" class="fas fa-times"></i>
        </div>
        <div class="fab-pulse"></div>
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
        class="chatbot-window glass"
    >
        {{-- Header --}}
        <div class="chatbot-header">
            <div class="header-info">
                <div class="ai-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="header-text">
                    <h4>TraveGo AI Assistant</h4>
                    <span class="status">
                        <span class="status-dot"></span>
                        Online - Siap membantu!
                    </span>
                </div>
            </div>
            <div class="header-actions">
                <button @click="clearHistory()" class="action-btn" title="Hapus History">
                    <i class="fas fa-trash-alt"></i>
                </button>
                <button @click="toggleChat()" class="action-btn close-btn" title="Tutup">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        {{-- Messages Area --}}
        <div class="chatbot-messages" x-ref="messageContainer">
            {{-- Welcome Message --}}
            <template x-if="messages.length === 0">
                <div class="welcome-message">
                    <div class="welcome-icon">
                        <i class="fas fa-plane"></i>
                    </div>
                    <h3>Halo! 👋</h3>
                    <p>Saya TraveGo AI Assistant, siap membantu kamu menemukan destinasi wisata, hotel, tiket, dan paket wisata terbaik!</p>
                    <div class="quick-actions">
                        <button @click="sendQuickMessage('Rekomendasikan destinasi wisata populer')" class="quick-btn">
                            <i class="fas fa-map-marker-alt"></i> Destinasi Populer
                        </button>
                        <button @click="sendQuickMessage('Cari hotel murah dengan rating bagus')" class="quick-btn">
                            <i class="fas fa-hotel"></i> Hotel Terbaik
                        </button>
                        <button @click="sendQuickMessage('Cari tiket transportasi tersedia')" class="quick-btn">
                            <i class="fas fa-ticket-alt"></i> Tiket Tersedia
                        </button>
                        <button @click="sendQuickMessage('Paket wisata apa yang tersedia?')" class="quick-btn">
                            <i class="fas fa-suitcase"></i> Paket Wisata
                        </button>
                    </div>
                </div>
            </template>

            {{-- Messages --}}
            <template x-for="(msg, index) in messages" :key="index">
                <div class="message-wrapper" :class="msg.type">
                    <div class="message" :class="msg.type">
                        <div class="message-content" x-html="formatMessage(msg.content)"></div>
                        <span class="message-time" x-text="msg.time"></span>
                    </div>
                </div>
            </template>

            {{-- Typing Indicator --}}
            <div x-show="isTyping" class="message-wrapper bot">
                <div class="message bot typing">
                    <div class="typing-indicator">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Input Area --}}
        <div class="chatbot-input">
            <div class="input-wrapper">
                <input 
                    type="text" 
                    x-model="inputMessage"
                    @keydown.enter="sendMessage()"
                    placeholder="Ketik pertanyaan..."
                    :disabled="isTyping"
                    x-ref="chatInput"
                >
                <button 
                    @click="sendMessage()" 
                    class="send-btn"
                    :disabled="!inputMessage.trim() || isTyping"
                    :class="{ 'active': inputMessage.trim() && !isTyping }"
                >
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <p class="input-hint">
                <i class="fas fa-lightbulb"></i> Tanyakan tentang destinasi, hotel, tiket, atau paket wisata
            </p>
        </div>
    </div>
</div>

<style>
    /* Chatbot Variables */
    :root {
        --chatbot-primary: #10b981;
        --chatbot-primary-dark: #047857;
        --chatbot-accent: #f59e0b;
        --chatbot-bg: var(--bg-secondary);
        --chatbot-text: var(--text-primary);
        --chatbot-muted: var(--text-muted);
    }

    /* Floating Action Button */
    .chatbot-fab {
        position: fixed;
        bottom: 100px; /* Positioned above Support Chat */
        right: 24px;
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--chatbot-primary), var(--chatbot-primary-dark));
        border: none;
        cursor: pointer;
        z-index: 9998;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 32px rgba(16, 185, 129, 0.4);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .chatbot-fab:hover {
        transform: scale(1.1);
        box-shadow: 0 12px 40px rgba(16, 185, 129, 0.5);
    }

    .chatbot-fab.active {
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
        background: var(--chatbot-primary);
        animation: pulse 2s infinite;
        z-index: 1;
    }

    .chatbot-fab.active .fab-pulse {
        display: none;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.3); opacity: 0; }
        100% { transform: scale(1); opacity: 0; }
    }

    /* Chat Window */
    .chatbot-window {
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
    }

    /* Animations */
    .chat-enter { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .chat-enter-start { opacity: 0; transform: translateY(20px) scale(0.95); }
    .chat-enter-end { opacity: 1; transform: translateY(0) scale(1); }
    .chat-leave { transition: all 0.2s ease-in; }
    .chat-leave-start { opacity: 1; transform: translateY(0) scale(1); }
    .chat-leave-end { opacity: 0; transform: translateY(20px) scale(0.95); }

    /* Header */
    .chatbot-header {
        background: linear-gradient(135deg, var(--chatbot-primary), var(--chatbot-primary-dark));
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

    .ai-avatar {
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
        font-family: 'Inter', sans-serif;
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

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .header-actions {
        display: flex;
        gap: 8px;
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

    .action-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }

    /* Messages Area */
    .chatbot-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background: var(--chatbot-bg);
        scroll-behavior: smooth;
    }

    /* Welcome Message */
    .welcome-message {
        text-align: center;
        padding: 20px;
    }

    .welcome-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--chatbot-primary), var(--chatbot-accent));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 32px;
        color: white;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .welcome-message h3 {
        color: var(--chatbot-text);
        font-size: 22px;
        margin-bottom: 10px;
        font-family: 'Playfair Display', serif;
    }

    .welcome-message p {
        color: var(--chatbot-muted);
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .quick-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
    }

    .quick-btn {
        background: var(--bg-tertiary);
        border: 1px solid var(--border);
        padding: 10px 16px;
        border-radius: 20px;
        font-size: 12px;
        color: var(--chatbot-text);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .quick-btn:hover {
        background: var(--chatbot-primary);
        color: white;
        border-color: var(--chatbot-primary);
        transform: translateY(-2px);
    }

    .quick-btn i {
        font-size: 14px;
    }

    /* Message Styles */
    .message-wrapper {
        display: flex;
        margin-bottom: 16px;
    }

    .message-wrapper.user {
        justify-content: flex-end;
    }

    .message-wrapper.bot {
        justify-content: flex-start;
    }

    .message {
        max-width: 85%;
        padding: 14px 18px;
        border-radius: 20px;
        position: relative;
    }

    .message.user {
        background: linear-gradient(135deg, var(--chatbot-primary), var(--chatbot-primary-dark));
        color: white;
        border-bottom-right-radius: 6px;
    }

    .message.bot {
        background: var(--bg-tertiary);
        color: var(--chatbot-text);
        border-bottom-left-radius: 6px;
        border: 1px solid var(--border);
    }

    .message-content {
        font-size: 14px;
        line-height: 1.6;
        word-wrap: break-word;
    }

    .message-content p {
        margin: 0 0 10px;
    }

    .message-content p:last-child {
        margin-bottom: 0;
    }

    .message-content ul, .message-content ol {
        margin: 10px 0;
        padding-left: 20px;
    }

    .message-content li {
        margin-bottom: 6px;
    }

    .message-content strong {
        font-weight: 600;
    }

    .message-time {
        font-size: 10px;
        opacity: 0.7;
        display: block;
        margin-top: 8px;
    }

    .message.user .message-time {
        text-align: right;
    }

    /* Typing Indicator */
    .typing-indicator {
        display: flex;
        gap: 4px;
        padding: 4px 0;
    }

    .typing-indicator span {
        width: 8px;
        height: 8px;
        background: var(--chatbot-muted);
        border-radius: 50%;
        animation: typing 1.4s infinite;
    }

    .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes typing {
        0%, 100% { transform: translateY(0); opacity: 0.4; }
        50% { transform: translateY(-6px); opacity: 1; }
    }

    /* Input Area */
    .chatbot-input {
        padding: 16px 20px;
        background: var(--chatbot-bg);
        border-top: 1px solid var(--border);
    }

    .input-wrapper {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .input-wrapper input {
        flex: 1;
        padding: 14px 20px;
        border: 2px solid var(--border);
        border-radius: 16px;
        font-size: 14px;
        background: var(--bg-tertiary);
        color: var(--chatbot-text);
        transition: all 0.2s;
        outline: none;
    }

    .input-wrapper input:focus {
        border-color: var(--chatbot-primary);
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .input-wrapper input::placeholder {
        color: var(--chatbot-muted);
    }

    .send-btn {
        width: 50px;
        height: 50px;
        border: none;
        border-radius: 16px;
        background: var(--bg-tertiary);
        color: var(--chatbot-muted);
        cursor: not-allowed;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.2s;
    }

    .send-btn.active {
        background: linear-gradient(135deg, var(--chatbot-primary), var(--chatbot-primary-dark));
        color: white;
        cursor: pointer;
    }

    .send-btn.active:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .input-hint {
        font-size: 11px;
        color: var(--chatbot-muted);
        text-align: center;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .input-hint i {
        color: var(--chatbot-accent);
    }

    /* Scrollbar */
    .chatbot-messages::-webkit-scrollbar {
        width: 6px;
    }

    .chatbot-messages::-webkit-scrollbar-track {
        background: transparent;
    }

    .chatbot-messages::-webkit-scrollbar-thumb {
        background: var(--chatbot-muted);
        border-radius: 3px;
    }

    /* Mobile Responsive */
    @media (max-width: 480px) {
        .chatbot-window {
            width: calc(100vw - 16px);
            right: 8px;
            bottom: 90px;
            height: calc(100vh - 120px);
            border-radius: 20px;
        }

        .chatbot-fab {
            right: 16px;
            bottom: 16px;
            width: 56px;
            height: 56px;
        }

        .fab-icon {
            font-size: 20px;
        }

        .quick-btn {
            font-size: 11px;
            padding: 8px 12px;
        }
    }

    [x-cloak] { display: none !important; }
</style>

<script>
    function chatbotWidget() {
        return {
            isOpen: false,
            isTyping: false,
            inputMessage: '',
            messages: [],
            
            init() {
                this.loadHistory();
            },

            toggleChat() {
                this.isOpen = !this.isOpen;
                if (this.isOpen) {
                    this.$nextTick(() => {
                        this.$refs.chatInput?.focus();
                        this.scrollToBottom();
                    });
                }
            },

            async loadHistory() {
                try {
                    const response = await fetch('{{ route("chatbot.history") }}');
                    const data = await response.json();
                    
                    if (data.success && data.history.length > 0) {
                        data.history.forEach(chat => {
                            this.messages.push({
                                type: 'user',
                                content: chat.message,
                                time: this.formatTime(new Date(chat.created_at))
                            });
                            this.messages.push({
                                type: 'bot',
                                content: chat.response,
                                time: this.formatTime(new Date(chat.created_at))
                            });
                        });
                    }
                } catch (error) {
                    console.error('Failed to load chat history:', error);
                }
            },

            async sendMessage() {
                const message = this.inputMessage.trim();
                if (!message || this.isTyping) return;
                
                // Add user message
                this.messages.push({
                    type: 'user',
                    content: message,
                    time: this.formatTime(new Date())
                });
                
                this.inputMessage = '';
                this.isTyping = true;
                this.scrollToBottom();

                try {
                    const response = await fetch('{{ route("chatbot.send") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ message })
                    });

                    const data = await response.json();
                    
                    this.messages.push({
                        type: 'bot',
                        content: data.response || 'Maaf, terjadi kesalahan.',
                        time: this.formatTime(new Date())
                    });
                } catch (error) {
                    this.messages.push({
                        type: 'bot',
                        content: 'Maaf, terjadi kesalahan koneksi. Silakan coba lagi.',
                        time: this.formatTime(new Date())
                    });
                }
                
                this.isTyping = false;
                this.scrollToBottom();
            },

            sendQuickMessage(message) {
                this.inputMessage = message;
                this.sendMessage();
            },

            async clearHistory() {
                if (!confirm('Hapus semua history chat?')) return;
                
                try {
                    await fetch('{{ route("chatbot.clear") }}', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    this.messages = [];
                } catch (error) {
                    console.error('Failed to clear history:', error);
                }
            },

            formatMessage(text) {
                // Convert markdown-like formatting
                return text
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/\*(.*?)\*/g, '<em>$1</em>')
                    .replace(/\n/g, '<br>')
                    .replace(/• /g, '• ')
                    .replace(/(\d+)\. /g, '$1. ');
            },

            formatTime(date) {
                return date.toLocaleTimeString('id-ID', { 
                    hour: '2-digit', 
                    minute: '2-digit' 
                });
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

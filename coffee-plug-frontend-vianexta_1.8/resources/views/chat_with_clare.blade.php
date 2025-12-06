@extends('layouts.new_home_layout')
@section('title', 'Chat with Clare')

@push('css')
<style>
    body {
        margin: 0;
        font-family: 'Inter', Arial, sans-serif;
        background: #f5f7fc;
    }

    .chat-page-container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .chat-header {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        padding: 1.5rem 0;
        text-align: center;
    }

    .chat-header h1 {
        color: #07382f;
        margin: 0;
        font-size: 2rem;
        font-weight: 600;
    }

    .chat-header p {
        color: #6b7280;
        margin: 0.5rem 0 0 0;
        font-size: 1.1rem;
    }

    .chat-main {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem 1rem;
    }

    .chat-welcome-card {
        background: #fff;
        border-radius: 16px;
        padding: 3rem;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        width: 100%;
    }

    .chat-welcome-card h2 {
        color: #07382f;
        margin-bottom: 1rem;
        font-size: 1.75rem;
        font-weight: 600;
    }

    .chat-welcome-card p {
        color: #6b7280;
        margin-bottom: 2rem;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .start-chat-btn {
        background: #07382f;
        color: #fff;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .start-chat-btn:hover {
        background: #0a4a3a;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(7, 56, 47, 0.3);
    }

    .chat-features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .feature-item {
        text-align: center;
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }

    .feature-item h3 {
        color: #07382f;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .feature-item p {
        color: #6b7280;
        font-size: 0.9rem;
        margin: 0;
    }

    /* Chat functionality styles */
    .clare-chat-btn {
        position: fixed;
        z-index: 9999;
        bottom: 2rem;
        right: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2rem;
        border-radius: 9999px;
        background: #07382F;
        color: #fff;
        font-weight: 500;
        font-size: 1.25rem;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 4px 24px 0 rgba(7, 56, 47, 0.15);
        border: none;
        cursor: pointer;
        transition: background 0.3s, color 0.3s, border 0.3s;
    }

    .clare-chat-btn:hover {
        background: #0a4a3a;
        transform: translateY(-2px);
        box-shadow: 0 6px 28px 0 rgba(7, 56, 47, 0.25);
    }

    .clare-chat-icon {
        width: 1.75rem;
        height: 1.75rem;
        display: inline-block;
        transition: filter 0.3s;
        user-select: none;
        pointer-events: none;
    }

    .clare-chat-text {
        font-family: 'Inter', sans-serif;
        font-weight: 500;
    }

    .clare-chat-drawer {
        position: fixed;
        top: 0;
        right: 0;
        height: 100vh;
        width: 100%;
        max-width: 400px;
        z-index: 10000;
        background: #f5f7fc;
        box-shadow: -4px 0 24px 0 rgba(7, 56, 47, 0.15);
        border-top-left-radius: 16px;
        border-bottom-left-radius: 16px;
        display: flex;
        flex-direction: column;
        transform: translateX(100%);
        transition: transform 0.3s cubic-bezier(.4, 0, .2, 1);
    }

    .clare-chat-drawer.open {
        transform: translateX(0);
    }

    .clare-chat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.25rem;
        background: #fff;
        border-top-left-radius: 16px;
    }

    .clare-chat-header-left {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .clare-chat-logo {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
    }

    .clare-chat-title {
        font-weight: 600;
        font-size: 1.125rem;
        color: #374151;
    }

    .clare-chat-close {
        background: none;
        border: none;
        padding: 0.25rem;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: background 0.2s;
    }

    .clare-chat-close:hover {
        background: #f3f4f6;
    }

    .clare-chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1rem 1.25rem 0.5rem 1.25rem;
        background: #f5f7fc;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .clare-chat-message-user {
        align-self: flex-end;
        background: #fff;
        color: #222;
        padding: 0.75rem 1.25rem;
        border-radius: 1.25rem;
        box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.03);
        max-width: 80%;
        font-size: 1rem;
        font-weight: 500;
    }

    .clare-chat-message-bot {
        align-self: flex-start;
        background: #fff;
        color: #222;
        padding: 1rem;
        border-radius: 1rem;
        border: 1px solid #b6e2b6;
        box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.03);
        max-width: 90%;
        display: flex;
        gap: 0.75rem;
        font-size: 1rem;
    }

    .clare-chat-bot-avatar {
        width: 1.75rem;
        height: 1.75rem;
        border-radius: 50%;
        margin-top: 0.25rem;
    }

    .clare-chat-message-bot-content {
        flex: 1;
    }

    .clare-chat-message-typing {
        color: #888;
        font-style: italic;
        opacity: 0.7;
    }

    .clare-chat-input-area {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 1.25rem;
        background: #f5f7fc;
        border-bottom-left-radius: 16px;
    }

    .clare-chat-input {
        flex: 1;
        padding: 0.75rem 1rem;
        border-radius: 1.5rem;
        border: none;
        background: #e9edfa;
        font-size: 1rem;
        color: #374151;
        font-weight: 500;
        outline: none;
        resize: none;
        min-height: 2.5rem;
        max-height: 8rem;
    }

    .clare-chat-send {
        background: #fff;
        border: none;
        border-radius: 50%;
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s;
        min-width: 2.5rem;
        min-height: 2.5rem;
    }

    .clare-chat-send:hover {
        background: #f3f4f6;
    }

    .clare-chat-send-icon {
        width: 1.5rem;
        height: 1.5rem;
    }

    .clare-chat-message-user,
    .clare-chat-message-bot {
        word-break: break-word;
        overflow-wrap: anywhere;
        white-space: pre-line;
        max-width: 90%;
        box-sizing: border-box;
    }

    @media (max-width: 768px) {
        .clare-chat-drawer {
            width: 100%;
            max-width: 100%;
        }

        .clare-chat-btn {
            bottom: 1rem;
            right: 1rem;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }

        .chat-welcome-card {
            padding: 2rem 1.5rem;
        }

        .chat-header h1 {
            font-size: 1.75rem;
        }

        .chat-features {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="chat-page-container">
    <!-- Chat Header -->
    <div class="chat-header">
        <div class="container">
            <h1>Chat with Clare</h1>
            <p>Your AI-powered coffee expert is here to help</p>
        </div>
    </div>

    <!-- Chat Main Content -->
    <div class="chat-main">
        <div class="chat-welcome-card">
            <h2>👋 Hello! I'm Clare</h2>
            <p>I'm here to help you with anything related to coffee, our products, orders, or any questions you might have. I can assist with:</p>

            <div class="chat-features">
                <div class="feature-item">
                    <h3>☕ Product Help</h3>
                    <p>Learn about our coffee varieties, brewing methods, and product details</p>
                </div>
                <div class="feature-item">
                    <h3>📦 Order Support</h3>
                    <p>Track orders, resolve shipping issues, and handle returns</p>
                </div>
                <div class="feature-item">
                    <h3>💳 Payment Issues</h3>
                    <p>Help with payment methods, billing questions, and refunds</p>
                </div>
                <div class="feature-item">
                    <h3>🔐 Account Help</h3>
                    <p>Password resets, profile updates, and security settings</p>
                </div>
            </div>

            <button class="start-chat-btn" onclick="openClareChat()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                Start Chatting with Clare
            </button>
        </div>
    </div>
</div>

<!-- Floating Chat Button -->
<button id="clare-chat-btn" class="clare-chat-btn" aria-label="Talk to Clare" type="button">
    <img src="{{ asset('new_landing_assets/clare-icon.svg') }}" alt="Clare Icon" class="clare-chat-icon" draggable="false" />
    <span class="clare-chat-text">Talk to Clare</span>
</button>

<!-- Clare Chat Drawer -->
<div id="clare-chat-drawer" class="clare-chat-drawer">
    <div class="clare-chat-header">
        <div class="clare-chat-header-left">
            <img src="{{ asset('new_landing_assets/winwin-circle.svg') }}" alt="Clare Logo" class="clare-chat-logo" />
            <span class="clare-chat-title">Clare</span>
        </div>
        <button class="clare-chat-close" id="clare-chat-close" aria-label="Close">
            <svg width="20" height="20" fill="none" stroke="#222" stroke-width="2" viewBox="0 0 24 24">
                <path d="M6 6l12 12M6 18L18 6" />
            </svg>
        </button>
    </div>
    <div class="clare-chat-messages" id="clare-chat-messages"></div>
    <div class="clare-chat-input-area">
        <textarea id="clare-chat-input" class="clare-chat-input" placeholder="What can I help you with?" rows="1"></textarea>
        <button id="clare-chat-send" class="clare-chat-send" aria-label="Send">
            <img src="{{ asset('new_landing_assets/send-icon.svg') }}" alt="Send" class="clare-chat-send-icon" />
        </button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Chat functionality
    document.addEventListener('DOMContentLoaded', function() {
        setupChat();
    });

    function setupChat() {
        const chatDrawer = document.getElementById('clare-chat-drawer');
        const chatBtn = document.getElementById('clare-chat-btn');
        const chatClose = document.getElementById('clare-chat-close');
        const chatInput = document.getElementById('clare-chat-input');
        const chatSend = document.getElementById('clare-chat-send');
        const chatMessages = document.getElementById('clare-chat-messages');

        if (chatBtn) {
            chatBtn.addEventListener('click', () => {
                chatDrawer.classList.add('open');
            });
        }

        if (chatClose) {
            chatClose.addEventListener('click', () => {
                chatDrawer.classList.remove('open');
            });
        }

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && chatDrawer.classList.contains('open')) {
                chatDrawer.classList.remove('open');
            }
        });

        // Close on click outside
        document.addEventListener('click', (e) => {
            if (chatDrawer.classList.contains('open') &&
                !chatDrawer.contains(e.target) &&
                !e.target.closest('.clare-chat-btn')) {
                chatDrawer.classList.remove('open');
            }
        });

        // Auto-resize textarea
        if (chatInput) {
            chatInput.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 8 * 16) + 'px';
            });
        }

        // Send message functionality
        if (chatSend && chatInput) {
            chatSend.addEventListener('click', handleSend);
            chatInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    handleSend();
                }
            });
        }
    }

    // User ID management
    function generateUserId() {
        return 'user_' + Math.random().toString(36).substr(2, 9) + '_' + Date.now();
    }

    function getUserId() {
        let userId = localStorage.getItem('clare_chat_user_id');
        if (!userId) {
            userId = generateUserId();
            localStorage.setItem('clare_chat_user_id', userId);
        }
        return userId;
    }

    // Chat message functions
    function addUserMessage(text) {
        const chatMessages = document.getElementById('clare-chat-messages');
        const div = document.createElement('div');
        div.className = 'clare-chat-message-user';
        div.textContent = text;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function addBotMessage(html) {
        const chatMessages = document.getElementById('clare-chat-messages');
        const div = document.createElement('div');
        div.className = 'clare-chat-message-bot';
        div.innerHTML = `
            <img src="{{ asset('new_landing_assets/winwin-circle.svg') }}" alt="Clare" class="clare-chat-bot-avatar" />
            <div class="clare-chat-message-bot-content">${html}</div>
        `;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function addTypingIndicator() {
        const chatMessages = document.getElementById('clare-chat-messages');
        const div = document.createElement('div');
        div.className = 'clare-chat-message-bot clare-chat-message-typing';
        div.innerHTML = `
            <img src="{{ asset('new_landing_assets/winwin-circle.svg') }}" alt="Clare" class="clare-chat-bot-avatar" style="opacity:0.6;" />
            <div class="clare-chat-message-bot-content">Clare is typing...</div>
        `;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        return div;
    }

    async function sendMessageToAPI(message) {
        const userId = getUserId();
        const payload = {
            userId: userId,
            message: message
        };

        try {
            const response = await fetch('https://coffeeplug-api-b982ba0e7659.herokuapp.com/api/voiceflow/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success && data.data && data.data.formattedResponse) {
                return data.data.formattedResponse;
            } else {
                throw new Error('Invalid response format');
            }
        } catch (error) {
            console.error('Error sending message to API:', error);
            return '<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;"><p style="margin: 0 0 16px 0; padding: 0;">Sorry, I\'m having trouble connecting right now. Please try again in a moment.</p></div>';
        }
    }

    async function handleSend() {
        const chatInput = document.getElementById('clare-chat-input');
        const value = chatInput.value.trim();
        if (!value) return;

        // Add user message
        addUserMessage(value);
        chatInput.value = '';
        chatInput.style.height = 'auto';
        chatInput.focus();

        // Show typing indicator
        const typingDiv = addTypingIndicator();

        try {
            // Send message to API
            const response = await sendMessageToAPI(value);

            // Remove typing indicator
            typingDiv.remove();

            // Add bot response
            addBotMessage(response);
        } catch (error) {
            // Remove typing indicator
            typingDiv.remove();

            // Add error message
            addBotMessage('<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;"><p style="margin: 0 0 16px 0; padding: 0;">Sorry, something went wrong. Please try again.</p></div>');
        }
    }

    // Global functions for onclick attributes
    window.openClareChat = function() {
        const chatDrawer = document.getElementById('clare-chat-drawer');
        if (chatDrawer) {
            chatDrawer.classList.add('open');
        }
    };
</script>
@endsection
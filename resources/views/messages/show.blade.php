<x-app-layout>
    <div class="min-h-screen flex flex-col">
        <!-- Chat Header -->
        <div class="bg-[#1e1b2e] border-b border-purple-500/20 sticky top-[60px] z-40">
            <div class="max-w-2xl mx-auto px-4 py-3">
                <div class="flex items-center gap-4">
                    <a href="{{ route('messages.index') }}" class="p-2 -ml-2 rounded-lg hover:bg-purple-500/10 transition text-gray-400 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </a>
                    <a href="{{ route('profile.view', $otherUser->id) }}" class="flex items-center gap-3 flex-1 min-w-0 group">
                        @if($otherUser->profile_photo)
                            <img src="{{ $otherUser->profile_photo_url }}" 
                                 alt="{{ $otherUser->name }}" 
                                 class="w-10 h-10 rounded-full object-cover border-2 border-purple-500/20 group-hover:border-purple-500/50 transition">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <h2 class="font-semibold text-white truncate group-hover:text-purple-400 transition">{{ $otherUser->name }}</h2>
                            <p class="text-xs text-gray-500">Tap to view profile</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Messages Container -->
        <div class="flex-1 overflow-y-auto pb-32" id="messages-container" style="max-height: calc(100vh - 180px);">
            <div class="max-w-2xl mx-auto px-4 py-6">
                <!-- Start of conversation -->
                <div class="text-center mb-8">
                    <div class="inline-block">
                        @if($otherUser->profile_photo)
                            <img src="{{ $otherUser->profile_photo_url }}" 
                                 alt="{{ $otherUser->name }}" 
                                 class="w-20 h-20 rounded-full object-cover border-4 border-purple-500/20 mx-auto mb-3">
                        @else
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-3">
                                {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                            </div>
                        @endif
                        <h3 class="font-semibold text-white text-lg">{{ $otherUser->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1">This is the beginning of your conversation</p>
                    </div>
                </div>

                <!-- Messages -->
                <div class="space-y-4" id="messages-list">
                    @foreach($messages as $message)
                        @php
                            $isMine = $message->sender_id === auth()->id();
                            $isFirstUnread = isset($firstUnreadMessageId) && $message->id == $firstUnreadMessageId;
                        @endphp
                        
                        @if($isFirstUnread)
                            <!-- Unread Messages Divider -->
                            <div class="flex items-center gap-4 py-2" id="unread-divider">
                                <div class="flex-1 h-px bg-purple-500/30"></div>
                                <span class="text-xs text-purple-400 font-medium px-2">New Messages</span>
                                <div class="flex-1 h-px bg-purple-500/30"></div>
                            </div>
                        @endif
                        
                        <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }} message-item" data-message-id="{{ $message->id }}" @if($isFirstUnread) id="first-unread-message" @endif>
                            <div class="max-w-[75%] {{ $isMine ? 'order-2' : 'order-1' }}">
                                @if(!$isMine)
                                    <div class="flex items-end gap-2">
                                        @if($message->sender->profile_photo)
                                            <img src="{{ $message->sender->profile_photo_url }}" 
                                                 alt="{{ $message->sender->name }}" 
                                                 class="w-6 h-6 rounded-full object-cover shrink-0">
                                        @else
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                                {{ strtoupper(substr($message->sender->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-2xl rounded-bl-md overflow-hidden">
                                            @if($message->sharedPost)
                                                <!-- Shared Post Preview -->
                                                <a href="{{ route('posts.show', $message->sharedPost) }}" class="block hover:opacity-90 transition">
                                                    <div class="w-56">
                                                        <img src="{{ $message->sharedPost->image_url }}" 
                                                             alt="Shared post" 
                                                             class="w-full aspect-square object-cover">
                                                        <div class="p-3 border-t border-purple-500/10">
                                                            <div class="flex items-center gap-2 mb-1">
                                                                @if($message->sharedPost->user->profile_photo)
                                                                    <img src="{{ $message->sharedPost->user->profile_photo_url }}" 
                                                                         class="w-5 h-5 rounded-full object-cover">
                                                                @else
                                                                    <div class="w-5 h-5 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 flex items-center justify-center text-white text-[10px] font-bold">
                                                                        {{ strtoupper(substr($message->sharedPost->user->name, 0, 1)) }}
                                                                    </div>
                                                                @endif
                                                                <span class="text-xs text-gray-400 font-medium">{{ $message->sharedPost->user->name }}</span>
                                                            </div>
                                                            @if($message->body && $message->body !== 'Shared a post')
                                                                <p class="text-gray-300 text-sm">{{ $message->body }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </a>
                                            @else
                                                <div class="px-4 py-2">
                                                    <p class="text-gray-200 break-words">{{ $message->body }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-gradient-to-r from-purple-600 to-fuchsia-600 rounded-2xl rounded-br-md overflow-hidden">
                                        @if($message->sharedPost)
                                            <!-- Shared Post Preview (sent by me) -->
                                            <a href="{{ route('posts.show', $message->sharedPost) }}" class="block hover:opacity-90 transition">
                                                <div class="w-56">
                                                    <img src="{{ $message->sharedPost->image_url }}" 
                                                         alt="Shared post" 
                                                         class="w-full aspect-square object-cover">
                                                    <div class="p-3 border-t border-white/10">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            @if($message->sharedPost->user->profile_photo)
                                                                <img src="{{ $message->sharedPost->user->profile_photo_url }}" 
                                                                     class="w-5 h-5 rounded-full object-cover">
                                                            @else
                                                                <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-white text-[10px] font-bold">
                                                                    {{ strtoupper(substr($message->sharedPost->user->name, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                            <span class="text-xs text-white/80 font-medium">{{ $message->sharedPost->user->name }}</span>
                                                        </div>
                                                        @if($message->body && $message->body !== 'Shared a post')
                                                            <p class="text-white text-sm">{{ $message->body }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        @else
                                            <div class="px-4 py-2">
                                                <p class="text-white break-words">{{ $message->body }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <p class="text-xs text-gray-600 mt-1 {{ $isMine ? 'text-right' : 'ml-8' }}">
                                    {{ $message->created_at->format('g:i A') }}
                                    @if($isMine && $message->read_at)
                                        <span class="text-purple-400 ml-1">✓✓</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Message Input -->
        <div class="fixed bottom-0 left-0 right-0 bg-[#13111c] border-t border-purple-500/20 sm:pb-0 pb-16">
            <div class="max-w-2xl mx-auto px-4 py-3">
                <form id="message-form" action="{{ route('messages.store', $conversation) }}" method="POST" class="flex items-end gap-3">
                    @csrf
                    <div class="flex-1 relative">
                        <textarea 
                            name="body" 
                            id="message-input"
                            rows="1"
                            placeholder="Message..."
                            class="w-full bg-[#1e1b2e] border border-purple-500/20 rounded-2xl px-4 py-3 text-gray-200 placeholder-gray-500 focus:outline-none focus:border-purple-500/50 focus:ring-1 focus:ring-purple-500/50 resize-none max-h-32"
                            required
                        ></textarea>
                    </div>
                    <button type="submit" class="p-3 bg-gradient-to-r from-purple-600 to-fuchsia-600 hover:from-purple-500 hover:to-fuchsia-500 rounded-full text-white transition-all shadow-lg shadow-purple-500/25 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Scroll function
        function scrollToPosition() {
            const messagesContainer = document.getElementById('messages-container');
            const unreadDivider = document.getElementById('unread-divider');
            
            if (unreadDivider) {
                // Scroll to the "New Messages" divider
                unreadDivider.scrollIntoView({ behavior: 'auto', block: 'start' });
                messagesContainer.scrollTop = Math.max(0, messagesContainer.scrollTop - 100);
            } else {
                // No unread messages, scroll to bottom
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        }
        
        // Try scrolling multiple times to handle image loading
        document.addEventListener('DOMContentLoaded', function() {
            scrollToPosition();
            setTimeout(scrollToPosition, 100);
            setTimeout(scrollToPosition, 300);
        });
        
        // Also scroll when all images are loaded
        window.addEventListener('load', scrollToPosition);

        document.addEventListener('DOMContentLoaded', function() {
            const messagesContainer = document.getElementById('messages-container');
            const messagesList = document.getElementById('messages-list');
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');
            const conversationId = {{ $conversation->id }};
            
            // Auto-resize textarea
            messageInput.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 128) + 'px';
            });

            // Handle form submission with AJAX
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const body = messageInput.value.trim();
                if (!body) return;
                
                const formData = new FormData(messageForm);
                
                fetch(messageForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Add message to UI
                        appendMessage(data.message, true);
                        messageInput.value = '';
                        messageInput.style.height = 'auto';
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });

            // Poll for new messages
            let lastMessageId = getLastMessageId();
            
            function getLastMessageId() {
                const messages = document.querySelectorAll('.message-item');
                if (messages.length === 0) return 0;
                return parseInt(messages[messages.length - 1].dataset.messageId) || 0;
            }

            function pollForMessages() {
                fetch(`{{ route('messages.new', $conversation) }}?last_message_id=${lastMessageId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.messages && data.messages.length > 0) {
                        data.messages.forEach(message => {
                            // Only append if not from current user (they see their own immediately)
                            if (message.sender_id !== {{ auth()->id() }}) {
                                appendMessage(message, false);
                            }
                            lastMessageId = Math.max(lastMessageId, message.id);
                        });
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    }
                })
                .catch(error => console.error('Polling error:', error));
            }

            function appendMessage(message, isMine) {
                const messageHtml = isMine ? `
                    <div class="flex justify-end message-item" data-message-id="${message.id}">
                        <div class="max-w-[75%]">
                            <div class="bg-gradient-to-r from-purple-600 to-fuchsia-600 rounded-2xl rounded-br-md px-4 py-2">
                                <p class="text-white break-words">${escapeHtml(message.body)}</p>
                            </div>
                            <p class="text-xs text-gray-600 mt-1 text-right">Just now</p>
                        </div>
                    </div>
                ` : `
                    <div class="flex justify-start message-item" data-message-id="${message.id}">
                        <div class="max-w-[75%]">
                            <div class="flex items-end gap-2">
                                ${message.sender.profile_photo ? 
                                    `<img src="/storage/${message.sender.profile_photo}" class="w-6 h-6 rounded-full object-cover shrink-0">` :
                                    `<div class="w-6 h-6 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 flex items-center justify-center text-white text-xs font-bold shrink-0">${message.sender.name.charAt(0).toUpperCase()}</div>`
                                }
                                <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-2xl rounded-bl-md px-4 py-2">
                                    <p class="text-gray-200 break-words">${escapeHtml(message.body)}</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 mt-1 ml-8">Just now</p>
                        </div>
                    </div>
                `;
                
                messagesList.insertAdjacentHTML('beforeend', messageHtml);
            }

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            // Poll every 3 seconds
            setInterval(pollForMessages, 3000);

            // Submit on Enter (but allow Shift+Enter for new line)
            messageInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    messageForm.dispatchEvent(new Event('submit'));
                }
            });
        });
    </script>
</x-app-layout>

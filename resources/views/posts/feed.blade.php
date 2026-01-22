<x-app-layout>
    <div class="feed-container max-w-lg mx-auto px-4 py-6">
        @forelse($posts as $post)
            <article class="post-card bg-[#1e1b2e] border border-[#2d2d3a] rounded-xl mb-6 overflow-hidden shadow-lg hover:border-purple-500/30 hover:shadow-purple-500/10 transition-all duration-300">
                <!-- Post Header -->
                <header class="flex items-center gap-3 p-4">
                    <a href="{{ route('profile.view', $post->user->id) }}" class="flex-shrink-0">
                        @if($post->user->profile_photo)
                            <img src="{{ $post->user->profile_photo_url }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-purple-500 ring-offset-2 ring-offset-[#1e1b2e]">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 via-fuchsia-500 to-pink-500 flex items-center justify-center text-white font-bold ring-2 ring-purple-500 ring-offset-2 ring-offset-[#1e1b2e]">
                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                            </div>
                        @endif
                    </a>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('profile.view', $post->user->id) }}" class="font-semibold text-sm text-gray-100 hover:text-purple-400 transition">
                            {{ $post->user->name }}
                        </a>
                    </div>
                    <button class="text-gray-500 hover:text-purple-400 p-2 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    </button>
                </header>

                <!-- Post Image -->
                <a href="{{ route('posts.show', $post->id) }}" class="block aspect-square bg-[#221f2e]">
                    <img src="{{ $post->image_url }}" alt="Post Image" class="w-full h-full object-cover">
                </a>

                <!-- Post Actions -->
                <div class="p-4">
                    <div class="flex items-center gap-4 mb-3">
                        <!-- Like Button -->
                        <form action="{{ route('posts.like', $post) }}" method="POST" class="like-form">
                            @csrf
                            <button type="submit" class="like-btn transition hover:scale-110 {{ $post->isLikedBy(auth()->user()) ? 'text-pink-500' : 'text-gray-300 hover:text-pink-500' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7" fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                            </button>
                        </form>
                        <!-- Comment Button -->
                        <a href="{{ route('posts.show', $post->id) }}" class="text-gray-300 hover:text-purple-400 transition hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                            </svg>
                        </a>
                        <!-- Share Button -->
                        <button onclick="sharePost({{ $post->id }}, '{{ $post->user->name }}')" class="text-gray-300 hover:text-purple-400 transition hover:scale-110 share-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                            </svg>
                        </button>
                        <!-- Save Button -->
                        <form action="{{ route('posts.save', $post) }}" method="POST" class="save-form ml-auto">
                            @csrf
                            <button type="submit" class="save-btn transition hover:scale-110 {{ $post->isSavedBy(auth()->user()) ? 'text-purple-500' : 'text-gray-300 hover:text-purple-500' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7" fill="{{ $post->isSavedBy(auth()->user()) ? 'currentColor' : 'none' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Likes Count -->
                    <p class="font-semibold text-sm text-white mb-2 likes-count">
                        @if($post->likes->count() > 0)
                            {{ $post->likes->count() }} {{ Str::plural('like', $post->likes->count()) }}
                        @else
                            0 likes
                        @endif
                    </p>

                    <!-- Comments Preview -->
                    @if($post->comments->count() > 0)
                        <a href="{{ route('posts.show', $post->id) }}" class="text-sm text-gray-400 hover:text-purple-400 transition">
                            View all {{ $post->comments->count() }} {{ Str::plural('comment', $post->comments->count()) }}
                        </a>
                    @endif

                    <!-- Post Time -->
                    <time class="block text-xs text-gray-500 uppercase tracking-wide mt-2">
                        {{ $post->created_at->diffForHumans() }}
                    </time>
                </div>
            </article>
        @empty
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-br from-purple-500/20 to-fuchsia-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-10 h-10 text-purple-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-100 mb-2">No posts yet</h3>
                <p class="text-gray-500 mb-6">Start following people to see their photos here.</p>
                <a href="{{ route('search.form') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-fuchsia-500 hover:from-purple-600 hover:to-fuchsia-600 text-white font-semibold rounded-xl transition shadow-lg shadow-purple-500/25">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    Find People
                </a>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

    <!-- Share Modal - Instagram Style -->
    <div id="share-modal" class="fixed inset-0 bg-black/70 z-50 hidden items-center justify-center">
        <div class="bg-[#1e1b2e] rounded-2xl max-w-md w-full mx-4 overflow-hidden border border-purple-500/20 max-h-[85vh] flex flex-col">
            <!-- Header -->
            <div class="p-4 border-b border-purple-500/20 flex items-center justify-between flex-shrink-0">
                <h3 class="text-lg font-semibold text-white">Share</h3>
                <button onclick="closeShareModal()" class="text-gray-400 hover:text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Search Bar -->
            <div class="p-4 border-b border-purple-500/10 flex-shrink-0">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input type="text" id="share-user-search" placeholder="Search users..." 
                        class="w-full bg-[#252238] border border-purple-500/20 rounded-xl pl-10 pr-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition">
                </div>
            </div>

            <!-- Suggested Users / Search Results -->
            <div class="flex-1 overflow-y-auto">
                <!-- Suggested Users Section -->
                <div id="suggested-users-section" class="p-4">
                    <p class="text-gray-400 text-sm font-medium mb-3">Suggested</p>
                    <div id="suggested-users-list" class="space-y-1">
                        <!-- Loading state -->
                        <div class="flex items-center justify-center py-6">
                            <div class="w-6 h-6 border-2 border-purple-500 border-t-transparent rounded-full animate-spin"></div>
                        </div>
                    </div>
                </div>

                <!-- Search Results Section (hidden by default) -->
                <div id="search-results-section" class="p-4 hidden">
                    <p class="text-gray-400 text-sm font-medium mb-3">Search Results</p>
                    <div id="share-search-results" class="space-y-1">
                    </div>
                </div>
            </div>

            <!-- Selected User & Message Section -->
            <div id="share-message-section" class="hidden border-t border-purple-500/10 p-4 flex-shrink-0">
                <div class="flex items-center gap-3 mb-3 p-3 bg-[#252238] rounded-xl">
                    <div id="share-selected-avatar"></div>
                    <div class="flex-1 min-w-0">
                        <p id="share-selected-name" class="text-white font-medium text-sm truncate"></p>
                        <p class="text-gray-500 text-xs">Selected</p>
                    </div>
                    <button onclick="deselectShareUser()" class="text-gray-400 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <textarea id="share-custom-message" rows="2" placeholder="Write a message..." 
                    class="w-full bg-[#252238] border border-purple-500/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition resize-none"></textarea>
                <button onclick="sendShareToUser()" id="share-send-btn" class="w-full mt-3 py-3 bg-gradient-to-r from-purple-500 to-fuchsia-500 hover:from-purple-600 hover:to-fuchsia-600 text-white font-semibold rounded-xl transition shadow-lg shadow-purple-500/25">
                    Send
                </button>
            </div>

            <!-- Bottom Slide - More Options -->
            <div class="border-t border-purple-500/20 flex-shrink-0">
                <button onclick="toggleMoreOptions()" id="more-options-toggle" class="w-full p-3 flex items-center justify-center gap-2 text-gray-400 hover:text-white transition">
                    <span class="text-sm font-medium">More options</span>
                    <svg id="more-options-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                    </svg>
                </button>
                
                <!-- Expandable Options -->
                <div id="more-options-panel" class="hidden px-4 pb-4 space-y-2">
                    <!-- Copy Link -->
                    <button onclick="copyPostLink()" class="w-full flex items-center gap-3 p-3 bg-[#252238] hover:bg-[#2a2640] rounded-xl transition">
                        <div class="w-10 h-10 rounded-full bg-purple-500/20 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-purple-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                            </svg>
                        </div>
                        <span class="text-white font-medium">Copy Link</span>
                    </button>

                    <!-- Share to WhatsApp -->
                    <a id="whatsapp-share" href="#" target="_blank" class="w-full flex items-center gap-3 p-3 bg-[#252238] hover:bg-[#2a2640] rounded-xl transition">
                        <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </div>
                        <span class="text-white font-medium">WhatsApp</span>
                    </a>

                    <!-- Share to Twitter/X -->
                    <a id="twitter-share" href="#" target="_blank" class="w-full flex items-center gap-3 p-3 bg-[#252238] hover:bg-[#2a2640] rounded-xl transition">
                        <div class="w-10 h-10 rounded-full bg-gray-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </div>
                        <span class="text-white font-medium">X (Twitter)</span>
                    </a>

                    <!-- Share to Facebook -->
                    <a id="facebook-share" href="#" target="_blank" class="w-full flex items-center gap-3 p-3 bg-[#252238] hover:bg-[#2a2640] rounded-xl transition">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </div>
                        <span class="text-white font-medium">Facebook</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-24 left-1/2 transform -translate-x-1/2 bg-[#1e1b2e] border border-purple-500/30 text-white px-6 py-3 rounded-xl shadow-lg shadow-purple-500/20 hidden z-50">
        <span id="toast-message">Link copied!</span>
    </div>

    <script>
        let currentPostId = null;
        let currentShareUrl = '';
        let currentShareTitle = '';
        let selectedShareUserId = null;
        let shareSearchTimeout = null;
        let moreOptionsOpen = false;

        function sharePost(postId, username) {
            currentPostId = postId;
            currentShareUrl = `{{ url('/posts') }}/${postId}`;
            currentShareTitle = `Check out this post by ${username}`;
            
            // Update share links
            document.getElementById('whatsapp-share').href = `https://wa.me/?text=${encodeURIComponent(currentShareTitle + ' ' + currentShareUrl)}`;
            document.getElementById('twitter-share').href = `https://twitter.com/intent/tweet?text=${encodeURIComponent(currentShareTitle)}&url=${encodeURIComponent(currentShareUrl)}`;
            document.getElementById('facebook-share').href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentShareUrl)}`;
            
            // Reset state
            resetShareModal();
            
            // Load suggested users
            loadSuggestedUsers();
            
            // Show modal
            document.getElementById('share-modal').classList.remove('hidden');
            document.getElementById('share-modal').classList.add('flex');
        }

        function closeShareModal() {
            document.getElementById('share-modal').classList.add('hidden');
            document.getElementById('share-modal').classList.remove('flex');
            resetShareModal();
        }

        function resetShareModal() {
            selectedShareUserId = null;
            document.getElementById('share-user-search').value = '';
            document.getElementById('share-message-section').classList.add('hidden');
            document.getElementById('suggested-users-section').classList.remove('hidden');
            document.getElementById('search-results-section').classList.add('hidden');
            document.getElementById('share-custom-message').value = '';
            
            // Collapse more options
            moreOptionsOpen = false;
            document.getElementById('more-options-panel').classList.add('hidden');
            document.getElementById('more-options-arrow').classList.remove('rotate-180');
        }

        function loadSuggestedUsers() {
            const container = document.getElementById('suggested-users-list');
            container.innerHTML = `
                <div class="flex items-center justify-center py-6">
                    <div class="w-6 h-6 border-2 border-purple-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            `;

            fetch('{{ route('messages.suggested-users') }}')
                .then(response => response.json())
                .then(data => {
                    if (data.users.length === 0) {
                        container.innerHTML = `
                            <div class="text-center text-gray-500 py-4">
                                <p class="text-sm">No suggested users yet. Follow some people!</p>
                            </div>
                        `;
                        return;
                    }

                    container.innerHTML = data.users.map(user => renderUserButton(user)).join('');
                })
                .catch(error => {
                    console.error('Load suggested users error:', error);
                    container.innerHTML = `
                        <div class="text-center text-gray-500 py-4">
                            <p class="text-sm">Could not load suggestions</p>
                        </div>
                    `;
                });
        }

        function renderUserButton(user) {
            // Escape all user data to prevent XSS
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text || '';
                return div.innerHTML;
            }
            
            const safeName = escapeHtml(user.name);
            const safeEmail = escapeHtml(user.email);
            const safePhoto = escapeHtml(user.profile_photo || '');
            const escapedName = safeName.replace(/'/g, "\\'");
            
            return `
                <button onclick="selectShareUser(${user.id}, '${escapedName}', '${safePhoto}')" 
                    class="w-full flex items-center gap-3 p-3 hover:bg-[#252238] rounded-xl transition text-left">
                    ${user.profile_photo 
                        ? `<img src="/storage/${safePhoto}" alt="${safeName}" class="w-11 h-11 rounded-full object-cover ring-2 ring-purple-500/30">`
                        : `<div class="w-11 h-11 rounded-full bg-gradient-to-br from-purple-500 via-fuchsia-500 to-pink-500 flex items-center justify-center text-white font-bold ring-2 ring-purple-500/30">
                            ${safeName.charAt(0).toUpperCase()}
                        </div>`
                    }
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-medium truncate">${safeName}</p>
                        <p class="text-gray-500 text-sm truncate">${safeEmail}</p>
                    </div>
                    <div class="w-6 h-6 rounded-full border-2 border-purple-500/50 flex items-center justify-center">
                    </div>
                </button>
            `;
        }

        function selectShareUser(userId, userName, userPhoto) {
            selectedShareUserId = userId;
            
            // Update the selected user display
            document.getElementById('share-selected-name').textContent = userName;
            
            const avatarContainer = document.getElementById('share-selected-avatar');
            if (userPhoto) {
                avatarContainer.innerHTML = `<img src="/storage/${userPhoto}" alt="${userName}" class="w-10 h-10 rounded-full object-cover ring-2 ring-purple-500/30">`;
            } else {
                avatarContainer.innerHTML = `
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 via-fuchsia-500 to-pink-500 flex items-center justify-center text-white font-bold">
                        ${userName.charAt(0).toUpperCase()}
                    </div>
                `;
            }
            
            // Show message section, hide user lists
            document.getElementById('share-message-section').classList.remove('hidden');
            document.getElementById('suggested-users-section').classList.add('hidden');
            document.getElementById('search-results-section').classList.add('hidden');
            document.getElementById('share-custom-message').focus();
        }

        function deselectShareUser() {
            selectedShareUserId = null;
            document.getElementById('share-message-section').classList.add('hidden');
            document.getElementById('share-custom-message').value = '';
            
            // Show appropriate section based on search input
            const searchValue = document.getElementById('share-user-search').value.trim();
            if (searchValue.length >= 1) {
                document.getElementById('search-results-section').classList.remove('hidden');
            } else {
                document.getElementById('suggested-users-section').classList.remove('hidden');
            }
            
            document.getElementById('share-user-search').focus();
        }

        function sendShareToUser() {
            if (!selectedShareUserId) return;
            
            const sendBtn = document.getElementById('share-send-btn');
            const originalText = sendBtn.textContent;
            sendBtn.textContent = 'Sending...';
            sendBtn.disabled = true;
            
            const message = document.getElementById('share-custom-message').value;

            fetch('{{ route('messages.share-post') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    user_id: selectedShareUserId,
                    post_id: currentPostId,
                    message: message
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeShareModal();
                    showToast('Post sent successfully!');
                } else {
                    showToast(data.message || 'Failed to send post');
                }
            })
            .catch(error => {
                console.error('Send error:', error);
                showToast('Failed to send post');
            })
            .finally(() => {
                sendBtn.textContent = originalText;
                sendBtn.disabled = false;
            });
        }

        function toggleMoreOptions() {
            moreOptionsOpen = !moreOptionsOpen;
            const panel = document.getElementById('more-options-panel');
            const arrow = document.getElementById('more-options-arrow');
            
            if (moreOptionsOpen) {
                panel.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            } else {
                panel.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        }

        function copyPostLink() {
            navigator.clipboard.writeText(currentShareUrl).then(() => {
                showToast('Link copied to clipboard!');
                closeShareModal();
            });
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            toastMessage.textContent = message;
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        // Search input handler
        document.getElementById('share-user-search').addEventListener('input', function(e) {
            const query = e.target.value.trim();
            
            clearTimeout(shareSearchTimeout);
            
            if (query.length < 1) {
                document.getElementById('suggested-users-section').classList.remove('hidden');
                document.getElementById('search-results-section').classList.add('hidden');
                return;
            }

            document.getElementById('suggested-users-section').classList.add('hidden');
            document.getElementById('search-results-section').classList.remove('hidden');

            shareSearchTimeout = setTimeout(() => {
                searchShareUsers(query);
            }, 300);
        });

        function searchShareUsers(query) {
            const resultsContainer = document.getElementById('share-search-results');
            resultsContainer.innerHTML = `
                <div class="flex items-center justify-center py-6">
                    <div class="w-6 h-6 border-2 border-purple-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            `;

            fetch(`{{ route('messages.search-users') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.users.length === 0) {
                        resultsContainer.innerHTML = `
                            <div class="text-center text-gray-500 py-4">
                                <p class="text-sm">No users found</p>
                            </div>
                        `;
                        return;
                    }

                    resultsContainer.innerHTML = data.users.map(user => renderUserButton(user)).join('');
                })
                .catch(error => {
                    console.error('Search error:', error);
                    resultsContainer.innerHTML = `
                        <div class="text-center text-red-400 py-4">
                            <p class="text-sm">Error searching users</p>
                        </div>
                    `;
                });
        }

        // Close modal on outside click
        document.getElementById('share-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeShareModal();
            }
        });

        // AJAX for save forms
        document.querySelectorAll('.save-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const btn = this.querySelector('.save-btn');
                const svg = btn.querySelector('svg');
                
                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.saved) {
                        btn.classList.remove('text-gray-300');
                        btn.classList.add('text-purple-500');
                        svg.setAttribute('fill', 'currentColor');
                        showToast('Post saved!');
                    } else {
                        btn.classList.remove('text-purple-500');
                        btn.classList.add('text-gray-300');
                        svg.setAttribute('fill', 'none');
                        showToast('Post removed from saved');
                    }
                });
            });
        });
    </script>
</x-app-layout>

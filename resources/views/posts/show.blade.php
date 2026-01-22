<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-xl overflow-hidden shadow-lg shadow-purple-500/5">
            <div class="flex flex-col md:flex-row">
                <!-- Image Section -->
                <div class="md:flex-1 bg-black flex items-center justify-center">
                    <img src="{{ asset('storage/' . $post->image_path) }}" 
                         alt="Post Image" 
                         class="max-h-[80vh] w-full object-contain">
                </div>

                <!-- Sidebar -->
                <div class="md:w-96 flex flex-col border-l border-purple-500/20">
                    <!-- Post Header -->
                    <header class="flex items-center gap-3 p-4 border-b border-purple-500/20">
                        <a href="{{ route('profile.view', $post->user->id) }}" class="flex-shrink-0">
                            @if($post->user->profile_photo)
                                <img src="{{ asset('storage/' . $post->user->profile_photo) }}" 
                                     alt="{{ $post->user->name }}" 
                                     class="w-10 h-10 rounded-full object-cover ring-2 ring-purple-500/50">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 flex items-center justify-center text-white font-bold shadow-lg shadow-purple-500/30">
                                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                </div>
                            @endif
                        </a>
                        <div class="flex-1">
                            <a href="{{ route('profile.view', $post->user->id) }}" class="font-semibold text-sm text-white hover:text-purple-400 transition">
                                {{ $post->user->name }}
                            </a>
                        </div>
                    </header>

                    <!-- Comments Section -->
                    <div class="flex-1 p-4 overflow-y-auto max-h-[400px] space-y-4" id="comments-container">
                        <!-- Post Caption (if any) -->
                        <div class="flex items-start gap-3">
                            <a href="{{ route('profile.view', $post->user->id) }}" class="flex-shrink-0">
                                @if($post->user->profile_photo)
                                    <img src="{{ asset('storage/' . $post->user->profile_photo) }}" 
                                         alt="{{ $post->user->name }}" 
                                         class="w-8 h-8 rounded-full object-cover ring-2 ring-purple-500/30">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </a>
                            <div>
                                <p class="text-sm text-white">
                                    <a href="{{ route('profile.view', $post->user->id) }}" class="font-semibold hover:text-purple-400 transition">{{ $post->user->name }}</a>
                                </p>
                                <time class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</time>
                            </div>
                        </div>

                        <!-- Comments List -->
                        @foreach($post->comments()->with('user')->latest()->get() as $comment)
                            <div class="flex items-start gap-3 group" id="comment-{{ $comment->id }}">
                                <a href="{{ route('profile.view', $comment->user->id) }}" class="flex-shrink-0">
                                    @if($comment->user->profile_photo)
                                        <img src="{{ asset('storage/' . $comment->user->profile_photo) }}" 
                                             alt="{{ $comment->user->name }}" 
                                             class="w-8 h-8 rounded-full object-cover ring-2 ring-purple-500/30">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </a>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-white">
                                        <a href="{{ route('profile.view', $comment->user->id) }}" class="font-semibold hover:text-purple-400 transition">{{ $comment->user->name }}</a>
                                        <span class="font-normal text-gray-300">{{ $comment->body }}</span>
                                    </p>
                                    <div class="flex items-center gap-3 mt-1">
                                        <time class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</time>
                                        @if(auth()->id() === $comment->user_id || auth()->id() === $post->author_id)
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-gray-500 hover:text-red-400 transition opacity-0 group-hover:opacity-100">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if($post->comments->count() === 0)
                            <p class="text-sm text-gray-500 text-center py-4">No comments yet. Be the first to comment!</p>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="border-t border-purple-500/20 p-4">
                        <div class="flex items-center gap-4 mb-3">
                            <!-- Like Button -->
                            <form action="{{ route('posts.like', $post) }}" method="POST" class="like-form">
                                @csrf
                                <button type="submit" class="like-btn transition hover:scale-110 transform {{ $post->isLikedBy(auth()->user()) ? 'text-pink-500' : 'text-gray-300 hover:text-pink-500' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7" fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </button>
                            </form>
                            <button class="text-gray-300 hover:text-purple-400 transition hover:scale-110 transform" onclick="document.getElementById('comment-input').focus()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                                </svg>
                            </button>
                            <button class="text-gray-300 hover:text-purple-400 transition hover:scale-110 transform">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                </svg>
                            </button>
                            <button class="text-gray-300 hover:text-purple-400 transition hover:scale-110 transform ml-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Likes Count -->
                        <p class="font-semibold text-sm text-white mb-2 likes-count">
                            @if($post->likes->count() > 0)
                                {{ $post->likes->count() }} {{ Str::plural('like', $post->likes->count()) }}
                            @else
                                0 likes
                            @endif
                        </p>
                        
                        <time class="text-xs text-gray-500 uppercase">{{ $post->created_at->format('F j, Y') }}</time>
                    </div>

                    <!-- Add Comment Form -->
                    <div class="border-t border-purple-500/20 p-4">
                        <form action="{{ route('comments.store', $post) }}" method="POST" class="flex items-center gap-3">
                            @csrf
                            <input 
                                type="text" 
                                name="body" 
                                id="comment-input"
                                placeholder="Add a comment..." 
                                class="flex-1 bg-transparent text-sm text-white placeholder-gray-500 border-none focus:ring-0 focus:outline-none"
                                required
                                maxlength="1000"
                            >
                            <button type="submit" class="text-purple-400 hover:text-purple-300 font-semibold text-sm transition">
                                Post
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

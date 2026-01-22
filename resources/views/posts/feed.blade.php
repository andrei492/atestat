<x-app-layout>
    <div class="feed-container max-w-lg mx-auto px-4 py-6">
        @forelse($posts as $post)
            <article class="post-card bg-[#1e1b2e] border border-[#2d2d3a] rounded-xl mb-6 overflow-hidden shadow-lg hover:border-purple-500/30 hover:shadow-purple-500/10 transition-all duration-300">
                <!-- Post Header -->
                <header class="flex items-center gap-3 p-4">
                    <a href="{{ route('profile.view', $post->user->id) }}" class="flex-shrink-0">
                        @if($post->user->profile_photo)
                            <img src="{{ asset('storage/' . $post->user->profile_photo) }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-purple-500 ring-offset-2 ring-offset-[#1e1b2e]">
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
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="w-full h-full object-cover">
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
                        <button class="text-gray-300 hover:text-purple-400 transition hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                            </svg>
                        </button>
                        <button class="text-gray-300 hover:text-purple-400 transition hover:scale-110 ml-auto">
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
</x-app-layout>

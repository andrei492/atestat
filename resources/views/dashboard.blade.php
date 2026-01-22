<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Dashboard</h1>
                <p class="text-gray-400">Welcome back, {{ Auth::user()->name }}! Here's your account overview.</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
                <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-xl p-4 text-center hover:border-purple-500/40 transition">
                    <p class="text-2xl font-bold text-white mb-1">{{ $stats['posts'] }}</p>
                    <p class="text-xs text-gray-400">Posts</p>
                </div>
                <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-xl p-4 text-center hover:border-purple-500/40 transition">
                    <p class="text-2xl font-bold text-white mb-1">{{ $stats['followers'] }}</p>
                    <p class="text-xs text-gray-400">Followers</p>
                </div>
                <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-xl p-4 text-center hover:border-purple-500/40 transition">
                    <p class="text-2xl font-bold text-white mb-1">{{ $stats['following'] }}</p>
                    <p class="text-xs text-gray-400">Following</p>
                </div>
                <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-xl p-4 text-center hover:border-purple-500/40 transition">
                    <p class="text-2xl font-bold text-purple-400 mb-1">{{ $stats['totalLikes'] }}</p>
                    <p class="text-xs text-gray-400">Total Likes</p>
                </div>
                <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-xl p-4 text-center hover:border-purple-500/40 transition">
                    <p class="text-2xl font-bold text-fuchsia-400 mb-1">{{ $stats['totalComments'] }}</p>
                    <p class="text-xs text-gray-400">Total Comments</p>
                </div>
                <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-xl p-4 text-center hover:border-purple-500/40 transition">
                    <p class="text-2xl font-bold text-pink-400 mb-1">{{ $engagementRate }}</p>
                    <p class="text-xs text-gray-400">Avg. Engagement</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
                <a href="{{ route('posts.feed') }}" class="group flex items-center gap-3 p-4 bg-[#1e1b2e] border border-purple-500/20 rounded-xl hover:border-purple-500/40 hover:bg-[#252238] transition-all">
                    <div class="w-10 h-10 rounded-lg bg-purple-500/20 flex items-center justify-center group-hover:bg-purple-500/30 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-purple-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-white text-sm group-hover:text-purple-400 transition">Feed</p>
                        <p class="text-xs text-gray-500">View posts</p>
                    </div>
                </a>
                <a href="{{ route('posts.create') }}" class="group flex items-center gap-3 p-4 bg-[#1e1b2e] border border-purple-500/20 rounded-xl hover:border-fuchsia-500/40 hover:bg-[#252238] transition-all">
                    <div class="w-10 h-10 rounded-lg bg-fuchsia-500/20 flex items-center justify-center group-hover:bg-fuchsia-500/30 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-fuchsia-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-white text-sm group-hover:text-fuchsia-400 transition">New Post</p>
                        <p class="text-xs text-gray-500">Share a photo</p>
                    </div>
                </a>
                <a href="{{ route('public_profile.show') }}" class="group flex items-center gap-3 p-4 bg-[#1e1b2e] border border-purple-500/20 rounded-xl hover:border-pink-500/40 hover:bg-[#252238] transition-all">
                    <div class="w-10 h-10 rounded-lg bg-pink-500/20 flex items-center justify-center group-hover:bg-pink-500/30 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-pink-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-white text-sm group-hover:text-pink-400 transition">Profile</p>
                        <p class="text-xs text-gray-500">View your profile</p>
                    </div>
                </a>
                <a href="{{ route('messages.index') }}" class="group flex items-center gap-3 p-4 bg-[#1e1b2e] border border-purple-500/20 rounded-xl hover:border-cyan-500/40 hover:bg-[#252238] transition-all relative">
                    <div class="w-10 h-10 rounded-lg bg-cyan-500/20 flex items-center justify-center group-hover:bg-cyan-500/30 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-cyan-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-white text-sm group-hover:text-cyan-400 transition">Messages</p>
                        <p class="text-xs text-gray-500">Direct messages</p>
                    </div>
                    @if(Auth::user()->unreadMessagesCount() > 0)
                        <span class="absolute top-2 right-2 w-5 h-5 bg-cyan-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                            {{ Auth::user()->unreadMessagesCount() > 9 ? '9+' : Auth::user()->unreadMessagesCount() }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('profile.edit') }}" class="group flex items-center gap-3 p-4 bg-[#1e1b2e] border border-purple-500/20 rounded-xl hover:border-blue-500/40 hover:bg-[#252238] transition-all">
                    <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center group-hover:bg-blue-500/30 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-white text-sm group-hover:text-blue-400 transition">Settings</p>
                        <p class="text-xs text-gray-500">Edit account</p>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Activity -->
                <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-xl overflow-hidden">
                    <div class="p-4 border-b border-purple-500/10">
                        <h2 class="font-semibold text-white flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-purple-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                            Recent Activity
                        </h2>
                    </div>
                    <div class="p-4 space-y-3 max-h-80 overflow-y-auto">
                        @forelse($recentLikes->merge($recentComments)->sortByDesc('created_at')->take(8) as $activity)
                            <div class="flex items-start gap-3 p-3 bg-[#252238] rounded-lg">
                                @if($activity->user->profile_photo)
                                    <img src="{{ $activity->user->profile_photo_url }}" alt="{{ $activity->user->name }}" class="w-8 h-8 rounded-full object-cover">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($activity->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-300">
                                        <span class="font-medium text-white">{{ $activity->user->name }}</span>
                                        @if($activity instanceof \App\Models\Like)
                                            <span class="text-pink-400">liked</span> your post
                                        @else
                                            <span class="text-purple-400">commented</span> on your post
                                        @endif
                                    </p>
                                    @if($activity instanceof \App\Models\Comment)
                                        <p class="text-xs text-gray-500 truncate mt-1">"{{ Str::limit($activity->body, 50) }}"</p>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                                </div>
                                @if($activity->post && $activity->post->image_path)
                                    <a href="{{ route('posts.show', $activity->post) }}" class="shrink-0">
                                        <img src="{{ $activity->post->image_url }}" alt="Post" class="w-10 h-10 rounded object-cover">
                                    </a>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-600 mx-auto mb-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                </svg>
                                <p class="text-gray-500 text-sm">No recent activity yet</p>
                                <p class="text-gray-600 text-xs mt-1">Share posts to get likes and comments!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Top Performing Posts -->
                <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-xl overflow-hidden">
                    <div class="p-4 border-b border-purple-500/10">
                        <h2 class="font-semibold text-white flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-fuchsia-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                            </svg>
                            Top Posts
                        </h2>
                    </div>
                    <div class="p-4 space-y-3">
                        @forelse($topPosts as $index => $post)
                            <a href="{{ route('posts.show', $post) }}" class="flex items-center gap-3 p-3 bg-[#252238] rounded-lg hover:bg-[#2a2640] transition group">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold
                                    {{ $index === 0 ? 'bg-yellow-500/20 text-yellow-400' : '' }}
                                    {{ $index === 1 ? 'bg-gray-400/20 text-gray-400' : '' }}
                                    {{ $index === 2 ? 'bg-orange-500/20 text-orange-400' : '' }}">
                                    {{ $index + 1 }}
                                </div>
                                @if($post->image_path)
                                    <img src="{{ $post->image_url }}" alt="Post" class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-[#1e1b2e] flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-300 truncate">{{ Str::limit($post->description, 40) }}</p>
                                    <p class="text-xs text-gray-500">{{ $post->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="flex items-center gap-1 text-pink-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                        <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                                    </svg>
                                    <span class="text-sm font-medium">{{ $post->likes_count }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-600 mx-auto mb-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                                <p class="text-gray-500 text-sm">No posts yet</p>
                                <a href="{{ route('posts.create') }}" class="text-purple-400 text-xs mt-1 hover:underline">Create your first post</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Account Info Footer -->
            <div class="mt-8 p-4 bg-[#1e1b2e]/50 border border-purple-500/10 rounded-xl">
                <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-gray-400">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        <span>Member since {{ $memberSince->format('F Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        <span>{{ Auth::user()->email }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

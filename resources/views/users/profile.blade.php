<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Profile Header -->
        <header class="flex flex-col md:flex-row items-center md:items-start gap-8 md:gap-16 mb-12">
            <!-- Profile Picture -->
            <div class="flex-shrink-0">
                @if($user->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                         alt="{{ $user->name }}" 
                         class="w-36 h-36 md:w-40 md:h-40 rounded-full object-cover ring-4 ring-purple-500/30 shadow-lg shadow-purple-500/20">
                @else
                    <div class="w-36 h-36 md:w-40 md:h-40 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 flex items-center justify-center text-white text-5xl font-bold ring-4 ring-purple-500/30 shadow-lg shadow-purple-500/30">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <!-- Profile Info -->
            <div class="flex-1 text-center md:text-left">
                <div class="flex flex-col md:flex-row items-center gap-4 mb-6">
                    <h1 class="text-xl font-normal text-white">{{ $user->name }}</h1>
                    
                    <form action="{{ route('users.follow', $user->id) }}" method="POST">
                        @csrf
                        @if ($isFollowing)
                            <button type="submit" class="px-6 py-2 bg-[#1e1b2e] hover:bg-purple-500/20 border border-purple-500/30 text-white text-sm font-semibold rounded-lg transition flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-purple-400">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                                </svg>
                                Following
                            </button>
                        @else
                            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-500 to-fuchsia-500 hover:from-purple-600 hover:to-fuchsia-600 text-white text-sm font-semibold rounded-lg transition shadow-lg shadow-purple-500/25">
                                Follow
                            </button>
                        @endif
                    </form>
                </div>

                <!-- Stats -->
                <div class="flex justify-center md:justify-start gap-8 mb-6">
                    <div class="text-center md:text-left">
                        <span class="font-semibold text-white">{{ $posts->count() }}</span>
                        <span class="text-gray-400 ml-1">posts</span>
                    </div>
                    <div class="text-center md:text-left">
                        <span class="font-semibold text-white">{{ $user->followers()->count() }}</span>
                        <span class="text-gray-400 ml-1">followers</span>
                    </div>
                    <div class="text-center md:text-left">
                        <span class="font-semibold text-white">{{ $user->following()->count() }}</span>
                        <span class="text-gray-400 ml-1">following</span>
                    </div>
                </div>

                <!-- Bio -->
                <div class="text-sm text-white">
                    <p class="font-semibold">{{ $user->name }}</p>
                </div>
            </div>
        </header>

        <!-- Tabs -->
        <div class="border-t border-purple-500/20">
            <div class="flex justify-center gap-12">
                <button class="flex items-center gap-2 py-4 border-t-2 border-purple-500 -mt-px text-xs font-semibold tracking-wider uppercase text-purple-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 0 2.25 2.25H6A2.25 2.25 0 0 0 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    Posts
                </button>
            </div>
        </div>

        <!-- Posts Grid -->
        <div class="mt-4">
            @if($posts->count() > 0)
                <div class="grid grid-cols-3 gap-1 md:gap-4">
                    @foreach ($posts as $post)
                        <a href="{{ route('posts.show', $post->id) }}" class="aspect-square group relative overflow-hidden bg-[#1e1b2e] rounded-lg">
                            @if($post->image_path)
                                <img src="{{ asset('storage/' . $post->image_path) }}" 
                                     alt="Post" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                <div class="absolute inset-0 bg-purple-500/0 group-hover:bg-purple-500/20 transition flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <div class="flex items-center gap-6 text-white font-semibold">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-gray-500">No image</span>
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full border-2 border-purple-500/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-10 h-10 text-purple-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">No Posts Yet</h3>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

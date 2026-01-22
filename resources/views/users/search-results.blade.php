<x-app-layout>
    <div class="max-w-lg mx-auto px-4 py-8">
        <!-- Search Again -->
        <form action="{{ route('search.results') }}" method="GET" class="mb-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
                <input type="text" 
                       name="query" 
                       value="{{ $query ?? '' }}"
                       placeholder="Search" 
                       required
                       autocomplete="off"
                       class="w-full pl-12 pr-4 py-3 bg-[#1e1b2e] border border-purple-500/20 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
            </div>
        </form>

        @if(isset($query))
            <p class="text-sm text-gray-500 mb-4">
                Results for "<span class="font-medium text-white">{{ $query }}</span>"
            </p>
        @endif

        @if($users->isEmpty())
            <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-2xl p-12 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[#13111c] border border-purple-500/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0 0 12.016 15a4.486 4.486 0 0 0-3.198 1.318M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">No users found</h3>
                <p class="text-sm text-gray-500">Try searching for a different name.</p>
            </div>
        @else
            <div class="space-y-2">
                @foreach($users as $user)
                    <a href="{{ route('profile.view', $user->id) }}" 
                       class="flex items-center gap-4 p-4 bg-[#1e1b2e] border border-purple-500/20 rounded-xl hover:bg-purple-500/10 hover:border-purple-500/40 transition group">
                        <!-- Profile Picture -->
                        @if($user->profile_photo)
                            <img src="{{ $user->profile_photo_url }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-14 h-14 rounded-full object-cover ring-2 ring-purple-500/30 group-hover:ring-purple-500/50 transition">
                        @else
                            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 flex items-center justify-center text-white text-lg font-bold shadow-lg shadow-purple-500/20">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif

                        <!-- User Info -->
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-white truncate group-hover:text-purple-300 transition">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $user->posts()->count() }} posts</p>
                        </div>

                        <!-- Arrow -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 group-hover:text-purple-400 transition">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>

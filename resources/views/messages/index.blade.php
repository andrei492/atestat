<x-app-layout>
    <div class="min-h-screen py-8">
        <div class="max-w-2xl mx-auto px-4">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-white">Messages</h1>
                <a href="{{ route('search.form') }}" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-fuchsia-600 hover:from-purple-500 hover:to-fuchsia-500 text-white text-sm font-medium rounded-xl transition-all shadow-lg shadow-purple-500/25">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    New Message
                </a>
            </div>

            <!-- Conversations List -->
            <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-2xl overflow-hidden">
                @forelse($conversations as $conversation)
                    @php
                        $otherUser = $conversation->getOtherUser(auth()->id());
                        $unreadCount = $conversation->unreadCountFor(auth()->id());
                        $lastMessage = $conversation->lastMessage;
                    @endphp
                    <a href="{{ route('messages.show', $conversation) }}" 
                       class="flex items-center gap-4 p-4 hover:bg-[#252238] transition border-b border-purple-500/10 last:border-b-0 {{ $unreadCount > 0 ? 'bg-purple-500/5' : '' }}">
                        <!-- Avatar -->
                        <div class="relative shrink-0">
                            @if($otherUser->profile_photo)
                                <img src="{{ asset('storage/' . $otherUser->profile_photo) }}" 
                                     alt="{{ $otherUser->name }}" 
                                     class="w-14 h-14 rounded-full object-cover border-2 {{ $unreadCount > 0 ? 'border-purple-500' : 'border-purple-500/20' }}">
                            @else
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 flex items-center justify-center text-white text-lg font-bold border-2 {{ $unreadCount > 0 ? 'border-purple-400' : 'border-transparent' }}">
                                    {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                                </div>
                            @endif
                            @if($unreadCount > 0)
                                <div class="absolute -top-1 -right-1 w-5 h-5 bg-purple-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="font-semibold text-white truncate {{ $unreadCount > 0 ? 'text-purple-300' : '' }}">
                                    {{ $otherUser->name }}
                                </h3>
                                @if($lastMessage)
                                    <span class="text-xs text-gray-500 shrink-0 ml-2">
                                        {{ $lastMessage->created_at->diffForHumans(null, true) }}
                                    </span>
                                @endif
                            </div>
                            @if($lastMessage)
                                <p class="text-sm truncate {{ $unreadCount > 0 ? 'text-gray-300 font-medium' : 'text-gray-500' }}">
                                    @if($lastMessage->sender_id === auth()->id())
                                        <span class="text-gray-500">You: </span>
                                    @endif
                                    {{ $lastMessage->body }}
                                </p>
                            @else
                                <p class="text-sm text-gray-500 italic">No messages yet</p>
                            @endif
                        </div>

                        <!-- Arrow -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-600 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                @empty
                    <div class="p-12 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-purple-500/10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-purple-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">No conversations yet</h3>
                        <p class="text-gray-400 mb-6">Start a conversation by searching for a user and clicking the message button on their profile.</p>
                        <a href="{{ route('search.form') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-fuchsia-600 hover:from-purple-500 hover:to-fuchsia-500 text-white font-medium rounded-xl transition-all shadow-lg shadow-purple-500/25">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            Find People
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

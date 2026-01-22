<x-app-layout>
    <div class="max-w-lg mx-auto px-4 py-8">
        <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-2xl shadow-lg shadow-purple-500/5 overflow-hidden">
            <!-- Header -->
            <div class="p-6 text-center border-b border-purple-500/20">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 flex items-center justify-center shadow-lg shadow-purple-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
                <h1 class="text-xl font-semibold text-white mb-2">Search</h1>
                <p class="text-sm text-gray-400">Find friends and people you know</p>
            </div>

            <!-- Search Form -->
            <form action="{{ route('search.results') }}" method="GET" class="p-6">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                    <input type="text" 
                           name="query" 
                           placeholder="Search" 
                           required
                           autocomplete="off"
                           class="w-full pl-12 pr-4 py-3 bg-[#13111c] border border-purple-500/20 rounded-xl text-white placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                </div>
                <button type="submit" class="w-full mt-4 py-3 bg-gradient-to-r from-purple-500 to-fuchsia-500 hover:from-purple-600 hover:to-fuchsia-600 text-white font-semibold rounded-xl transition shadow-lg shadow-purple-500/25">
                    Search
                </button>
            </form>
        </div>

        <!-- Suggestions (placeholder for future feature) -->
        <div class="mt-8">
            <h2 class="text-sm font-semibold text-gray-500 mb-4 px-2">Suggested</h2>
            <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-2xl overflow-hidden">
                <div class="p-8 text-center text-gray-500">
                    <p class="text-sm">Search for users by their username</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

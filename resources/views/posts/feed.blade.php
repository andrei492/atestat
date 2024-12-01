<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Feed') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                <div class="container">
                    <h1>Your Feed</h1>
                    
                    @forelse($posts as $post)
                        <div class="post">
                            <h3>{{ $post->user->name }}</h3>
                            
                            <small>Posted on {{ $post->created_at->format('Y-m-d H:i') }}</small>
                            <hr>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-gray-500">No posts yet.</p>
                    @endforelse

                    <!-- Pagination links -->
                    {{ $posts->links() }}
                </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

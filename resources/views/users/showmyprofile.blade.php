<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Display User Profile Information -->
                    <h3 class="text-2xl font-semibold">{{ $user->name }}</h3>
                    <p>Email: {{ $user->email }}</p>

                    <!-- Display Profile Photo -->
                    <div class="my-4">
                        <h4 class="text-lg font-semibold">Profile Photo</h4>
                        @if($user->profile_photo && file_exists(public_path('storage/' . $user->profile_photo)))
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="w-32 h-32 rounded-full object-cover">
                        @else
                            <img src="{{ asset('images/default-profile.jpg') }}" alt="Default Profile Photo" class="w-32 h-32 rounded-full object-cover">
                        @endif
                    </div>


                    <!-- Display User's Posts -->
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold">My Posts</h4>
                        <div class="grid grid-cols-1 gap-6 mt-4">
                            @forelse ($posts as $post)
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                                    <h5 class="text-xl font-semibold">{{ $post->title }}</h5>
                                    <p class="mt-2">{{ $post->content }}</p>
                                    @if($post->image_path && file_exists(public_path('storage/' . $post->image_path)))
                                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="mt-4 w-full h-64 object-cover rounded-lg">
                                    @else
                                        <p class="mt-4 text-gray-500">No image uploaded for this post.</p>
                                    @endif
                                </div>
                            @empty
                                <p>No posts yet.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

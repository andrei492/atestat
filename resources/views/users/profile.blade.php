<link rel="stylesheet" href="{{ asset('css/styles_profile_picture.css') }}">
<link rel="stylesheet" href="{{ asset('css/styles_posts_on_profile_page.css') }}">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user->name }}'s Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Display User Profile Information -->
                    <h3 class="text-2xl font-semibold">{{ $user->name }}</h3>

                    <!-- Display Profile Photo -->
                    <div class="my-4">
                        @if($user->profile_photo && file_exists(public_path('storage/' . $user->profile_photo)))
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="profile-photo-circle">
                        @else
                            <img src="{{ asset('images/default-profile.jpg') }}" alt="Default Profile Photo" class="profile-photo-circle">
                        @endif
                    </div>

                    <!-- Display follow button -->
                    <div>
                        <form action="{{ route('users.follow', $user->id) }}" method="POST">
                            @csrf
                            @if ($isFollowing)
                                <button type="submit" class="btn btn-danger">Unfollow</button>
                            @else
                                <button type="submit" class="btn btn-primary">Follow</button>
                            @endif
                        </form>
                    </div>    

                    <!-- Display User's Posts -->
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold">My Posts</h4>
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;" class="mt-4">
                            @forelse ($posts as $post)
                                <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                    @if($post->image_path && file_exists(public_path('storage/' . $post->image_path)))
                                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="post-dimesions">
                                    @else
                                        <div class="w-full h-64 bg-gray-300 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                            <p class="text-gray-500">No image</p>
                                        </div>
                                    @endif
                                    <div class="absolute bottom-0 left-0 w-full bg-gray-900 bg-opacity-75 text-white p-2 text-center">
                                        <h5 class="text-md font-semibold truncate">{{ $post->title }}</h5>
                                    </div>
                                </div>
                            @empty
                                <p class="col-span-full text-center text-gray-500">No posts yet.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

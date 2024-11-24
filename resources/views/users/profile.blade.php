<link rel="stylesheet" href="{{ asset('css/styles_profile_picture.css') }}">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1>{{ $user->name }}</h1>

                    <!-- Profile Picture -->
                    @if($user->profile_photo && file_exists(public_path('storage/' . $user->profile_photo)))
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="profile-photo-circle">
                    @else
                        <img src="{{ asset('images/default-profile.jpg') }}" alt="Default Profile Photo" class="profile-photo-circle">
                    @endif

                    <!-- User Details -->
                    <p>Email: {{ $user->email }}</p>
                    <p>Joined: {{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

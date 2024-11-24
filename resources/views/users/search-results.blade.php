<link rel="stylesheet" href="{{ asset('css/styles_profile_picture.css') }}">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Search Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(isset($query))
                        <p>Results for "{{ $query }}":</p>
                    @endif

                    @if($users->isEmpty())
                        <p>No users found.</p>
                    @else
                        <ul>
                            @foreach($users as $user)
                                <li class="flex items-center space-x-4">
                                    <!-- Profile Picture -->
                                    @if($user->profile_photo && file_exists(public_path('storage/' . $user->profile_photo)))
                                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" class="profile-photo-circle">
                                    @else
                                        <img src="{{ asset('images/default-profile.jpg') }}" alt="Default Profile Photo" class="profile-photo-circle">
                                    @endif

                                    <!-- User Name, which is clickable to view the user's profile -->
                                    <a href="{{ route('profile.show', $user->id) }}" class="text-blue-500 hover:text-blue-700">
                                        {{ $user->name }} ({{ $user->email }})
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<section>
<header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Picture') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile picture.") }}
        </p>
    </header>
    <form action="{{ route('profile.photo.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="photo">Profile Photo:</label>
            <input type="file" name="photo" id="photo">
        </div>
        <button type="submit">Upload Photo</button>
    </form>
    @if(Auth::user()->profile_photo)
        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo" width="100">
    @else
         <p>No profile photo uploaded.</p>
    @endif
</section>
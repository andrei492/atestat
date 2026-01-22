<section>
    <header>
        <h2 class="text-lg font-semibold text-white">
            {{ __('Profile Picture') }}
        </h2>
        <p class="mt-1 text-sm text-gray-400">
            {{ __("Update your account's profile picture.") }}
        </p>
    </header>

    <form action="{{ route('profile.photo.upload') }}" method="POST" enctype="multipart/form-data" class="mt-6" x-data="{
        imagePreview: '{{ Auth::user()->profile_photo ? Auth::user()->profile_photo_url : '' }}',
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    }">
        @csrf
        
        <div class="flex items-center gap-6">
            <!-- Current/Preview Photo -->
            <div class="flex-shrink-0">
                <template x-if="imagePreview">
                    <img :src="imagePreview" alt="Profile Photo" class="w-20 h-20 rounded-full object-cover ring-2 ring-purple-500/30">
                </template>
                <template x-if="!imagePreview">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-purple-500/30">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </template>
            </div>

            <div class="flex-1">
                <p class="font-semibold text-white">{{ Auth::user()->name }}</p>
                
                <div class="mt-2 flex items-center gap-3">
                    <label class="cursor-pointer px-4 py-2 bg-gradient-to-r from-purple-500 to-fuchsia-500 hover:from-purple-600 hover:to-fuchsia-600 text-white text-sm font-semibold rounded-lg transition shadow-lg shadow-purple-500/25">
                        <span>Change photo</span>
                        <input type="file" 
                               name="photo" 
                               id="photo" 
                               accept="image/*"
                               class="hidden"
                               @change="handleFileSelect($event)">
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-4">
            <button type="submit" class="px-4 py-2 bg-gradient-to-r from-purple-500 to-fuchsia-500 hover:from-purple-600 hover:to-fuchsia-600 text-white text-sm font-semibold rounded-lg transition shadow-lg shadow-purple-500/25">
                {{ __('Save') }}
            </button>

            @if (session('success'))
                <p class="text-sm text-green-400">{{ session('success') }}</p>
            @endif
        </div>
    </form>
</section>
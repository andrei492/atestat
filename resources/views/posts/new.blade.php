<x-app-layout>
    <div class="create-post-container max-w-lg mx-auto px-4 py-8">
        <div class="bg-[#1e1b2e] border border-purple-500/20 rounded-2xl shadow-lg shadow-purple-500/5 overflow-hidden">
            <!-- Header -->
            <div class="border-b border-purple-500/20 p-4">
                <h1 class="text-lg font-semibold text-center text-white">Create new post</h1>
            </div>

            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="p-6" x-data="{ 
                imagePreview: null,
                fileName: null,
                handleFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.fileName = file.name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.imagePreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },
                clearImage() {
                    this.imagePreview = null;
                    this.fileName = null;
                    this.$refs.fileInput.value = '';
                }
            }">
                @csrf
                
                <!-- Hidden file input that always exists -->
                <input type="file" 
                       name="upload_file" 
                       id="upload_file" 
                       x-ref="fileInput"
                       accept="image/*"
                       class="hidden"
                       @change="handleFileSelect($event)">
                
                <!-- Upload Area -->
                <div class="relative">
                    <div x-show="!imagePreview" 
                         @click="$refs.fileInput.click()"
                         class="border-2 border-dashed border-purple-500/30 rounded-xl p-12 text-center hover:border-purple-500 transition cursor-pointer bg-[#13111c]">
                        
                        <div class="space-y-4">
                            <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 flex items-center justify-center shadow-lg shadow-purple-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-medium text-white">Drag photos here</p>
                                <p class="text-sm text-gray-400 mt-1">or click to select from your computer</p>
                            </div>
                            <span class="inline-block px-4 py-2 bg-gradient-to-r from-purple-500 to-fuchsia-500 hover:from-purple-600 hover:to-fuchsia-600 text-white text-sm font-semibold rounded-lg transition shadow-lg shadow-purple-500/25">
                                Select from computer
                            </span>
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <div x-show="imagePreview" x-cloak class="relative">
                        <img :src="imagePreview" alt="Preview" class="w-full aspect-square object-cover rounded-xl ring-2 ring-purple-500/30">
                        <button type="button" 
                                @click="clearImage()" 
                                class="absolute top-3 right-3 p-2 bg-black/50 hover:bg-purple-500/70 rounded-full text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- File name display -->
                <p x-show="fileName" x-text="fileName" class="mt-3 text-sm text-gray-400 truncate"></p>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full mt-6 py-3 bg-gradient-to-r from-purple-500 to-fuchsia-500 hover:from-purple-600 hover:to-fuchsia-600 disabled:from-gray-600 disabled:to-gray-600 disabled:cursor-not-allowed text-white font-semibold rounded-xl transition shadow-lg shadow-purple-500/25"
                        :disabled="!imagePreview">
                    Share
                </button>

                <!-- Errors -->
                @if ($errors->any())
                    <div class="mt-4 p-4 bg-red-900/20 border border-red-500/30 rounded-xl">
                        <ul class="text-sm text-red-400 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 flex-shrink-0">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>
    </div>
</x-app-layout>

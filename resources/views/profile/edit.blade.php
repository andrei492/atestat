<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-[#1e1b2e] border border-purple-500/20 shadow-lg shadow-purple-500/5 sm:rounded-xl">
                <div class="max-w-xl">
                    @include('profile.partials.upload-profile-picture-form')
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-[#1e1b2e] border border-purple-500/20 shadow-lg shadow-purple-500/5 sm:rounded-xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-[#1e1b2e] border border-purple-500/20 shadow-lg shadow-purple-500/5 sm:rounded-xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-[#1e1b2e] border border-purple-500/20 shadow-lg shadow-purple-500/5 sm:rounded-xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

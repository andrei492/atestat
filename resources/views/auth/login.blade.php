<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-white mb-2">Welcome Back</h1>
        <p class="text-gray-400">Sign in to continue to SocialApp</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" 
                            placeholder="Enter your password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-5">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded bg-[#13111c] border-purple-500/30 text-purple-500 focus:ring-purple-500/50 focus:ring-offset-0" name="remember">
                <span class="ms-2 text-sm text-gray-400">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-purple-400 hover:text-purple-300 transition" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Sign In') }}
            </x-primary-button>
        </div>

        <!-- Register Link -->
        <div class="mt-6 text-center">
            <span class="text-gray-400 text-sm">Don't have an account?</span>
            <a href="{{ route('register') }}" class="text-sm text-purple-400 hover:text-purple-300 font-medium ml-1 transition">
                Sign up
            </a>
        </div>
    </form>
</x-guest-layout>

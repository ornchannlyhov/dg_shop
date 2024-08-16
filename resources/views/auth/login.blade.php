<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Title -->
        <legend class="text-lg font-semibold text-gray-800 mt-3">Login</legend>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="flex items-center">
                <i class="fas fa-envelope mr-2 text-gray-600"></i>
                <span>{{ __('Email') }}</span>
            </label>
            <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="flex items-center">
                <i class="fas fa-lock mr-2 text-gray-600"></i>
                <span>{{ __('Password') }}</span>
            </label>
            <x-text-input id="password" class="block mt-2 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4 items-center">
            <input id="remember_me" type="checkbox"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
            <label for="remember_me" class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</label>
        </div>

        <!-- Login Button -->
        <div class="flex items-center justify-center mt-6">
            <x-primary-button class="w-full justify-center">
                {{ __('Login') }}
            </x-primary-button>
        </div>

        <!-- Forgot Password Link -->
        <div class="flex justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Divider -->
        <div class="flex items-center justify-center my-6 mt-4">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="px-4 text-gray-500 border border-gray-300 rounded-full mx-2">OR</span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>

        <!-- Social Login Buttons -->
        <div class="flex justify-center space-x-8 mt-4">
            <!-- Google Button -->
            <a href="{{ route('registerWithGoogle', ['provider' => 'google']) }}"
                class="flex items-center justify-center border border-gray-300 rounded-full p-3 hover:bg-gray-50">
                <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M21.805 10.023H12.1v3.954h5.554c-.474 2.225-2.465 3.822-4.9 3.822-2.936 0-5.32-2.384-5.32-5.32s2.384-5.32 5.32-5.32c1.304 0 2.484.479 3.4 1.258l2.913-2.913c-1.711-1.588-3.967-2.563-6.313-2.563-5.229 0-9.477 4.249-9.477 9.478s4.248 9.478 9.477 9.478c4.874 0 8.925-3.473 9.478-7.996v-2.966z" />
                </svg>
            </a>

            <!-- Facebook Button -->
            <a href="#"
                class="flex items-center justify-center border border-gray-300 rounded-full p-3 hover:bg-gray-50">
                <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M22.23 0H1.77C.79 0 0 .8 0 1.78v20.44C0 23.2.79 24 1.77 24H12V14.7h-3.2V11h3.2V8.45c0-3.18 1.95-4.91 4.8-4.91 1.37 0 2.54.1 2.88.15v3.35h-1.98c-1.55 0-1.85.74-1.85 1.82V11h3.7l-.48 3.7H15.8V24h6.43c.98 0 1.77-.8 1.77-1.78V1.78C24 .8 23.21 0 22.23 0z" />
                </svg>
            </a>
        </div>

        <!-- Sign Up Link -->
        <div class="flex justify-center mt-6 ">
            <p class="text-sm text-gray-600">
                {{ __("Need an account?") }}
                <a href="{{ route('register') }}" class="text-pink-500 hover:text-pink-600 font-semibold">Sign Up</a>
            </p>
        </div>
    </form>
</x-guest-layout>

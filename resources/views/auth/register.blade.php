<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="flex w-full max-w-5xl bg-white rounded-lg shadow-lg overflow-hidden md:flex-row flex-col">
            
            <!-- Left Side: Logo -->
            <div class="md:w-1/2 w-full bg-blue-600 flex items-center justify-center p-8">
                <img src="{{ asset('Images/IMG_0017.PNG') }}" alt="Logo" class="w-3/4">
            </div>

            <!-- Right Side: Registration Form -->
            <div class="md:w-1/2 w-full p-8">
                <form method="POST" action="{{ route('register') }}" @submit="loading = true;">
                    @csrf

                    <!-- Name -->
                    <div class="flex md:flex-row flex-col gap-2">
                        <div class="w-full">
                            <x-input-label for="fname" :value="__('First Name')" />
                            <x-text-input id="fname" class="block mt-1 w-full" type="text" name="fname" :value="old('fname')" required autofocus autocomplete="fname" />
                            <x-input-error :messages="$errors->get('fname')" class="mt-2" />
                        </div>

                        <div class="w-full">
                            <x-input-label for="mname" :value="__('Middle Name')" />
                            <x-text-input id="mname" class="block mt-1 w-full" type="text" name="mname" :value="old('mname')" />
                            <x-input-error :messages="$errors->get('mname')" class="mt-2" />
                        </div>

                        <div class="w-full">
                            <x-input-label for="lname" :value="__('Last Name')" />
                            <x-text-input id="lname" class="block mt-1 w-full" type="text" name="lname" :value="old('lname')" required autocomplete="lname" />
                            <x-input-error :messages="$errors->get('lname')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Register Button -->
                    <div class="flex items-center justify-between mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-primary-button class="ms-4">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>

<section>
                        <header class="text-center mb-6">
                            <h2 class="text-3xl font-extrabold text-white mb-2">
                                <i class="fas fa-key text-yellow-400 mr-2"></i> Update Password
                            </h2>
                            <p class="mt-1 text-gray-400 text-md">
                                Ensure your account is using a long, random password to stay secure.
                            </p>
                        </header>

                        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('put')

                            <!-- Current Password -->
                            <div>
                                <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-white text-md mb-2 block" />
                                <x-text-input
                                    id="update_password_current_password"
                                    name="current_password"
                                    type="password"
                                    class="w-full border border-gray-600 bg-gray-700 text-white p-3 rounded-lg shadow-sm
                                           focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent
                                           transition duration-200 ease-in-out"
                                    autocomplete="current-password"
                                    placeholder="Enter your current password"
                                />
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>

                            <!-- New Password -->
                            <div>
                                <x-input-label for="update_password_password" :value="__('New Password')" class="text-white text-md mb-2 block" />
                                <x-text-input
                                    id="update_password_password"
                                    name="password"
                                    type="password"
                                    class="w-full border border-gray-600 bg-gray-700 text-white p-3 rounded-lg shadow-sm
                                           focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent
                                           transition duration-200 ease-in-out"
                                    autocomplete="new-password"
                                    placeholder="Enter a new password"
                                />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm New Password -->
                            <div>
                                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-white text-md mb-2 block" />
                                <x-text-input
                                    id="update_password_password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    class="w-full border border-gray-600 bg-gray-700 text-white p-3 rounded-lg shadow-sm
                                           focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent
                                           transition duration-200 ease-in-out"
                                    autocomplete="new-password"
                                    placeholder="Confirm your new password"
                                />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>

                            <!-- Save Button for Password -->
                            <div class="mt-8">
                                <button type="submit"
                                    class="bg-gradient-to-r from-yellow-600 to-yellow-800 text-white py-3 px-6 rounded-lg
                                           w-full font-semibold text-lg tracking-wide shadow-lg
                                           hover:from-yellow-500 hover:to-yellow-700 hover:shadow-xl
                                           transition-all duration-300 ease-in-out">
                                    <i class="fas fa-lock mr-2"></i> Update Password
                                </button>
                            </div>

                            <!-- Success Message for Password Update -->
                            @if (session('status') === 'password-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-green-400 mt-4 text-center"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </form>
                    </section>
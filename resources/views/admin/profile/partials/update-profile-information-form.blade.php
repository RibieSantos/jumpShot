<form method="post" action="{{ route('profile.update') }}" @submit="loading = true;" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <!-- Form Header -->
                        <div class="text-center mb-6">
                            <h2 class="text-3xl font-extrabold text-white mb-2">
                                <i class="fas fa-user-shield text-blue-400 mr-2"></i> Admin Information
                            </h2>
                            <p class="text-gray-400 text-md">Manage your account details</p>
                        </div>

                        <!-- Name Field -->
                        <div>
                            <x-input-label for="name" value="Name" class="text-white text-md mb-2 block" />
                            <x-text-input
                                id="name"
                                name="name"
                                type="text"
                                class="w-full border border-gray-600 bg-gray-700 text-white p-3 rounded-lg shadow-sm
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                       transition duration-200 ease-in-out"
                                value="{{ old('name', $admin->name) }}"
                                required
                                autocomplete="name"
                                placeholder="Enter your full name"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <!-- Contact Field -->
                        <div>
                            <x-input-label for="contact" value="Contact Number" class="text-white text-md mb-2 block" />
                            <x-text-input
                                id="contact"
                                name="contact"
                                type="text"
                                class="w-full border border-gray-600 bg-gray-700 text-white p-3 rounded-lg shadow-sm
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                       transition duration-200 ease-in-out"
                                value="{{ old('contact', $admin->contact) }}"
                                required
                                autocomplete="contact"
                                placeholder="Enter your contact number"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('contact')" />
                        </div>
                        <!-- Address Field -->
                        <div>
                            <x-input-label for="address" value="Address" class="text-white text-md mb-2 block" />
                            <x-text-input
                                id="address"
                                name="address"
                                type="text"
                                class="w-full border border-gray-600 bg-gray-700 text-white p-3 rounded-lg shadow-sm
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                       transition duration-200 ease-in-out"
                                value="{{ old('address', $admin->address) }}"
                                required
                                autocomplete="address"
                                placeholder="Enter your Complete address"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        <!-- Email Field -->
                        <div>
                            <x-input-label for="email" value="Email" class="text-white text-md mb-2 block" />
                            <x-text-input
                                id="email"
                                name="email"
                                type="email"
                                class="w-full border border-gray-600 bg-gray-700 text-white p-3 rounded-lg shadow-sm
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                       transition duration-200 ease-in-out"
                                value="{{ old('email', $admin->email) }}"
                                required
                                autocomplete="email"
                                placeholder="Enter your email address"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <!-- Save Button -->
                        <div class="mt-8">
                            <button type="submit"
                                class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-3 px-6 rounded-lg
                                       w-full font-semibold text-lg tracking-wide shadow-lg
                                       hover:from-blue-500 hover:to-blue-700 hover:shadow-xl
                                       transition-all duration-300 ease-in-out">
                                <i class="fas fa-save mr-2"></i> Save Changes
                            </button>
                        </div>

                        <!-- SweetAlert Script (Moved outside the form for better practice, but remains functional) -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                @if (session('status'))
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: "top-end",
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.onmouseenter = Swal.stopTimer;
                                            toast.onmouseleave = Swal.resumeTimer;
                                        }
                                    });
                                    Toast.fire({
                                        icon: "success",
                                        title: "{{ session('status') }}"
                                    });
                                @endif
                            });
                        </script>
                    </form>
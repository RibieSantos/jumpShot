<form method="post" action="{{ route('profile.update') }}" @submit="loading = true;" class="space-y-6" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <!-- USER FIELDS -->
    <h2 class="text-lg font-semibold text-gray-800">User Info</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <x-input-label for="fname" value="First Name" class="text-gray-700" />
            <x-text-input id="fname" name="fname" type="text" class="w-full bg-gray-50 text-gray-900 border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('fname', $user->fname) }}" required />
        </div>
        <div>
            <x-input-label for="mname" value="Middle Name" class="text-gray-700" />
            <x-text-input id="mname" name="mname" type="text" class="w-full bg-gray-50 text-gray-900 border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('mname', $user->mname) }}" />
        </div>
        <div>
            <x-input-label for="lname" value="Last Name" class="text-gray-700" />
            <x-text-input id="lname" name="lname" type="text" class="w-full bg-gray-50 text-gray-900 border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('lname', $user->lname) }}" required />
        </div>
        <div class="md:col-span-3">
            <x-input-label for="email" value="Email" class="text-gray-700" />
            <x-text-input id="email" name="email" type="email" class="w-full bg-gray-50 text-gray-900 border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('email', $user->email) }}" required />
        </div>
    </div>

    <!-- MEMBER FIELDS -->
    @if ($member)
    <h2 class="text-lg font-semibold mt-6 text-gray-800">Member Info</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Profile Picture Input for Member -->
        <div class="md:col-span-3">
            <x-input-label for="profile_picture" value="Profile Picture" class="text-gray-700" />
            <input type="file" id="profile_picture" name="profile_picture" 
                   class="w-full border border-gray-300 rounded-md p-2 bg-gray-50 text-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer"
                   onchange="previewImage(event, 'memberProfilePreview')" />
            <!-- Current Profile Picture Preview for Member -->
            @if ($member->profile_picture)
                <img id="memberProfilePreview" src="{{ asset('member/' . $member->profile_picture) }}" alt="Member Profile Preview" class="mt-2 w-24 h-24 object-cover rounded-full border border-gray-300 shadow-sm" />
            @else
                <img id="memberProfilePreview" src="{{ asset('Images/logo.jpg') }}" alt="Member Profile Preview" class="mt-2 w-24 h-24 object-cover rounded-full border border-gray-300 shadow-sm" style="display: none;" />
            @endif
        </div>

        <div>
            <x-input-label for="birthdate" value="Birthdate" class="text-gray-700" />
            <x-text-input id="birthdate" name="birthdate" type="date" class="w-full bg-gray-50 text-gray-900 border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('birthdate', $member->birthdate) }}" />
        </div>
        <div>
            <x-input-label for="age" value="Age" class="text-gray-700" />
            <x-text-input id="age" name="age" type="number" class="w-full bg-gray-50 text-gray-900 border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('age', $member->age) }}" />
        </div>
        
        <div>
            <x-input-label for="contact_number" value="Contact Number" class="text-gray-700" />
            <x-text-input id="contact_number" name="contact_number" type="text" class="w-full bg-gray-50 text-gray-900 border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('contact_number', $member->contact_number) }}" />
        </div>
        <div class="md:col-span-3">
            <x-input-label for="address" value="Address" class="text-gray-700" />
            <x-text-input id="address" name="address" type="text" class="w-full bg-gray-50 text-gray-900 border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('address', $member->address) }}" />
        </div>
    </div>
    @endif

    <!-- COACH FIELDS -->
    @if ($coach)
    <h2 class="text-lg font-semibold mt-6 text-gray-800">Coach Info</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Profile Picture Input for Coach -->
        <div class="md:col-span-2">
            <x-input-label for="profile_picture" value="Profile Picture" class="text-gray-700" />
            <input type="file" id="profile_picture" name="profile_picture" 
                   class="w-full border border-gray-300 rounded-md p-2 bg-gray-50 text-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer"
                   onchange="previewImage(event, 'coachProfilePreview')" />
            <!-- Current Profile Picture Preview for Coach -->
            @if ($coach->profile_picture)
                <img id="coachProfilePreview" src="{{ asset('coach/' . $coach->profile_picture) }}" alt="Coach Profile Preview" class="mt-2 w-24 h-24 object-cover rounded-full border border-gray-300 shadow-sm" />
            @else
                <img id="coachProfilePreview" src="{{ asset('Images/logo.jpg') }}" alt="Coach Profile Preview" class="mt-2 w-24 h-24 object-cover rounded-full border border-gray-300 shadow-sm" style="display: none;" />
            @endif
        </div>

        <div>
            <x-input-label for="experience_level" value="Experience" class="text-gray-700" />
            <x-text-input id="experience_level" name="experience_level" type="text" class="w-full bg-gray-50 text-gray-900 border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('experience_level', $coach->experience_level) }}" />
        </div>
        
        <div class="md:col-span-2">
            <x-input-label for="bio" value="Biography" class="text-gray-700" />
            <textarea id="bio" name="bio" class="w-full border border-gray-300 rounded-md p-2 bg-gray-50 text-gray-900 focus:border-blue-500 focus:ring-blue-500" rows="4">{{ old('bio', $coach->bio) }}</textarea>
        </div>
    </div>
    @endif

    <!-- Save Button -->
    <div class="mt-6">
        <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">{{ __('Save') }}</x-primary-button>
        <script>
            // JavaScript for image preview
            function previewImage(event, previewId) {
                const reader = new FileReader();
                reader.onload = function() {
                    const output = document.getElementById(previewId);
                    output.src = reader.result;
                    output.style.display = 'block'; // Ensure the image is visible
                };
                reader.readAsDataURL(event.target.files[0]);
            }

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
    </div>
</form>
@extends('admin.layouts.navigation')
@section('title', 'Update Member')
@section('content')

    <div class="max-w-2xl mx-auto bg-gray-800 p-6 rounded shadow text-white">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-4">Update Member</h1>
            <a href="{{ route('members.show') }}"
                @click.prevent="loading = true; setTimeout(() => {window.location.href = '{{ route('members.show') }}'}, 500);"
                class="hover:bg-gray-400 hover:rounded-lg hover:py-1 hover:px-2 duration-300 transition-all"><i
                    class="fas fa-arrow-left"></i></a>
        </div>

        <form action="{{ route('member.update', $member->id) }}" @submit="loading = true;" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Profile Picture -->
                <div class="flex flex-col w-full">
                    <label for="profile_picture" class="mb-2 font-bold capitalize">Profile Picture</label>
                    <input type="file" name="profile_picture" value="{{ $member->profile_picture }}" id="profile_picture"
                        class="border border-gray-600 bg-gray-700 text-white p-2 rounded-lg shadow file:rounded-lg file:border-none file:font-bold file:px-2 file:py-1 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('profile_picture')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
            <div class="flex sm:flex-row flex-col gap-4">
                

                <!-- Birthdate -->
                <div class="flex flex-col w-full">
                    <label for="birthdate" class="mb-2 font-bold capitalize">Birthdate</label>
                    <input type="date" name="birthdate" value="{{ $member->birthdate }}" id="birthdate"
                        class=" border border-gray-600 bg-gray-700 text-white p-2 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('birthdate')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Age -->
                <div class="flex flex-col w-full">
                    <label for="age" class="mb-2 font-bold capitalize">Age</label>
                    <input type="text" name="age" id="age" value="{{ $member->age }}"
                        placeholder="Enter your age"
                        class="border border-gray-600 bg-gray-700 text-white p-2 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('age')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Contact Number -->
                <div class="flex flex-col w-full">
                    <label for="contact_number" class="mb-2 font-bold capitalize">Contact Number</label>
                    <input type="text" name="contact_number" value="{{ $member->contact_number }}" id="contact_number"
                        placeholder="Enter your contact number"
                        class="border border-gray-600 bg-gray-700 text-white p-2 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('contact_number')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Address -->
            <div class="flex flex-col w-full mt-3">
                <label for="address" class="mb-2 font-bold capitalize">Address</label>
                <input type="text" name="address" id="address" value="{{ $member->address }}"
                    placeholder="Enter your complete address"
                    class="border border-gray-600 bg-gray-700 text-white p-2 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('address')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <input type="submit" value="Update Member"
                class="cursor-pointer bg-yellow-500 text-white px-3 py-2 rounded-lg mt-3 w-full hover:bg-white hover:text-black transition-all duration-300 hover:shadow-lg">
        </form>
    </div>

@endsection

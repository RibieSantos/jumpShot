@extends('admin.layouts.navigation')
@section('title', 'Update Coach')
@section('content')

    <div class="max-w-2xl mx-auto bg-gray-800 p-6 rounded shadow text-white">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-4">Update Coach</h1>
            <a href="{{ route('coach.show') }}"
                @click.prevent="loading = true; setTimeout(() => {window.location.href = '{{ route('coach.show') }}'}, 500);"
                class="hover:bg-gray-400 hover:rounded-lg hover:py-1 hover:px-2 duration-300 transition-all"><i
                    class="fas fa-arrow-left"></i></a>
        </div>

        <form action="{{ route('coach.update', $coach->id) }}" @submit="loading = true;" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Profile Picture -->
            <div class="flex flex-col w-full">
                <label for="profile_picture" class="mb-2 font-bold capitalize">Profile Picture</label>
                <input type="file" name="profile_picture" value="{{ $coach->profile_picture }}" id="profile_picture"
                    class="border border-gray-600 bg-gray-700 text-white p-2 rounded-lg shadow file:rounded-lg file:border-none file:font-bold file:px-2 file:py-1 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('profile_picture')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <!-- Birthdate -->
                <div class="flex flex-col w-full">
                    <label for="birthdate" class="mb-2 font-bold capitalize">Birthdate</label>
                    <input type="date" name="birthdate" value="{{ $coach->birthdate }}" id="birthdate"
                        class=" border border-gray-600 bg-gray-700 text-white p-2 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('birthdate')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Select Member -->
                <div class="flex-1 mt-4 mb-2">
                    <label for="bio" class="font-bold mb-2">Bio</label>
                    <input type="textarea" name="bio" value="{{ $coach->bio }}" placeholder="Enter your Bio"
                        id="bio"
                        class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Select Experience Level -->
                <div class="flex-1">
                    <label for="experience_level" class="block mt-4 mb-2 font-medium">Select Experience Level</label>
                    <select name="experience_level" id="experience_level"
                        class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="{{ $coach->experience_level }}">{{ $coach->experience_level }}</option>
                        <option value="beginner">Beginner</option>
                        <option value="advanced">Advanced</option>
                    </select>
                    @error('experience_level')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

            <!-- Submit Button -->
            <input type="submit" value="Update Coach"
                class="cursor-pointer bg-blue-600 text-white px-3 py-2 rounded-lg mt-5 w-full hover:bg-white hover:text-black hover:shadow-lg transition-all duration-300">
        </form>
    </div>

@endsection

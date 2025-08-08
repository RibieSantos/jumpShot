@extends('admin.layouts.navigation')
@section('title', 'Add Events')
@section('content')

    <div class="max-w-2xl mx-auto bg-gray-800 p-6 rounded shadow text-white">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-4">Add Event</h1>
            <a href="{{ route('events.show') }}"
                @click.prevent="loading = true; setTimeout(()=>{window.location.href='{{ route('events.show') }}'},500)"
                class="hover:bg-gray-400 hover:rounded-lg hover:py-1 hover:px-2 duration-300 transition-all"><i
                    class="fas fa-arrow-left"></i></a>
        </div>
        <form action="{{ route('events.store') }}" @submit="loading = true;" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Profile Picture -->
            <div class="mt-4">
                <label for="event_image" class="block mb-2 font-bold capitalize">Profile Picture</label>
                <input type="file" name="event_image"  id="event_image"
                    class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded-lg shadow file:rounded-lg file:border-none file:font-bold file:px-2 file:py-1 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('event_image')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <!-- Training Date -->
            <div class="mt-4">
                <label for="event_date" class="block mb-2 font-medium">Event Date</label>
                <input type="datetime-local" name="event_date" id="" value="{{ old('event_date') }}"
                    class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <!-- title -->
            <div class="mt-4">
                <label for="title" class="block mb-2 font-medium">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Enter title"
                    class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Description -->
            <div class="mt-4">
                <label for="description" class="block mb-2 font-medium">Description</label>
                <input type="text" name="description" id="description" value="{{ old('description') }}"
                    placeholder="Enter event description"
                    class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>
            <!-- Location -->
            <div class="mt-4">
                <label for="location" class="block mb-2 font-medium">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location') }}"
                    placeholder="Enter event location"
                    class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>



            <!-- Submit Button -->
            <input type="submit" value="Add Event"
                class="cursor-pointer bg-blue-600 text-white px-3 py-2 rounded-lg mt-5 w-full hover:bg-white hover:text-black transition-all duration-300 hover:shadow-lg">
        </form>
    </div>

@endsection

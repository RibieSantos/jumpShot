@extends('admin.layouts.navigation')
@section('title', 'Add gallery')
@section('content')

    <div class="max-w-2xl mx-auto bg-gray-800 p-6 rounded shadow text-white">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-4">Add Event</h1>
            <a href="{{ route('gallery.show') }}"
                @click.prevent="loading = true; setTimeout(()=>{window.location.href='{{ route('gallery.show') }}'},500)"
                class="hover:bg-gray-400 hover:rounded-lg hover:py-1 hover:px-2 duration-300 transition-all"><i
                    class="fas fa-arrow-left"></i></a>
        </div>
        <form action="{{ route('gallery.store') }}" @submit="loading = true;" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Profile Picture -->
            <div class="mt-4">
                <label for="image" class="block mb-2 font-bold capitalize">Image</label>
                <input type="file" name="image"  id="image"
                    class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded-lg shadow file:rounded-lg file:border-none file:font-bold file:px-2 file:py-1 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('image')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Training Title -->
        <label for="title" class="block my-2 font-medium">Image Title</label>
        <input type="text" name="title" id="" value="{{ old('title') }}" placeholder="Enter a Training Title" class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

        <!-- Training Title -->
        <label for="description" class="block my-2 font-medium">Image Description</label>
        <input type="text" name="description" id="" value="{{ old('description') }}" placeholder="Enter a Training description" class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">




            <!-- Submit Button -->
            <input type="submit" value="Add Image"
                class="cursor-pointer bg-blue-600 text-white px-3 py-2 rounded-lg mt-5 w-full hover:bg-white hover:text-black transition-all duration-300 hover:shadow-lg">
        </form>
    </div>

@endsection

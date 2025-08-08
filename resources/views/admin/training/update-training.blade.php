@extends('admin.layouts.navigation')
@section('title', 'Update Training')
@section('content')

    <div class="max-w-2xl mx-auto bg-gray-800 p-6 rounded shadow text-white">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-4">Update Training</h1>
            <a href="{{ route('trainings.show') }}"
                @click.prevent="loading = true; setTimeout (()=>{window.location.href='{{ route('trainings.show') }}'},500)"
                class="hover:bg-gray-400 hover:rounded-lg hover:py-1 hover:px-2 duration-300 transition-all"><i
                    class="fas fa-arrow-left"></i></a>
        </div>
        <form action="{{ route('trainings.update', $trainings->id) }}" @submit="loading = true;" method="POST">
            @csrf
            @method('PUT')
            <!-- Select Teams -->
            <label for="team_id" class="block mb-2 font-medium">Select a Team</label>
            <select name="team_id" id="team_id"
                class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="{{ $trainings->team_id }}">{{ $trainings->team_id }}</option>

            </select>
            @error('team_id')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror

                <!-- Training Title -->
        <label for="title" class="block my-2 font-medium">Training Title</label>
        <input type="text" name="title" id="" value="{{ $trainings->title }}" placeholder="Enter a Training Title" class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">



            <!-- Training Date -->
            <label for="training_date" class="block mb-2 font-medium">Training Date</label>
            <input type="datetime-local" name="training_date" id="" value="{{ $trainings->training_date }}"
                class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

            <!-- Location -->
            <div class="mt-4">
                <label for="location" class="block mb-2 font-medium">Location</label>
                <input type="text" name="location" id="location" value="{{ $trainings->location }}"
                    placeholder="Enter training location"
                    class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Focus -->
            <div class="mt-4">
                <label for="focus" class="block mb-2 font-medium">Focus</label>
                <input type="text" name="focus" id="focus" value="{{ $trainings->focus }}"
                    placeholder="Enter focus"
                    class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Submit Button -->
            <input type="submit" value="Update Training"
                class="cursor-pointer bg-blue-600 text-white px-3 py-2 rounded-lg mt-5 w-full hover:bg-white hover:text-black transition-all duration-300 hover:shadow-lg">
        </form>
    </div>

@endsection

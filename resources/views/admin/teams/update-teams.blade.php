@extends('admin.layouts.navigation')
@section('title', 'Update Teams')
@section('content')

    <div class="max-w-2xl mx-auto bg-gray-800 p-6 rounded shadow text-white">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-4">Update Teams</h1>
            <a href="{{ route('teams.show') }}"
                @click.prevent="loading = true; setTimeout(() =>{window.location.href='{{ route('teams.show') }}'},500);"
                class="hover:bg-gray-400 hover:rounded-lg hover:py-1 hover:px-2 duration-300 transition-all"><i
                    class="fas fa-arrow-left"></i></a>
        </div>
        <form action="{{ route('teams.update', $teams->id) }}" @submit="loading = true;" method="POST">
            @csrf
            @method('PUT')
            <!-- Coach Selection -->
            <label for="coach_id" class="block mb-2 font-medium">Select a Coach</label>
            <select name="coach_id" id="coach_id"
                class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
                <option value="">Select a Coach</option>
                @foreach ($coach as $c)
                    <option value="{{ $c->coach_id }}" {{ $teams->coach_id == $c->coach_id ? 'selected' : '' }}>
                        {{ $c->lname }}, {{ $c->fname }} {{ $c->mname }}
                    </option>
                @endforeach
            </select>

            <!-- Team Name -->
            <div class="mt-4">
                <label for="name" class="block mb-2 font-medium">Team Name</label>
                <input type="text" name="name" id="name" placeholder="Enter Team Name"
                    value="{{ $teams->name }}"
                    class="w-full border border-gray-600 bg-gray-700 text-white p-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <!-- Submit Button -->
            <input type="submit" value="Update Team"
                class="cursor-pointer bg-blue-600 text-white px-3 py-2 rounded-lg mt-5 w-full hover:bg-white hover:text-black transition-all duration-300 hover:shadow-lg">
        </form>
    </div>

@endsection

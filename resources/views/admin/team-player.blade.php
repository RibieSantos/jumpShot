@extends('admin.layouts.navigation')
@section('title', 'Team Players')
@section('content')
<!-- Main container - Added responsive padding and max-width for better layout on all screens -->
<div class="w-full max-w-7xl mx-auto p-4 md:p-6 lg:p-8 text-white">
    <!-- Grid layout for team cards - Adjusted column counts for better responsiveness -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($teams as $team)
            <!-- Individual Team Card - Enhanced styling and hover effects -->
            <div class="bg-gray-800 rounded-xl shadow-lg p-5 hover:shadow-xl hover:scale-105 transition-all duration-300 ease-in-out border border-gray-700">
                <!-- Coach Info Section -->
                <div class="flex items-center gap-4 mb-4">
                    <!-- Coach Image - Made circular and added border for better visual appeal -->
                    <img 
                        src="{{ $team->profile_picture ? asset('coach/' . $team->profile_picture) : asset('Images/profile.png') }}" 
                        alt="Coach Image" 
                        class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-full border-2 border-blue-500 shadow-md"
                    >
                    <!-- Coach Name and Role -->
                    <div>
                        <h3 class="text-lg md:text-xl font-semibold text-blue-300">{{ $team->coach_name }}</h3>
                        <p class="text-sm text-gray-400">Coach</p>
                    </div>
                </div>
                <!-- Team Name Section - Centered and prominent -->
                <div class="mt-4 mb-6 text-center">
                    <h2 class="text-xl md:text-2xl font-bold text-white tracking-wide">{{ $team->name }}</h2>
                </div>
                <!-- Action Buttons - Centered and styled as full-width buttons on small screens -->
                <div class="flex flex-col sm:flex-row justify-center gap-3">
                    <!-- View Player Button -->
                    <a href="{{ route('players.view',$team->id) }}" 
                    @click.prevent="loading = true; setTimeout(()=> window.location.href='{{ route('players.view',$team->id) }}',500)"
                    class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white text-sm md:text-base px-4 py-2 rounded-full transition-all duration-300 text-center font-medium">
                        View Players
                    </a>
                    <!-- Add Player Button -->
                    <a href="{{ route('players.create',$team->id) }}" 
                    @click.prevent="loading = true; setTimeout(()=> window.location.href='{{ route('players.create',$team->id) }}',500)"
                    class="w-full sm:w-auto bg-yellow-600 hover:bg-yellow-700 text-white text-sm md:text-base px-4 py-2 rounded-full transition-all duration-300 text-center font-medium">
                        Add Player
                    </a>
                </div>
            </div>
        @empty
            <!-- Message when no teams are found -->
            <div class="col-span-full text-center py-10 text-gray-400 text-lg">
                No teams found.
            </div>
        @endforelse
    </div>
</div>
@endsection
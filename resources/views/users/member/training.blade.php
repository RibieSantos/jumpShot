<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-extrabold text-blue-600 tracking-wide">My Training Sessions</h2>
            <div class="text-sm text-blue-500">
                <i class="fas fa-calendar-alt mr-1"></i> {{ now()->format('F j, Y') }}
            </div>
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if($trainings->isEmpty())
            <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-gray-200">
                <i class="fas fa-dumbbell text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-600">No Training Sessions Scheduled</h3>
                <p class="mt-1 text-sm text-gray-500">Check back later for updates</p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($trainings as $training)
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-4 py-3">
                        <h3 class="text-lg font-semibold text-white">
                            <i class="fas fa-running mr-2"></i>{{ $training->title }} - {{ $training->focus ?? 'General Training' }}
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center text-gray-600 mb-3">
                            <i class="fas fa-calendar-day text-blue-500 mr-2"></i>
                            <span>{{ $training->training_date->format('l, F j, Y') }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 mb-3">
                            <i class="fas fa-clock text-blue-500 mr-2"></i>
                            <span>{{ $training->training_date->format('g:i A') }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                            <span>{{ $training->location }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
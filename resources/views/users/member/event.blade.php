<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-calendar-alt text-blue-500 mr-2"></i> Club Events
            </h2>
            <div class="text-sm text-blue-500">
                <i class="fas fa-filter mr-1"></i> Showing {{ $events->count() }} events
            </div>
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if ($events->isEmpty())
            <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-gray-200">
                <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-600">No Upcoming Events</h3>
                <p class="mt-1 text-sm text-gray-500">Check back later for scheduled events</p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($events as $event)
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <!-- Event Image -->
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('events/' . $event->event_image) }}" alt="{{ $event->title }}"
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                            <div
                                class="absolute top-4 right-4 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                {{ \Carbon\Carbon::parse($event->event_date)->isFuture() ? 'Upcoming' : 'Past' }}
                            </div>

                        </div>
                        <!-- Event Details -->
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-gray-800">{{ $event->title }}</h3>
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('M j') }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                {{ $event->description }}
                            </p>
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <i class="fas fa-clock text-blue-500 mr-2"></i>
                                {{ \Carbon\Carbon::parse($event->event_date)->format('g:i A') }}
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                                {{ $event->location }}
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between">
                                <span class="text-xs text-gray-400">
                                    Created: {{ $event->created_at->diffForHumans() }}
                                </span>
                                {{-- <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View Details <i class="fas fa-chevron-right ml-1"></i>
                                </button> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>

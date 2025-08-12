<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold text-blue-600 tracking-wide">Dashboard</h2>
    </x-slot>

    {{-- @if ($isExpiringSoon)
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded">
        <p><strong>Reminder:</strong> Your membership will expire in less than 5 days. Please renew soon to avoid interruption.</p>
    </div>
@endif --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-8">
        <!-- Team Overview -->
        @if ($team)
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <i class="fas fa-users mr-2"></i> {{ $team->name }}
                        </h3>
                        <div class="mt-2 md:mt-0 flex space-x-2">
                            <span class="bg-blue-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                                <i class="fas fa-users mr-1"></i> {{ $team->member->count() }} Players
                            </span>

                        </div>
                    </div>
                </div>

                <div class="p-6 flex flex-col md:flex-row items-center gap-6">
                    <div class="relative">
                        @if ($team->coach->profile_picture)
                            <img src="{{ asset('coach/' . $team->coach->profile_picture) }}" alt="Coach Picture"
                                class="w-24 h-24 md:w-28 md:h-28 rounded-full object-cover border-4 border-blue-400 shadow-md">
                        @else
                            <div
                                class="w-24 h-24 md:w-28 md:h-28 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 border-4 border-blue-400">
                                <i class="fas fa-user-circle text-4xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="text-center md:text-left">
                        <h4 class="text-xl font-bold text-gray-800">Coach {{ $team->coach->user->fname }}
                            {{ $team->coach->user->mname }} {{ $team->coach->user->lname }}</h4>
                        <p class="text-gray-600 mt-1">{{ $team->coach->bio ?? 'Team Coach' }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 text-center p-8">
                <i class="fas fa-exclamation-triangle text-4xl text-red-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-600">No Team Assigned</h3>
                <p class="mt-1 text-sm text-gray-500">Please contact the administrator to be assigned to a team</p>
            </div>
        @endif
        <!-- Upcoming Event -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-calendar-star mr-2"></i> Upcoming Event
                </h3>
            </div>

            @if ($events)
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="md:w-1/3">
                            <img src="{{ asset('events/' . $events->event_image) }}" alt="{{ $events->title }}"
                                class="w-full h-48 md:h-64 object-cover rounded-lg shadow-md">
                        </div>
                        <div class="md:w-2/3">
                            <h4 class="text-xl font-bold text-gray-800 mb-2">{{ $events->title }}</h4>
                            <div class="flex items-center text-gray-600 mb-2">
                                <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                                <span>{{ $events->location }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 mb-4">
                                <i class="fas fa-clock text-blue-500 mr-2"></i>
                                <span>{{ \Carbon\Carbon::parse($events->event_date)->format('l, F j, Y \a\t g:i A') }}</span>
                            </div>
                            <p class="text-gray-700 mb-4">{{ $events->description }}</p>
                            <div class="flex space-x-3">

                                <a href="{{ route('events.downloadCalendar', $events->id) }}"
                                    class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-gray-200 hover:text-black duration-300 transition">
                                    <i class="fas fa-calendar-plus mr-2"></i> Add to Calendar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="p-8 text-center">
                    <i class="fas fa-calendar-times text-4xl text-gray-400 mb-3"></i>
                    <h4 class="text-lg font-medium text-gray-600">No Upcoming Events</h4>
                    <p class="text-gray-500 mt-1">Check back later for scheduled events</p>
                </div>
            @endif
        </div>
        <!-- Training & Events History -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Training History -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-dumbbell mr-2"></i> Recent Trainings
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Focus</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Location</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>

                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($trainingH->take(5) as $training)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        {{ $training->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        {{ $training->focus }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        {{ $training->location }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($training->training_date)->format('M j, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No training sessions recorded
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($trainingH->count() > 5)
                    <div class="px-6 py-3 bg-gray-50 text-right text-sm">
                        <a href="{{ route('viewall.traininhistory') }}"
                            @click.prevent="loading = true; setTimeout (()=> window.location.href= '{{ route('viewall.traininhistory') }}',500)"
                            class="text-blue-600 hover:text-blue-800 font-medium">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @endif

            </div>
            <!-- Events History -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-calendar-check mr-2"></i> Recent Events
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Event</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Location</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($eventsH->take(5) as $event)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ Str::limit($event->title, 20) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        {{ $event->location }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No events recorded
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($eventsH->count() > 5)
                    <div class="px-6 py-3 bg-gray-50 text-right text-sm">
                        <a href="{{ route('viewall.eventHistory') }}"
                            @click.prevent="loading = true; setTimeout (()=> window.location.href= '{{ route('viewall.eventHistory') }}',500)"
                            class="text-blue-600 hover:text-blue-800 font-medium">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-users mr-2"></i> Team Stats
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-blue-600">{{ $team?->member->count() ?? 0 }}</p>
                            <p class="text-sm text-gray-600">Players</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-green-600">{{ $trainings->count() ?? 0 }}</p>
                            <p class="text-sm text-gray-600">Trainings</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-purple-600">{{ $events->count() ?? 0 }}</p>
                            <p class="text-sm text-gray-600">Events</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-calendar-alt mr-2"></i> Next Training
                    </h3>
                </div>
                <div class="p-6">
                    @if ($nextTraining = $trainings->first())
                        <div class="flex items-center mb-2">
                            <i class="fas fa-calendar-day text-blue-500 mr-2"></i>
                            <span class="font-medium">{{ $nextTraining->training_date->format('l, F j') }}</span>
                        </div>
                        <div class="flex items-center mb-2">
                            <i class="fas fa-clock text-blue-500 mr-2"></i>
                            <span>{{ $nextTraining->training_date->format('g:i A') }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                            <span>{{ $nextTraining->location }}</span>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No upcoming trainings scheduled</p>
                    @endif
                </div>
            </div>
            {{-- <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-bullhorn mr-2"></i> Announcements
                    </h3>
                </div>
                <div class="p-6">
                    <div class="text-center py-8">
                        <i class="fas fa-bell-slash text-3xl text-gray-400 mb-3"></i>
                        <p class="text-gray-500">No new announcements</p>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>

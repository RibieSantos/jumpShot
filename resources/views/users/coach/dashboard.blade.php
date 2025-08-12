<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold text-blue-600 tracking-wide">Coach Dashboard</h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Team Overview -->
        @if ($team)
            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <div class="flex flex-col md:flex-row items-center gap-6 mb-6">
                    <!-- Coach Profile Picture -->
                    <div class="relative">
                        @if ($team->coach->profile_picture)
                            <img src="{{ asset('coach/' . $team->coach->profile_picture) }}" alt="Coach Picture"
                                class="w-24 h-24 md:w-28 md:h-28 rounded-full object-cover border-4 border-blue-400">
                        @else
                            <div
                                class="w-24 h-24 md:w-28 md:h-28 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                <i class="fas fa-user-circle text-4xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="text-center md:text-left">
                        <h3 class="text-xl font-bold text-gray-800">Team: <span
                                class="text-blue-600">{{ $team->name }}</span></h3>
                        <p class="text-md text-gray-700">Coach: {{ $team->coach->user->fname }}
                            {{ $team->coach->user->mname ?? '' }} {{ $team->coach->user->lname }}</p>
                        <div class="mt-2 text-sm text-gray-600">
                            <span class="mr-3"><i class="fas fa-users mr-1"></i> {{ $team->member->count() }}
                                Players</span>
                            <span><i class="fas fa-dumbbell mr-1"></i> {{ $team->training->count() }} Trainings</span>
                        </div>
                    </div>
                </div>
                <!-- Team Members -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3"><i class="fas fa-users mr-2 text-blue-500"></i>
                        Team Members</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @forelse ($team->member as $member)
                            <div class="bg-gray-50 rounded-md p-3">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                            <i class="fas fa-user text-sm"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">
                                            {{ $member->user->fname }} {{ $member->user->lname }}
                                        </p>
                                        @if ($member->position)
                                            <p class="text-xs text-gray-500">{{ $member->position }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500"><i class="fas fa-info-circle mr-2"></i> No players assigned to this
                                team</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 text-center">
                <div class="text-red-500 mb-3">
                    <i class="fas fa-exclamation-triangle text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">No Team Assigned</h3>
                <p class="text-gray-600">You are not currently assigned to any team</p>
            </div>
        @endif
        <!-- Upcoming Event -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
            <div class="bg-blue-600 px-4 py-3">
                <h3 class="text-lg font-semibold text-white"><i class="fas fa-calendar-day mr-2"></i> Upcoming Event
                </h3>
            </div>
            <div class="p-4">
                @if ($events)
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="md:w-1/3">
                            <img src="{{ asset('storage/events/' . $events->event_image) }}" alt="{{ $events->title }}"
                                class="w-full h-40 object-cover rounded-md">
                        </div>
                        <div class="md:w-2/3">
                            <h4 class="text-lg font-medium text-gray-800 mb-1">{{ $events->title }}</h4>
                            <p class="text-sm text-gray-600 mb-2">
                                <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i> {{ $events->location }}
                            </p>
                            <p class="text-sm text-gray-600 mb-3">
                                <i class="fas fa-clock mr-1 text-blue-500"></i>
                                {{ \Carbon\Carbon::parse($events->event_date)->format('F j, Y g:i A') }}
                            </p>
                            <p class="text-gray-700 text-sm">{{ $events->description }}</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-6">
                        <div class="text-gray-400 mb-2">
                            <i class="fas fa-calendar-times text-3xl"></i>
                        </div>
                        <p class="text-gray-600">No upcoming events scheduled</p>
                    </div>
                @endif
            </div>
        </div>
        <!-- Training History -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
            <div class="bg-blue-600 px-4 py-3">
                <h3 class="text-lg font-semibold text-white"><i class="fas fa-dumbbell mr-2"></i> Recent Trainings</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Focus</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($trainingH as $th)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
                                    {{ $th->title }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
                                    {{ $th->focus }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
                                    {{ $th->location }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
                                    {{ \Carbon\Carbon::parse($th->training_date)->format('M j, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-sm text-gray-500">
                                    No training sessions recorded
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Events History -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
            <div class="bg-blue-600 px-4 py-3">
                <h3 class="text-lg font-semibold text-white"><i class="fas fa-calendar-check mr-2"></i> Recent Events
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($eventsH as $eh)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
                                    {{ $eh->title }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
                                    {{ $eh->description }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
                                    {{ $eh->location }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
                                    {{ \Carbon\Carbon::parse($eh->event_date)->format('M j, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-sm text-gray-500">
                                    No events recorded
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold text-blue-600 tracking-wide">My Team</h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if ($team)
            <!-- Team Header -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8 border border-gray-200">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-users mr-2"></i> {{ $team->name }}
                    </h3>
                </div>

                <!-- Coach Info -->
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
                        <span
                            class="absolute -bottom-2 -right-2 bg-yellow-400 text-gray-900 text-xs font-bold px-2 py-1 rounded-full">COACH</span>
                    </div>
                    <div class="text-center md:text-left">
                        <h4 class="text-xl font-bold text-gray-800">{{ $team->coach->user->fname }}
                            {{ $team->coach->user->mname }} {{ $team->coach->user->lname }}</h4>
                        <p class="text-gray-600 mt-1">{{ $team->coach->bio ?? 'Team Coach' }}</p>
                        <div class="mt-3 flex flex-wrap gap-2 justify-center md:justify-start">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                <i class="fas fa-users mr-1"></i> {{ $team->member->count() }} Players
                            </span>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Team Roster -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-list-ol mr-2"></i> Team Roster
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    #</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Player</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Position</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($team->member as $index => $member)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if ($member->profile_picture)
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ asset('member/' . $member->profile_picture) }}"
                                                        alt="{{ $member->user->fname }}">
                                                @else
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $member->user->fname }} {{ $member->user->mname }}
                                        {{ $member->user->lname }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $member->position ?? 'Player' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No players in this team yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-gray-200">
                <i class="fas fa-exclamation-triangle text-4xl text-red-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-600">No Team Assigned</h3>
                <p class="mt-1 text-sm text-gray-500">Please contact the administrator to be assigned to a team</p>
                <button
                    class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="fas fa-envelope mr-2"></i> Contact Admin
                </button>
            </div>
        @endif
    </div>
</x-app-layout>

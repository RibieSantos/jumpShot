@extends('admin.layouts.navigation')
@section('title', 'View Players Page')
@section('content')
    <!-- Main Container - Added responsive padding and shadow -->
    <div class="max-w-7xl mx-auto bg-gray-800 p-4 md:p-6 rounded-lg shadow-lg text-white">
        <!-- Top Section: Coach and Search - Improved mobile layout -->
        <div class="flex flex-col md:flex-row justify-between gap-4 md:gap-6 items-start md:items-center mb-6">
            <!-- Coach Info - Better spacing and alignment -->
            @if ($teamInfo)
                <div class="flex items-center gap-4">
                    <img src="{{ $teamInfo->coach_profile ? asset('coach/' . $teamInfo->coach_profile) : asset('Images/profile.png') }}"
                        alt="Coach Image" 
                        class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-full border-2 border-blue-500 shadow-md" />
                    <div>
                        <h2 class="text-lg md:text-2xl font-bold">{{ $teamInfo->coach_name }}</h2>
                        <p class="text-sm text-gray-300">
                            Coach of <span class="text-white font-semibold">{{ $teamInfo->team_name }}</span>
                        </p>
                    </div>
                </div>
            @endif
            
            <!-- Search and Back Button - Better grouping -->
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <!-- Search Bar - Improved mobile layout -->
                <form method="GET" action="{{ route('players.view', $team_id) }}" @submit="loading = true;"
                    class="flex-1 flex flex-col sm:flex-row gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search players..."
                        class="border border-gray-600 p-2 rounded bg-gray-700 text-white placeholder-gray-400 w-full focus:ring-2 focus:ring-blue-500">
                    <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition whitespace-nowrap">
                        Search
                    </button>
                </form>
                
                <!-- Back Button - Improved styling -->
                <a href="{{ route('players.show') }}"
                    @click.prevent="loading = true; setTimeout(() =>{window.location.href='{{ route('players.show') }}'},500);"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded transition flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-left"></i>
                    <span class="hidden sm:inline">Back</span>
                </a>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('success'))
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "{{ session('success') }}"
                    });
                @endif
            });
        </script>
        <!-- Players Table - Added border and better scrolling -->
        <div class="overflow-x-auto rounded-lg border border-gray-700">
            <table class="min-w-full divide-y divide-gray-700 text-sm text-left">
                <thead class="bg-gray-700 text-gray-300">
                    <tr>
                        @foreach (['teamplayer_id' => 'ID', 'member_profile' => 'Profile', 'member_name' => 'Player Name', 'Action'] as $key => $column)
                            <th class="px-4 py-3 font-medium whitespace-nowrap">
                                <!-- Sortable headers with better spacing -->
                                <a href="{{ route('players.view', ['team_id' => $team_id, 'sort' => $key, 'direction' => $sortField === $key && $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
                                    @click.prevent="loading = true; setTimeout(()=> window.location.href = '{{ route('players.view', ['team_id' => $team_id, 'sort' => $key, 'direction' => $sortField === $key && $sortOrder === 'asc' ? 'desc' : 'asc']) }}')"
                                    class="hover:underline flex items-center justify-center gap-1">
                                    {{ $column }}
                                    @if ($sortField === $key)
                                        {{ $sortOrder === 'asc' ? '↑' : '↓' }}
                                    @endif
                                </a>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @php
                        $filteredPlayers = $players->where('team_id', $team_id);
                    @endphp
                    @if ($filteredPlayers->isNotEmpty())
                        @foreach ($filteredPlayers as $player)
                            <tr class="hover:bg-gray-700">
                                <!-- Table Cells - Responsive padding -->
                                <td class="px-4 py-3">{{ $player->teamplayer_id }}</td>
                                <td class="px-4 py-3">
                                    <img src="{{ $player->member_profile ? asset('member/' . $player->member_profile) : asset('Images/profile.png') }}"
                                        class="w-12 h-12 md:w-14 md:h-14 object-cover rounded-full mx-auto border border-gray-600"
                                        alt="{{ $player->player_name }}'s profile">
                                </td>
                                <td class="px-4 py-3 capitalize">{{ $player->player_name }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-2">
                                        <!-- Delete Button - Improved confirmation dialog -->
                                        <form method="POST"
                                            action="{{ route('players.destroy', [$player->team_id, $player->teamplayer_id]) }}"
                                            @submit.prevent="Swal.fire({
                                                title: 'Delete Player?',
                                                text: 'Are you sure you want to remove this player from the team?',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#3085d6',
                                                confirmButtonText: 'Yes, remove'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $el.submit();
                                                }
                                            })">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-400 hover:bg-red-500 hover:text-white p-2 rounded-md transition"
                                                title="Remove player">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-400">No players found in this team.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <!-- Pagination - Centered and responsive -->
        <div class="mt-6 flex justify-center">
            {{ $players->appends(request()->input())->links() }}
        </div>
    </div>
@endsection
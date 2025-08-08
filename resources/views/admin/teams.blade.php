@extends('admin.layouts.navigation')
@section('title', 'Teams Page')
@section('content')
    <!-- Main Container - Added responsive padding and shadow -->
    <div class="max-w-6xl mx-auto bg-gray-800 p-4 md:p-6 rounded-lg shadow-lg text-white">
        <h1 class="text-xl md:text-2xl font-bold mb-4">Teams Table</h1>
        <!-- Search Bar - Improved mobile layout -->
        <div class="flex flex-col sm:flex-row justify-between gap-4 mb-4">
            <div class="w-full sm:w-auto sm:flex-1">
                <form method="GET" action="{{ route('teams.show') }}" @submit="loading = true;">
                    <div class="flex flex-col sm:flex-row gap-2">
                        <!-- Search input - Full width on mobile -->
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                            class="border border-gray-600 p-2 rounded w-full sm:w-64 bg-gray-700 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition whitespace-nowrap">
                            Search
                        </button>
                    </div>
                </form>
            </div>
            <!-- Add Teams Button - Better mobile sizing -->
            <div>
                <a href="{{ route('teams.create') }}"
                    @click.prevent="loading = true; setTimeout(()=>{window.location.href='{{ route('teams.create') }}'},500)"
                    class="bg-blue-600 px-3 py-2 md:px-4 md:py-3 rounded-lg font-bold text-white hover:bg-white hover:text-black hover:shadow-md transition-all duration-300 text-sm md:text-base inline-block">
                    Add Teams
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
        <!-- Table Container - Added border and better scrolling -->
        <div class="overflow-x-auto rounded-lg border border-gray-700">
            <table class="min-w-full divide-y divide-gray-700 text-sm text-left">
                <thead class="bg-gray-700 text-center text-gray-300">
                    <tr>
                        @foreach (['id', 'coach_name' => 'Coach Name', 'name' => 'Team Name', 'action'] as $key => $column)
                            <th class="px-3 py-2 md:px-4 md:py-2 font-medium whitespace-nowrap">
                                <!-- Sortable headers with better spacing -->
                                <a href="{{ route('teams.show', ['sort' => $key, 'direction' => $sortField === $key && $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
                                    class="hover:underline flex items-center justify-center gap-1">
                                    {{ is_string($key) ? $column : ucfirst(str_replace('_', ' ', $column)) }}
                                    @if ($sortField === $key)
                                        {{ $sortOrder === 'asc' ? '↑' : '↓' }}
                                    @endif
                                </a>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 text-center">
                    @forelse ($teams as $team)
                        <tr class="hover:bg-gray-700 transition">
                            <!-- Table Cells - Responsive padding and truncation for long content -->
                            <td class="px-3 py-2 md:px-4 md:py-2">{{ $team->team_id }}</td>
                            <td class="px-3 py-2 md:px-4 md:py-2 capitalize truncate max-w-[150px] mx-auto">{{ $team->coach_name }}</td>
                            <td class="px-3 py-2 md:px-4 md:py-2 truncate max-w-[150px] mx-auto">{{ $team->name }}</td>
                            <!-- Action Buttons - Better spacing and hover states -->
                            <td class="px-3 py-2 md:px-4 md:py-2">
                                <div class="flex justify-center items-center gap-2 md:gap-3">
                                    <!-- Edit Button -->
                                    <a href="{{ route('teams.edit', $team->team_id) }}"
                                        @click.prevent="loading = true; setTimeout(() =>{window.location.href='{{ route('teams.edit', $team->team_id) }}'},500);"
                                        class="text-green-400 hover:bg-green-500 hover:text-white p-2 rounded-md transition">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <!-- Delete Button - Improved confirmation dialog -->
                                    <form action="{{ route('teams.destroy', $team->team_id) }}"
                                        @submit.prevent="Swal.fire({
                                            title: 'Delete Team?',
                                            text: 'Do you want to delete this team? This action cannot be undone.',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Yes, delete it!'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $el.submit();
                                            }
                                        })">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:bg-red-500 hover:text-white p-2 rounded-md transition">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-400">No teams found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination - Centered and responsive -->
        <div class="mt-4 flex justify-center">
            {{ $teams->appends(request()->input())->links() }}
        </div>
    </div>
@endsection
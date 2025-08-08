@extends('admin.layouts.navigation')
@section('title', 'Coaches Page')
@section('content')
    <!-- Main Container - Responsive padding and shadow -->
    <div class="max-w-6xl mx-auto bg-gray-800 p-4 md:p-6 rounded-lg shadow-lg text-white">
        <h1 class="text-xl md:text-2xl font-bold mb-4">Coaches Table</h1>
        <!-- Search Bar - Improved mobile layout -->
        <div class="flex flex-col sm:flex-row justify-between gap-4 mb-4">
            <div class="w-full sm:w-auto sm:flex-1">
                <form method="GET" action="{{ route('coach.show') }}" @submit="loading = true;">
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
            <!-- Add Coach Button - Better mobile sizing -->
            <div>
                <a href="{{ route('coach.create') }}"
                    @click.prevent="loading = true; setTimeout(() => {window.location.href = '{{ route('coach.create') }}'}, 500);"
                    class="bg-blue-600 px-3 py-2 md:px-4 md:py-3 rounded-lg font-bold text-white hover:bg-white hover:text-black hover:shadow-md transition-all duration-300 text-sm md:text-base inline-block">
                    Add Coach
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
                        @foreach (['id', 'profile_picture', 'coach_name' => 'Coach Name', 'level_experience', 'bio', 'action'] as $key => $column)
                            <th class="px-3 py-2 md:px-4 md:py-2 font-medium whitespace-nowrap">
                                <!-- Sortable headers with better spacing -->
                                <a href="{{ route('coach.show', ['sort' => $key, 'direction' => $sortField === $key && $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
                                    class="hover:underline flex items-center justify-center gap-1">
                                    {{ is_string($column) ? $column : 'ID' }}
                                    @if ($sortField === $key)
                                        {{ $sortOrder === 'asc' ? '↑' : '↓' }}
                                    @endif
                                </a>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 text-center">
                    @forelse ($coach as $coaches)
                        <tr class="hover:bg-gray-700">
                            <!-- Table Cells - Responsive padding -->
                            <td class="px-3 py-2 md:px-4 md:py-2">{{ $coaches->id }}</td>
                            @if ($coaches->profile_picture == null)
                                <td class="px-3 py-2 md:px-4 md:py-2">
                                    <!-- Profile Image - Circular and responsive -->
                                    <img src="{{ asset('Images/profile.png') }}" class="w-16 h-16 md:w-20 md:h-20 rounded-full object-cover" alt="">
                                </td>
                            @else
                                <td class="px-3 py-2 md:px-4 md:py-2">
                                    <img src="{{ asset('coach/'.$coaches->profile_picture) }}" class="w-16 h-16 md:w-20 md:h-20 rounded-full object-cover" alt="">
                                </td>
                            @endif
                            <!-- Coach Data - Truncate for long names -->
                            <td class="px-3 py-2 md:px-4 md:py-2 capitalize truncate max-w-[150px] mx-auto">{{ $coaches->coach_name }}</td>
                            <td class="px-3 py-2 md:px-4 md:py-2">{{ $coaches->experience_level }}</td>
                            <!-- Bio - Limited height with scroll -->
                            <td class="px-3 py-2 md:px-4 md:py-2 max-w-[200px] max-h-20 overflow-y-auto text-sm">
                                {{ $coaches->bio }}
                            </td>
                            <!-- Action Buttons - Better spacing -->
                            <td class="px-3 py-2 md:px-4 md:py-2">
                                <div class="flex justify-center items-center gap-2 md:gap-3">
                                    <!-- Edit Button - Better hover state -->
                                    <a href="{{ route('coach.edit', $coaches->id) }}"
                                        @click.prevent="loading = true; setTimeout(() => {window.location.href = '{{ route('coach.edit', $coaches->id) }}'}, 500);"
                                        class="text-green-400 hover:bg-green-500 hover:text-white p-2 rounded-md transition">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <!-- Delete Button - Improved confirmation dialog -->
                                    <form method="POST" action="{{ route('coach.destroy', $coaches->id) }}"
                                        x-data="{ showConfirm: false }"
                                        @submit.prevent="Swal.fire({
                                            title: 'Delete Coach?',
                                            text: 'This will permanently remove all coach data.',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Yes, delete!',
                                            cancelButtonText: 'Cancel'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $el.submit();
                                            }
                                        })">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:bg-red-600 hover:text-white p-2 rounded-md transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-400">No coaches found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination - Centered and responsive -->
        <div class="mt-4 flex justify-center">
            {{ $coach->appends(request()->input())->links() }}
        </div>
    </div>
@endsection
@extends('admin.layouts.navigation')
@section('title', 'Training Page')
@section('content')
    <!-- Main Container - Added responsive padding and shadow -->
    <div class="max-w-6xl mx-auto bg-gray-800 p-4 md:p-6 rounded-lg shadow-lg text-white">
        <h1 class="text-xl md:text-2xl font-bold mb-4">Trainings Table</h1>
        <!-- Search Bar - Improved mobile layout -->
        <div class="flex flex-col sm:flex-row justify-between gap-4 mb-4">
            <form method="GET" action="{{ route('trainings.show') }}" @submit="loading = true;" class="w-full sm:flex-1">
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
            <!-- Add Training Button - Better mobile sizing -->
            <div>
                <a href="{{ route('trainings.create') }}"
                    @click.prevent="loading = true; setTimeout(() => {window.location.href='{{ route('trainings.create') }}'},500)"
                    class="bg-blue-600 px-3 py-2 md:px-4 md:py-3 rounded-lg font-bold text-white hover:bg-white hover:text-black hover:shadow-md transition-all duration-300 text-sm md:text-base inline-block">
                    Add Training
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
                        @foreach (['id', 'name'=> 'Team Name', 'title', 'training_date', 'location', 'focus', 'action'] as $column)
                            <th class="px-3 py-2 md:px-4 md:py-2 font-medium whitespace-nowrap">
                                <!-- Sortable headers with better spacing -->
                                <a href="{{ route('trainings.show', ['sort' => $column, 'direction' => $sortField === $column && $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
                                    class="hover:underline flex items-center justify-center gap-1">
                                    {{ ucfirst(str_replace('_', ' ', $column)) }}
                                    @if ($sortField === $column)
                                        {{ $sortOrder === 'asc' ? '↑' : '↓' }}
                                    @endif
                                </a>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 text-center">
                    @forelse ($training as $item)
                        <tr class="hover:bg-gray-700">
                            <!-- Table Cells - Responsive padding -->
                            <td class="px-3 py-2 md:px-4 md:py-2">{{ $item->id }}</td>
                            <td class="px-3 py-2 md:px-4 md:py-2 truncate max-w-[120px] mx-auto">{{ $item->name }}</td>
                            <td class="px-3 py-2 md:px-4 md:py-2 truncate max-w-[150px] mx-auto">{{ $item->title }}</td>
                            <!-- Date - Better formatting and whitespace -->
                            <td class="px-3 py-2 md:px-4 md:py-2 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($item->training_date)->format('F j, Y g:iA') }}
                            </td>
                            <td class="px-3 py-2 md:px-4 md:py-2 truncate max-w-[120px] mx-auto">{{ $item->location }}</td>
                            <td class="px-3 py-2 md:px-4 md:py-2 truncate max-w-[120px] mx-auto">{{ $item->focus }}</td>
                            <!-- Action Buttons - Better spacing and hover states -->
                            <td class="px-3 py-2 md:px-4 md:py-2">
                                <div class="flex justify-center items-center gap-2 md:gap-3">
                                    <!-- Edit Button -->
                                    <a href="{{ route('trainings.edit', $item->id) }}"
                                        @click.prevent="loading = true; setTimeout(() => {window.location.href='{{ route('trainings.edit', $item->id) }}'},500)"
                                        class="text-green-400 hover:bg-green-500 hover:text-white p-2 rounded-md transition">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <!-- Delete Button - Improved confirmation dialog -->
                                    <form action="{{ route('trainings.destroy', $item->id) }}"
                                        @click.prevent="Swal.fire({
                                            title: 'Delete Training?',
                                            text: 'This will permanently remove the training record.',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Yes, delete!'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $el.submit();
                                            }
                                        })"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:bg-red-500 hover:text-white p-2 rounded-md transition">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                    <!-- Done Button - Better visual feedback -->
                                    <form action="{{ route('trainings.done',$item->id) }}" @submit="loading = true;" method="POST">
                                        @csrf
                                        <input type="text" name="training_date" value="{{ $item->training_date }}" hidden>
                                        <input type="text" name="title" value="{{ $item->title }}" hidden>
                                        <input type="text" name="location" value="{{ $item->location }}" hidden>
                                        <input type="text" name="focus" value="{{ $item->focus }}" hidden>
                                        <button type="submit" 
                                            class="text-yellow-400 hover:bg-blue-500 hover:text-white p-2 rounded-md transition"
                                            title="Mark as completed">
                                            <i class="fas fa-check-to-slot"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-gray-400">No trainings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination - Centered and responsive -->
        <div class="mt-4 flex justify-center">
            {{ $training->appends(request()->input())->links() }}
        </div>
    </div>
@endsection
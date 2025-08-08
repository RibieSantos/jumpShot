@extends('admin.layouts.navigation')
@section('title', 'Event History Page')
@section('content')
    <!-- Main Container - Added responsive padding and shadow -->
    <div class="max-w-6xl mx-auto bg-gray-800 p-4 md:p-6 rounded-lg shadow-lg text-white">
        <h1 class="text-xl md:text-2xl font-bold mb-4">Event History Table</h1>
        <!-- Search Bar - Improved mobile layout -->
        <div class="flex flex-col sm:flex-row justify-between gap-4 mb-4">
            <form method="GET" action="{{ route('eventsHistory.show') }}" @submit="loading = true;" class="w-full sm:flex-1">
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
            <!-- No "Add" button needed for history, so this div is empty or can be removed if not used for other elements -->
            <div>
                <!-- This space can be used for other elements if needed, otherwise it can be removed -->
            </div>
        </div>
        @if (session('success'))
            <!-- Success message - Added responsive padding and margin -->
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                class="bg-green-500 text-white p-3 md:p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <!-- Table Container - Added border and better scrolling -->
        <div class="overflow-x-auto rounded-lg border border-gray-700">
            <table class="min-w-full divide-y divide-gray-700 text-sm text-left">
                <thead class="bg-gray-700 text-center text-gray-300">
                    <tr>
                        @foreach (['id', 'title', 'description', 'location', 'event_date'] as $column)
                            <th class="px-3 py-2 md:px-4 md:py-2 font-medium whitespace-nowrap">
                                <!-- Sortable headers with better spacing -->
                                <a href="{{ route('eventsHistory.show', ['sort' => $column, 'direction' => $sortField === $column && $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
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
                    @forelse ($event as $item)
                        <tr class="hover:bg-gray-700">
                            <!-- Table Cells - Responsive padding and truncation for long content -->
                            <td class="px-3 py-2 md:px-4 md:py-2">{{ $item->id }}</td>
                            <td class="px-3 py-2 md:px-4 md:py-2 truncate max-w-[150px] mx-auto">{{ $item->title }}</td>
                            <!-- Description - Limited height with scroll -->
                            <td class="px-3 py-2 md:px-4 md:py-2 max-w-[200px] max-h-20 overflow-y-auto text-sm">
                                {{ $item->description }}
                            </td>
                            <td class="px-3 py-2 md:px-4 md:py-2 truncate max-w-[120px] mx-auto">{{ $item->location }}</td>
                            <!-- Date - Better formatting and whitespace -->
                            <td class="px-3 py-2 md:px-4 md:py-2 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($item->event_date)->format('F j, Y g:iA') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-400">No event history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination - Centered and responsive -->
        <div class="mt-4 flex justify-center">
            {{ $event->appends(request()->input())->links() }}
        </div>
    </div>
@endsection
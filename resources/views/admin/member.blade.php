@extends('admin.layouts.navigation')
@section('title', 'Member Page')
@section('content')
    <!-- Main Container - Added responsive padding and max-width constraints -->
    <div class="max-w-6xl mx-auto bg-gray-800 p-4 md:p-6 rounded shadow text-white">
        <h1 class="text-xl md:text-2xl font-bold mb-4">Members Table</h1>
        <!-- Search Bar - Made fully responsive with flex-wrap -->
        <div class="flex flex-wrap justify-between items-center gap-4 mb-4">
            <div class="w-full md:w-auto md:flex-1">
                <form method="GET" action="{{ route('members.show') }}" @submit="loading = true;">
                    <div class="flex flex-col sm:flex-row gap-2">
                        <!-- Search input - Full width on mobile, half on desktop -->
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                            class="border border-gray-600 p-2 rounded w-full sm:w-1/2 bg-gray-700 text-white placeholder-gray-400">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition whitespace-nowrap">
                            Search
                        </button>
                    </div>
                </form>
            </div>
            <!-- Add Member Button - Adjusted padding for better mobile appearance -->
            <div>
                <a href="{{ route('member.create') }}"
                    @click.prevent="loading = true; setTimeout(() => { window.location.href = '{{ route('member.create') }}' }, 500);"
                    class="bg-blue-600 px-3 py-2 md:px-4 md:py-3 rounded-lg font-bold text-white hover:bg-white hover:text-black hover:shadow-md transition-all duration-300 text-sm md:text-base">
                    Add member
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
        <!-- Table Container - Added horizontal scroll on small screens -->
        <div class="overflow-x-auto rounded-lg border border-gray-700">
            <table class="min-w-full divide-y divide-gray-700 text-sm text-left">
                <thead class="bg-gray-700 text-center text-gray-300">
                    <tr>
                        @foreach ([
                            'id' => 'ID',
                            'profile_picture' => 'Profile Picture',
                            'member_name' => 'Member Name',
                            'birthdate' => 'Birthdate',
                            'age' => 'Age',
                            'address' => 'Address',
                            'contact_number' => 'Contact Number',
                            // 'membership_start_date' => 'Start Date',
                            // 'membership_expiration_date' => 'Expiration Date',
                            'action' => 'Action',
                        ] as $key => $column)
                            <th class="px-3 py-2 md:px-4 md:py-2 font-medium whitespace-nowrap">
                                <!-- Sortable headers - Added whitespace-nowrap to prevent wrapping -->
                                <a href="{{ route('members.show', ['sort' => $key, 'direction' => $sortField === $key && $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
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
                <tbody class="divide-y divide-gray-700 text-center">
                    @forelse ($member as $members)
                        <tr class="hover:bg-gray-700">
                            <!-- Table Cells - Reduced padding on mobile -->
                            <td class="px-3 py-2 md:px-4 md:py-2">{{ $members->id }}</td>
                            @if ($members->profile_picture == null)
                                <td class="px-3 py-2 md:px-4 md:py-2">
                                    <!-- Profile Image - Made slightly smaller on mobile -->
                                    <img src="{{ asset('Images/profile.png') }}" class="w-16 h-16 md:w-20 md:h-20 rounded-full object-cover" alt="">
                                </td>
                            @else
                                <td class="px-3 py-2 md:px-4 md:py-2">
                                    <img src="{{ asset('member/' . $members->profile_picture) }}"
                                        class="w-16 h-16 md:w-20 md:h-20 rounded-full object-cover" alt="">
                                </td>
                            @endif
                            <!-- Member Data - Added truncate for long names -->
                            <td class="px-3 py-2 md:px-4 md:py-2 capitalize ">{{ $members->member_name }}</td>
                            <td class="px-3 py-2 md:px-4 md:py-2 whitespace-nowrap">{{ $members->birthdate }}</td>
                            <td class="px-3 py-2 md:px-4 md:py-2">{{ $members->age }}</td>
                            <td class="px-3 py-2 md:px-4 md:py-2  max-w-[120px]">{{ $members->address }}</td>
                            <td class="px-3 py-2 md:px-4 md:py-2 whitespace-nowrap">{{ $members->contact_number }}</td>
                            {{-- <td class="px-3 py-2 md:px-4 md:py-2 whitespace-nowrap">{{ $members->membership_start_date }}</td>
                            <td class="px-3 py-2 md:px-4 md:py-2 whitespace-nowrap">{{ $members->membership_expiration_date }}</td> --}}
                            <!-- Action Buttons - Adjusted spacing for mobile -->
                            <td class="px-3 py-2 md:px-4 md:py-2">
                                <div class="flex justify-center items-center gap-2 md:gap-3">
                                    <a href="{{ route('member.edit', $members->id) }}"
                                        @click.prevent="loading = true; setTimeout(() => { window.location.href='{{ route('member.edit', $members->id) }}' }, 500)"
                                        class="text-green-400 hover:text-green-500 transition text-lg">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('member.destroy', $members->id) }}" x-data="{ showConfirm: false }"
                                        @submit.prevent="Swal.fire({
                                            title: 'Are you sure?',
                                            text: 'This action cannot be undone.',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Yes, delete it!'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $el.submit();
                                            }
                                        })"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-500 transition text-lg">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-2 text-center text-gray-400">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination - Centered and responsive -->
        <div class="mt-4 flex justify-center">
            {{ $member->appends(request()->input())->links() }}
        </div>
    </div>
@endsection
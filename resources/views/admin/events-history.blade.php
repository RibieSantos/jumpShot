@extends('admin.layouts.navigation')
@section('title', 'Users Page')
@section('content')

    <div class="max-w-6xl mx-auto bg-gray-800 text-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Users Table</h1>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('user.show') }}" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                class="border border-gray-600 p-2 rounded w-1/3 bg-gray-700 text-white placeholder-gray-400">
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Search</button>
        </form>
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-600 text-sm text-left">
                <thead class="bg-gray-700 text-center text-gray-300">
                    <tr>
                        @foreach (['id', 'fname' => 'First Name', 'Middle Name', 'Last Name', 'email', 'role', 'action'] as $column)
                            <th class="px-4 py-2 font-medium">
                                <a href="{{ route('user.show', ['sort' => $column, 'direction' => $sortField === $column && $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
                                    class="hover:underline">
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
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-700">
                            <td class="px-4 py-2">{{ $user->id }}</td>
                            <td class="px-4 py-2">{{ $user->fname }}</td>
                            <td class="px-4 py-2">{{ $user->mname }}</td>
                            <td class="px-4 py-2">{{ $user->lname }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->role }}</td>
                            <td class="px-4 py-2">
                                <div class="flex justify-center items-center gap-3">

                                    <a href="{{ route('user.edit', $user->id) }}"
                                        @click.prevent="loading = true; setTimeout(() => {window.location.href = '{{ route('user.edit', $user->id) }}'}, 500);"
                                        class="text-green-400 hover:text-green-500 transition">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="#">
                                        <button type="submit" class="text-red-400 hover:text-red-500 transition">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-2 text-center text-gray-400">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->appends(request()->input())->links() }}
        </div>
    </div>

@endsection

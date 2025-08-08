<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('title', 'Jumpshot Basketball Club') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('Images/IMG_0017.PNG') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" x-data="{ loading: false }">
    <div x-show="loading" x-transition
            class="fixed inset-0 bg-black bg-opacity-75 flex flex-col items-center justify-center z-50 space-y-6">

            <!-- Spinning and Bouncing Ball -->
            <div
                class="w-16 h-16 rounded-full animate-spin border-4 border-white border-t-transparent flex items-center justify-center shadow-lg ">
                <i class="fas fa-basketball text-white text-5xl"></i>
            </div>

            <!-- Loading Text -->
            <div class="text-white text-lg animate-pulse">
                Loading... Please wait
            </div>

        </div>
    <div class="min-h-screen bg-gray-100">

        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 mt-4">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4 flex items-center justify-between">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-calendar-check mr-2"></i> Recent Events
                </h3>
                <a href="{{ route('dashboard') }}"
                    @click.prevent="loading = true; setTimeout (()=> window.location.href= '{{ route('dashboard') }}',500)"
                    class="text-white px-3 py-1 hover:bg-white hover:text-black rounded-lg cursor-pointer transition">
                    <i class="fas fa-angle-left"></i>
                </a>
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
                                Description</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Location</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($eventH as $event)
                            <tr class="hover:bg-blue-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $event->title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $event->description }}
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

        </div>


    </div>
</body>

</html>

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
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased" x-data="{loading: false}">
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
                {{ $slot }}
        </div>
    </body>
</html>

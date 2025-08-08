<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Default Title')</title>
    <link rel="icon" type="image/png" href="{{ asset('Images/logo.jpg') }}">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    {{-- Sweetalert 2 --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    
    <style>
        /* Custom scrollbar styling */
        .custom-scroll {
            scrollbar-width: thin;
            scrollbar-color: #4b5563 #1f2937;
        }
        
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        .custom-scroll::-webkit-scrollbar-track {
            background: #1f2937;
            border-radius: 3px;
        }
        
        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #4b5563;
            border-radius: 3px;
            border: 1px solid #1f2937;
        }
        
        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background-color: #6b7280;
        }
        
        /* Smooth scrolling */
        .custom-scroll {
            scroll-behavior: smooth;
        }
        
        /* Hide scrollbar when not needed */
        .custom-scroll {
            -webkit-overflow-scrolling: touch;
            overflow-y: scroll;
            scrollbar-gutter: stable;
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen flex" x-data="{ loading: false, sidebarOpen: false }">
    <!-- Loading Spinner -->
    <div x-show="loading" x-transition
        class="fixed inset-0 bg-black bg-opacity-75 flex flex-col items-center justify-center z-50 space-y-6">
        <div
            class="w-16 h-16 rounded-full animate-spin border-4 border-white border-t-transparent flex items-center justify-center shadow-lg">
            <i class="fas fa-basketball text-white text-5xl"></i>
        </div>
        <div class="text-white text-lg animate-pulse">
            Loading... Please wait
        </div>
    </div>
    
    <!-- Sidebar (Fixed on Desktop, Slide on Mobile) -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed z-40 md:translate-x-0 md:flex flex-col w-64 bg-gray-800 border-r border-gray-700 shadow-lg h-full transform transition-transform duration-300 ease-in-out">
        <!-- Sidebar Header -->
        <div class="p-6 font-bold text-2xl border-b border-gray-700 bg-gradient-to-r from-blue-900 to-gray-900 flex items-center">
            <img src="{{ asset('Images/IMG_0016.PNG') }}" class="h-10 w-10 rounded-full mr-3" alt="Logo">
            <span class="text-yellow-400">jump<span class="text-blue-400">S</span>hot</span>
        </div>
        
        <!-- Navigation Menu with Custom Scroll -->
        <nav class="flex-1 p-4 space-y-1 text-sm font-medium overflow-y-auto custom-scroll">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
                @click.prevent="loading = true; setTimeout(() => { window.location.href = '{{ route('admin.dashboard') }}' }, 500);"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 hover:bg-gray-700 hover:shadow-md hover:translate-x-1 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 shadow-md' : '' }}">
                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center mr-3">
                    <i class="fas fa-chart-line text-white text-sm"></i>
                </div>
                <span>Dashboard</span>
            </a>
            <!-- Members -->
            <a href="{{ route('members.show') }}"
                @click.prevent="loading = true; setTimeout(() => { window.location.href = '{{ route('members.show') }}' }, 500);"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 hover:bg-gray-700 hover:shadow-md hover:translate-x-1 {{ request()->routeIs('members.show*') ? 'bg-gray-700 shadow-md' : '' }}">
                <div class="w-8 h-8 rounded-full bg-yellow-500 flex items-center justify-center mr-3">
                    <i class="fas fa-users text-white text-sm"></i>
                </div>
                <span>Members</span>
            </a>
            <!-- Coaches -->
            <a href="{{ route('coach.show') }}"
                @click.prevent="loading = true; setTimeout(() => { window.location.href = '{{ route('coach.show') }}' }, 500);"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 hover:bg-gray-700 hover:shadow-md hover:translate-x-1 {{ request()->routeIs('coach.show*') ? 'bg-gray-700 shadow-md' : '' }}">
                <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center mr-3">
                    <i class="fas fa-chalkboard-teacher text-white text-sm"></i>
                </div>
                <span>Coaches</span>
            </a>
            <!-- Trainings Dropdown -->
            <div x-data="{ openTrainings: false }" class="relative">
                <button @click="openTrainings = !openTrainings"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition-all duration-200 hover:bg-gray-700 hover:shadow-md hover:translate-x-1 {{ request()->routeIs('trainings.show*') || request()->routeIs('trainingHistory.show*') ? 'bg-gray-700 shadow-md' : '' }}">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center mr-3">
                            <i class="fas fa-dumbbell text-white text-sm"></i>
                        </div>
                        <span>Trainings</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': openTrainings }"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openTrainings" @click.away="openTrainings = false" x-transition
                    class="ml-8 mt-1 space-y-1 border-l-2 border-gray-600 pl-4">
                    <a href="{{ route('trainings.show') }}"
                        @click.prevent="loading = true; setTimeout(() => { window.location.href = '{{ route('trainings.show') }}' }, 500);"
                        class="flex items-center px-4 py-2 rounded-lg transition-all duration-200 hover:bg-gray-700 hover:shadow-md hover:translate-x-1 {{ request()->routeIs('trainings.show*') ? 'bg-gray-700 shadow-md' : '' }}">
                        <i class="fas fa-list mr-3 text-xs"></i>
                        <span class="text-xs">View Trainings</span>
                    </a>
                    <a href="{{ route('trainingHistory.show') }}"
                        @click.prevent="loading = true; setTimeout(() => { window.location.href = '{{ route('trainingHistory.show') }}' }, 500);"
                        class="flex items-center px-4 py-2 rounded-lg transition-all duration-200 hover:bg-gray-700 hover:shadow-md hover:translate-x-1 {{ request()->routeIs('trainingHistory.show*') ? 'bg-gray-700 shadow-md' : '' }}">
                        <i class="fas fa-history mr-3 text-xs"></i>
                        <span class="text-xs">Training History</span>
                    </a>
                </div>
            </div>
            <!-- Teams Dropdown -->
            <div x-data="{ openTeams: false }" class="relative">
                <button @click="openTeams = !openTeams"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition-all duration-200 hover:bg-gray-700 hover:shadow-md hover:translate-x-1 {{ request()->routeIs('teams.show*') || request()->routeIs('players.show*') ? 'bg-gray-700 shadow-md' : '' }}">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center mr-3">
                            <i class="fas fa-people-group text-white text-sm"></i>
                        </div>
                        <span>Teams</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': openTeams }"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openTeams" @click.away="openTeams = false" x-transition
                    class="ml-8 mt-1 space-y-1 border-l-2 border-gray-600 pl-4">
                    <a href="{{ route('teams.show') }}"
                        @click.prevent="loading = true; setTimeout(() => { window.location.href = '{{ route('teams.show') }}' }, 500);"
                        class="flex items-center px-4 py-2 rounded-lg transition-all duration-200 hover:bg-gray-700 hover:shadow-md hover:translate-x-1 {{ request()->routeIs('teams.show*') ? 'bg-gray-700 shadow-md' : '' }}">
                        <i class="fas fa-list-ul mr-3 text-xs"></i>
                        <span class="text-xs">View Teams</span>
                    </a>
                    <a href="{{ route('players.show') }}" 
                        @click.prevent="loading = true; setTimeout(() => { window.location.href = '{{ route('players.show') }}' }, 500);"
                        class="flex items-center px-4 py-2 rounded-lg transition-all duration-200 hover:bg-gray-700 hover:shadow-md hover:translate-x-1">
                        <i class="fas fa-users mr-3 text-xs"></i>
                        <span class="text-xs">Team Players</span>
                    </a>
                </div>
            </div>
            <!-- Events Dropdown -->
            <div x-data="{ openEvents: false }" class="relative">
                <button @click="openEvents = !openEvents"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition-all duration-200 hover:bg-gray-700 hover:shadow-md hover:translate-x-1 {{ request()->routeIs('events.show*') || request()->routeIs('eventhistory.show*') ? 'bg-gray-700 shadow-md' : '' }}">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center mr-3">
                            <i class="fas fa-calendar-check text-white text-sm"></i>
                        </div>
                        <span>Events</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': openEvents }"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openEvents" @click.away="openEvents = false" x-transition
                    class="ml-8 mt-1 space-y-1 border-l-2 border-gray-600 pl-4">
                    <a href="{{ route('events.show') }}"
                        @click.prevent="loading = true; setTimeout(() => { window.location.href = '{{ route('events.show') }}' }, 500);"
                        class="flex items-center px-4 py-2 rounded-lg transition-all duration-200 hover:bg-gray-700 hover:shadow-md hover:translate-x-1 {{ request()->routeIs('events.show*') ? 'bg-gray-700 shadow-md' : '' }}">
                        <i class="fas fa-calendar-alt mr-3 text-xs"></i>
                        <span class="text-xs">View Events</span>
                    </a>
                    <a href="{{ route('eventsHistory.show') }}"
                        @click.prevent="loading = true; setTimeout(() => { window.location.href = '{{ route('eventsHistory.show') }}' }, 500);"
                        class="flex items-center px-4 py-2 rounded-lg transition-all duration-200 hover:bg-gray-700 hover:shadow-md hover:translate-x-1 {{ request()->routeIs('eventsHistory.show*') ? 'bg-gray-700 shadow-md' : '' }}">
                        <i class="fas fa-history mr-3 text-xs"></i>
                        <span class="text-xs">Event History</span>
                    </a>
                </div>
            </div>
            <!-- Users -->
            {{-- <a href="{{ route('user.show') }}"
                @click.prevent="loading = true; setTimeout(() => { window.location.href = '{{ route('user.show') }}' }, 500);"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 hover:bg-gray-700 hover:shadow-md hover:translate-x-1 {{ request()->routeIs('user.show*') ? 'bg-gray-700 shadow-md' : '' }}">
                <div class="w-8 h-8 rounded-full bg-pink-500 flex items-center justify-center mr-3">
                    <i class="fas fa-user-circle text-white text-sm"></i>
                </div>
                <span>Users</span>
            </a> --}}
            <!-- Gallery -->
            <a href="{{ route('gallery.show') }}"
                @click.prevent="loading = true; setTimeout(() => { window.location.href = '{{ route('gallery.show') }}' }, 500);"
                class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 hover:bg-gray-700 hover:shadow-md hover:translate-x-1 {{ request()->routeIs('gallery.show*') ? 'bg-gray-700 shadow-md' : '' }}">
                <div class="w-8 h-8 rounded-full bg-teal-500 flex items-center justify-center mr-3">
                    <i class="fa-classic fa-solid fa-image text-white text-sm"></i>
                </div>
                <span>Gallery</span>
            </a>
            
        </nav>
    </aside>
    <!-- Overlay for Mobile -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"
        @click="sidebarOpen = false"></div>
    <!-- Page Wrapper -->
    <div class="flex-1 flex flex-col w-full md:ml-64">
        <!-- Top Bar -->
        <header class="flex justify-between items-center bg-gray-800 border-b border-gray-700 px-6 py-4 shadow-lg">
            <div class="flex items-center space-x-4">
                <!-- Mobile Menu Button -->
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-400 hover:text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                
                <!-- Breadcrumb -->
                <div class="sm:flex hidden items-center">
                    <img src="{{ asset('Images/IMG_0016.PNG') }}" class="h-8 w-8 rounded-full mr-3" alt="Logo">
                    <span class="text-xl font-bold text-yellow-400 bg-clip-text text-transparent">
                        jump<span class="text-blue-400">S</span>hot
                    </span>
                </div>
            </div>
            <!-- User Profile -->
            <div class="flex items-center space-x-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-50 hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('admin.edit')"
                                @click.prevent="loading = true; setTimeout(()=> window.location.href = '{{ route('admin.edit') }}',500)">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('user.show')"
                                @click.prevent="loading = true; setTimeout(()=> window.location.href = '{{ route('user.show') }}',500)">
                            {{ __('Users') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('admin.logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                
                    </div>
        </header>
        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-auto">
            @yield('content')
        </main>
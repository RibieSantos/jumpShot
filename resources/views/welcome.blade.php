<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Jumpshot Basketball Club</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" type="image/png" href="{{ asset('Images/IMG_0017.PNG') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />



    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @endif
</head>

<body class="text-white font-sans" x-data="{ loading: false }">
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

    <!-- Enhanced Responsive Navbar -->
    <nav class="sticky top-0 z-50 bg-black bg-opacity-80 backdrop-blur-lg px-8 py-4 shadow-xl">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Logo with Club Name -->
            <div class="flex items-center">
                <img src="{{ asset('Images/IMG_0016.PNG') }}" alt="Logo"
                    class="h-12 w-12 rounded-full mr-3 shadow-lg">
                <span class="text-2xl font-extrabold text-yellow-400">
                    jump<span class="text-blue-400">S</span>hot
                </span>
            </div>
            <!-- Hamburger Button (mobile) -->
            <button id="menu-btn"
                class="lg:hidden md:hidden text-white focus:outline-none p-2 rounded-md hover:bg-gray-700 transition-all duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <!-- Nav Links (desktop) -->
            <div id="menu" class="hidden lg:flex md:flex items-center gap-8 text-white font-semibold text-lg">
                <a href="#Home" class="relative group hover:text-yellow-400 transition duration-300">
                    Home
                    <span
                        class="absolute left-0 bottom-0 w-full h-0.5 bg-yellow-400 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                </a>
                <a href="#Membership" class="relative group hover:text-yellow-400 transition duration-300">
                    Membership
                    <span
                        class="absolute left-0 bottom-0 w-full h-0.5 bg-yellow-400 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                </a>
                <a href="#Event" class="relative group hover:text-yellow-400 transition duration-300">
                    Events
                    <span
                        class="absolute left-0 bottom-0 w-full h-0.5 bg-yellow-400 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                </a>
                <a href="#History" class="relative group hover:text-yellow-400 transition duration-300">
                    History
                    <span
                        class="absolute left-0 bottom-0 w-full h-0.5 bg-yellow-400 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                </a>
                <a href="#Coaches" class="relative group hover:text-yellow-400 transition duration-300">
                    Coaches
                    <span
                        class="absolute left-0 bottom-0 w-full h-0.5 bg-yellow-400 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                </a>
                <a href="#Gallery" class="relative group hover:text-yellow-400 transition duration-300">
                    Gallery
                    <span
                        class="absolute left-0 bottom-0 w-full h-0.5 bg-yellow-400 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                </a>
                <a href="#About" class="relative group hover:text-yellow-400 transition duration-300">
                    About Us
                    <span
                        class="absolute left-0 bottom-0 w-full h-0.5 bg-yellow-400 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                </a>
                <a href="{{ route('login') }}"
                    @click.prevent="loading = true; setTimeout (()=> window.location.href= '{{ route('login') }}',500)"
                    class="bg-gradient-to-r from-blue-600 to-blue-800 py-2.5 px-6 rounded-full hover:from-blue-500 hover:to-blue-700 text-white font-bold shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                    Login
                </a>
            </div>
        </div>
        <!-- Mobile Dropdown Menu -->
        <div id="mobile-menu"
            class="lg:hidden hidden px-4 pt-4 pb-2 space-y-3 bg-opacity-95  rounded-b-lg transition-all duration-300 ease-in-out">
            <a href="#Home"
                class="block text-white hover:text-yellow-400 hover:bg-gray-700 rounded-lg py-2 pl-3 transition-all duration-300">Home</a>
            <a href="#Membership"
                class="block text-white hover:text-yellow-400 hover:bg-gray-700 rounded-lg py-2 pl-3 transition-all duration-300">Membership</a>
            <a href="#Membership"
                class="block text-white hover:text-yellow-400 hover:bg-gray-700 rounded-lg py-2 pl-3 transition-all duration-300">Events</a>
            <a href="#History"
                class="block text-white hover:text-yellow-400 hover:bg-gray-700 rounded-lg py-2 pl-3 transition-all duration-300">History</a>
            <a href="#Coaches"
                class="block text-white hover:text-yellow-400 hover:bg-gray-700 rounded-lg py-2 pl-3 transition-all duration-300">Coaches</a>
            <a href="#Gallery"
                class="block text-white hover:text-yellow-400 hover:bg-gray-700 rounded-lg py-2 pl-3 transition-all duration-300">Gallery</a>
            <a href="#About"
                class="block text-white hover:text-yellow-400 hover:bg-gray-700 rounded-lg py-2 pl-3 transition-all duration-300">About
                Us</a>
            <a href="{{ route('login') }}"
                class="block text-white hover:text-yellow-400 hover:bg-gray-700 rounded-lg py-2 pl-3 transition-all duration-300">Login</a>
        </div>
    </nav>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('warning'))
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
                    icon: "warning",
                    title: "{{ session('warning') }}"
                });
            @endif
        });
    </script>
    <!-- Enhanced Home Section -->
    <section id="Home"
        class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-gray-900 via-blue-900 to-black">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-1/4 left-1/4 w-32 h-32 rounded-full bg-yellow-400 blur-xl animate-pulse"></div>
            <div
                class="absolute bottom-1/3 right-1/3 w-40 h-40 rounded-full bg-blue-500 blur-xl animate-pulse delay-300">
            </div>
        </div>
        <!-- Content Container -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 py-16 grid lg:grid-cols-2 gap-12 items-center">
            <!-- Text Content -->
            <div class="text-center lg:text-left space-y-8">
                <h1 class="text-5xl sm:text-6xl md:text-7xl font-extrabold leading-tight">
                    <span class="text-transparent bg-clip-text  bg-yellow-400 ">
                        jump<span class="text-blue-400">S</span>hot<br>
                    </span>
                </h1>

                <p class="text-xl text-gray-300 max-w-lg mx-auto lg:mx-0">
                    Can`t show talent & skills without confidence. Attitude & determination fuels success.
                    <br> <span class="text-yellow-500 font-bold italic">- Coach Rossel</span>
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <form action="{{ route('register') }}">
                        <input type="submit" value="Join Now"
                            @click.prevent="loading = true; setTimeout(()=>{window.location.href='{{ route('register') }}'},500)"
                            class="px-8 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-400 hover:to-yellow-500 text-black font-bold rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                    </form>

                    <a href="#Membership"
                        class="px-8 py-4 border-2 border-yellow-400 text-yellow-400 font-bold rounded-full hover:bg-yellow-400 hover:bg-opacity-10 transition-all duration-300">
                        Learn More
                    </a>
                </div>
            </div>
            <!-- Hero Image -->
            <div class="relative">
                <div
                    class="absolute -inset-4 bg-gradient-to-r from-yellow-400 to-blue-500 rounded-2xl blur-lg opacity-75 animate-pulse">
                </div>
                <img src="{{ asset('Images/IMG_0017.PNG') }}" alt="JumpShot"
                    class="relative w-full max-w-md mx-auto rounded-2xl object-contain transform hover:rotate-1 hover:scale-105 transition duration-500">
            </div>
        </div>
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                </path>
            </svg>
        </div>
    </section>


    <!-- Enhanced Membership Section - Based on Your Original Code -->
    <section id="Membership"
        class="min-h-screen py-16 px-6 lg:px-20 bg-gradient-to-r from-blue-900 via-black to-blue-900 opacity-0 transition-opacity duration-1000 ease-in-out">
        <div class="max-w-7xl mx-auto text-center space-y-12">
            <!-- Enhanced Header -->
            <div class="space-y-4">
                <h2 class="text-4xl md:text-5xl font-extrabold">
                    <span class="text-yellow-400">Membership</span>
                    <span class="text-blue-400">Benefits</span>
                </h2>
                <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto font-bold italic">
                    “Basketball is the easiest part, the hardest part... <span class="text-blue-400 font-bold">Training</span>“
                    <br><span class="text-yellow-500 font-bold">Try the jump<span class="text-blue-400">S</span>hot way</span> 
                </p>
            </div>
            <!-- Enhanced Cards - Keeping Your Original Layout -->
            <div class="grid md:grid-cols-3 gap-8 mt-10">
                <!-- Card 1 - Enhanced -->
                <div
                    class="bg-gray-800 bg-opacity-70 p-6 rounded-xl hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-2xl border border-gray-700 hover:border-yellow-400">
                    <div class="mb-5 h-40 overflow-hidden rounded-lg">
                        <img src="{{ asset('Images/skillDevelopment.jpg') }}" alt="Training"
                            class="w-full h-full object-cover hover:scale-110 transition duration-500">
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-yellow-400">Skill Development</h3>
                    <p class="text-gray-400">
                        Intensive training sessions to improve your basketball techniques with professional coaches.
                    </p>
                    <div class="mt-4">
                        <span
                            class="inline-block px-3 py-1 bg-yellow-400 bg-opacity-20 text-yellow-400 rounded-full text-sm">
                            Weekly Drills
                        </span>
                    </div>
                </div>
                <!-- Card 2 - Enhanced -->
                <div
                    class="bg-gray-800 bg-opacity-70 p-6 rounded-xl hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-2xl border border-gray-700 hover:border-blue-400 transform lg:-translate-y-3">
                    <div class="mb-5 h-40 overflow-hidden rounded-lg">
                        <img src="{{ asset('Images/teamBuildig.jpg') }}" alt="Teamwork"
                            class="w-full h-full object-cover hover:scale-110 transition duration-500">
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-blue-400">Team Building</h3>
                    <p class="text-gray-400">
                        Participate in leagues and tournaments to boost your confidence and teamwork abilities.
                    </p>
                    <div class="mt-4">
                        <span
                            class="inline-block px-3 py-1 bg-blue-400 bg-opacity-20 text-blue-400 rounded-full text-sm">
                            Monthly Events
                        </span>
                    </div>
                </div>
                <!-- Card 3 - Enhanced -->
                <div
                    class="bg-gray-800 bg-opacity-70 p-6 rounded-xl hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-2xl border border-gray-700 hover:border-yellow-400">
                    <div class="mb-5 h-40 overflow-hidden rounded-lg">
                        <img src="{{ asset('Images/expertCoaches.jpg') }}" alt="Coaching"
                            class="w-full h-full object-cover object-top hover:scale-110 transition duration-500">
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-yellow-400">Expert Coaches</h3>
                    <p class="text-gray-400">
                        Guidance from certified basketball coaches to maximize your potential and performance.
                    </p>
                    <div class="mt-4">
                        <span
                            class="inline-block px-3 py-1 bg-yellow-400 bg-opacity-20 text-yellow-400 rounded-full text-sm">
                            1-on-1 Sessions
                        </span>
                    </div>
                </div>
            </div>
            <!-- Added CTA Section -->
            <div class="mt-16">
                <a href="{{ route('register') }}"
                    @click.prevent="loading = true; setTimeout (()=> window.location.href= '{{ route('register') }}',500)"
                    class="inline-block px-8 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-400 hover:to-yellow-500 text-black font-bold rounded-full shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
                    <i class="fas fa-basketball mr-2"></i> Join Our Club Today
                </a>
            </div>
        </div>
    </section>

    <section id="Event"
        class="relative w-full min-h-[600px] md:min-h-[700px] lg:min-h-[800px] overflow-hidden
           flex items-center justify-center py-12 md:py-20
           bg-gradient-to-br from-blue-950 to-blue-800 text-white"
        {{-- Changed background gradient to deep blue --}} x-data="{
            active: 0,
            events: {{ $events->toJson() }},
            imageBasePath: '{{ asset('storage/events/') }}/',
            isAnimating: false,
            autoplayInterval: null,
            next() {
                if (this.events.length <= 1 || this.isAnimating) return;
                this.isAnimating = true;
                this.active = (this.active + 1) % this.events.length;
                this.resetAutoplay();
                setTimeout(() => { this.isAnimating = false; }, 700);
            },
            prev() {
                if (this.events.length <= 1 || this.isAnimating) return;
                this.isAnimating = true;
                this.active = (this.active - 1 + this.events.length) % this.events.length;
                this.resetAutoplay();
                setTimeout(() => { this.isAnimating = false; }, 700);
            },
            goTo(index) {
                if (this.active === index || this.isAnimating) return;
                this.isAnimating = true;
                this.active = index;
                this.resetAutoplay();
                setTimeout(() => { this.isAnimating = false; }, 700);
            },
            resetAutoplay() {
                clearInterval(this.autoplayInterval);
                this.autoplayInterval = setInterval(() => { this.next(); }, 7000);
            }
        }" x-init="if (events.length > 0) {
            this.resetAutoplay();
        } else {
            active = -1;
        }">

        <!-- Conditional rendering for when no events are available -->
        <template x-if="events.length === 0">
            <div class="absolute inset-0 flex flex-col items-center justify-center
                   bg-blue-950/90 text-blue-300 text-lg rounded-xl shadow-2xl space-y-4 p-8"
                {{-- Use section's deepest blue with transparency, add rounded corners, shadow, flex-col layout, and padding --}} x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <i class="far fa-calendar-times text-yellow-400 text-5xl md:text-6xl mb-2"></i> {{-- Prominent yellow icon --}}
                <p class="font-semibold text-white text-xl md:text-2xl text-center">No events scheduled right now.</p>
                {{-- Main message, white for emphasis --}}
                <p class="text-blue-200 text-base md:text-lg text-center">Check back later for exciting updates!</p>
                {{-- Secondary message for more detail --}}
            </div>
        </template>

        <!-- Carousel Slides Container -->
        <template x-if="events.length > 0">
            <div class="absolute inset-0 w-full h-full flex flex-col items-center justify-center">
                <template x-for="(event, index) in events" :key="event.id">
                    <div x-show="active === index" x-transition:enter="transition ease-out duration-700 transform"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-700 transform"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute inset-0 w-full h-full flex items-center justify-center">

                        <!-- Background Image for the slide -->
                        <div class="absolute inset-0 bg-cover bg-center"
                            :style="`background-image: url('${imageBasePath}${event.event_image}');`">
                            <!-- Subtle Gradient Overlay for image readability -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-blue-950 via-transparent to-blue-950 opacity-70">
                            </div> {{-- Blue gradient overlay --}}
                            <!-- Another subtle overlay to catch text shadow better -->
                            <div class="absolute inset-0 bg-black opacity-30"></div>
                        </div>

                        <!-- Event Content Card -->
                        <div class="relative z-10 w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2
                                bg-blue-900 bg-opacity-95 backdrop-blur-sm {{-- Card background changed to deep blue --}}
                                rounded-xl shadow-2xl p-6 md:p-10 text-center
                                border border-yellow-500 transform transition-all duration-300"
                            {{-- Card border changed to yellow --}}
                            :class="{ 'scale-100': active === index, 'scale-95': active !== index }">

                            <h2 class="text-3xl md:text-5xl font-extrabold mb-4
                                   text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500 {{-- Title gradient changed to yellow/orange --}}
                                   drop-shadow-lg leading-tight"
                                x-text="event.title"></h2>

                            <p class="text-sm md:text-lg font-medium mb-3 text-yellow-300 tracking-wide"
                                {{-- Date text changed to yellow --}}
                                x-text="new Date(event.event_date).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })">
                            </p>

                            <p class="text-base md:text-xl text-gray-200 leading-relaxed line-clamp-3 md:line-clamp-4"
                                x-text="event.description"></p>

                            <div class="mt-6">
                                <a href="#"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full
                                             shadow-sm bg-yellow-500 hover:bg-yellow-600 text-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 {{-- Button changed to yellow with blue text, yellow focus ring --}}
                                             transition-colors duration-200">
                                    Learn More <i class="ml-2 fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </template>


        <!-- Navigation Arrows -->
        <template x-if="events.length > 1">
            <button
                class="absolute left-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-10 hover:bg-opacity-25
                       transition-colors duration-300 rounded-full w-12 h-12 flex items-center justify-center z-30
                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-950 focus:ring-yellow-400"
                {{-- Yellow focus ring --}} @click="prev()" aria-label="Previous slide">
                <i class="fas fa-chevron-left text-white text-xl"></i>
            </button>
            <button
                class="absolute right-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-10 hover:bg-opacity-25
                       transition-colors duration-300 rounded-full w-12 h-12 flex items-center justify-center z-30
                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-950 focus:ring-yellow-400"
                {{-- Yellow focus ring --}} @click="next()" aria-label="Next slide">
                <i class="fas fa-chevron-right text-white text-xl"></i>
            </button>
        </template>

        <!-- Navigation Dots -->
        <template x-if="events.length > 0">
            <div class="absolute bottom-6 md:bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3 z-30">
                <template x-for="(event, index) in events" :key="index">
                    <button
                        class="w-3 h-3 md:w-4 md:h-4 rounded-full bg-white opacity-50 {{-- Inactive dots remain subtle white --}}
                               transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-950 focus:ring-yellow-400"
                        {{-- Yellow focus ring --}} :class="{ 'opacity-100 scale-125 bg-yellow-500': active === index }"
                        {{-- Active dot changed to yellow --}} @click="goTo(index)"
                        :aria-label="'Go to slide ' + (index + 1)"></button>
                </template>
            </div>
        </template>

    </section>


    <!-- Enhanced History Section - Matching Your Site's Style -->
    <section id="History"
        class="min-h-screen py-16 px-6 lg:px-20 bg-gradient-to-r from-gray-900 via-blue-950 to-gray-900 opacity-0 transition-opacity duration-1000 ease-in-out">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold">
                    <span class="text-yellow-400">Our</span>
                    <span class="text-blue-400">Journey</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-blue-500 mx-auto mt-4 rounded-full"></div>
            </div>
            <!-- Content - Keeping Your Original Layout -->
            <div class="flex flex-col lg:flex-row items-center gap-10">
                <!-- Image with Enhanced Styling -->
                <div class="lg:w-1/2 relative group">
                    <div
                        class="absolute -inset-2 bg-gradient-to-r from-yellow-400 to-blue-500 rounded-2xl blur opacity-75 group-hover:opacity-100 transition duration-500">
                    </div>
                    <img src="{{ asset('Images/Photo-Jun-19-5-06-56-PM.jpg') }}" alt="History"
                        class="relative w-full rounded-xl shadow-2xl transform group-hover:-rotate-1 group-hover:scale-[1.02] transition duration-500">
                </div>
                <!-- Text Content -->
                <div class="lg:w-1/2 space-y-6 text-gray-300">
                    <div class="bg-gray-800 bg-opacity-50 p-6 rounded-xl border border-gray-700">
                        <p class="mb-4">
                            Founded in 2015, Jumpshot Basketball Club started as a small group of passionate players.
                            Over the years, we've grown into a competitive club, participating in local and national
                            tournaments.
                        </p>
                        <p class="mb-4">
                            With the help of dedicated coaches and motivated members, we've developed a strong community
                            that supports each other both on and off the court.
                        </p>
                        <p class="text-yellow-400 italic font-medium">
                            "Building champions, one jump shot at a time."
                        </p>
                    </div>
                    <!-- Milestones Timeline -->
                    <div class="mt-8 space-y-4">
                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 h-8 w-8 rounded-full bg-yellow-400 flex items-center justify-center text-gray-900 mr-4 mt-1">
                                <i class="fas fa-basketball"></i>
                            </div>
                            <div>
                                <h4 class="text-yellow-400 font-semibold">2015 - Club Founded</h4>
                                <p class="text-gray-400">Started with just 12 members</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-400 flex items-center justify-center text-gray-900 mr-4 mt-1">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div>
                                <h4 class="text-blue-400 font-semibold">2018 - First Tournament Win</h4>
                                <p class="text-gray-400">Regional championship victory</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 h-8 w-8 rounded-full bg-yellow-400 flex items-center justify-center text-gray-900 mr-4 mt-1">
                                <i class="fas fa-home"></i>
                            </div>
                            <div>
                                <h4 class="text-yellow-400 font-semibold">2021 - New Facility</h4>
                                <p class="text-gray-400">Opened our dedicated training center</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Coaches Section - Matching Your Style -->
    <section id="Coaches"
        class="min-h-screen py-16 px-6 lg:px-20 bg-gradient-to-r from-gray-900 via-black to-gray-900 opacity-0 transition-opacity duration-1000 ease-in-out">
        <div class="max-w-7xl mx-auto text-center space-y-12">
            <!-- Section Header -->
            <div class="space-y-4">
                <h2 class="text-4xl md:text-5xl font-extrabold">
                    <span class="text-yellow-400">Meet Our</span>
                    <span class="text-blue-400">Coaches</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-blue-500 mx-auto mt-4 rounded-full"></div>
                <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                    Professional guidance from experienced basketball mentors
                </p>
            </div>
            <!-- Coaches Grid - Enhanced Version of Your Original -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($coach as $item)
                    <div
                        class="bg-gray-800 bg-opacity-70 rounded-xl p-6 border border-gray-700 hover:border-yellow-400 transition-all duration-300 hover:scale-[1.02] shadow-lg hover:shadow-xl overflow-hidden">
                        <!-- Coach Image with Hover Effect -->
                        <div
                            class="relative w-32 h-32 mx-auto mb-6 rounded-full overflow-hidden border-2 border-yellow-400 group">
                            <img src="{{ asset('coach/' . $item->profile_picture) }}" alt="{{ $item->user->fname }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        </div>

                        <!-- Coach Info -->
                        <h3 class="text-xl font-bold mb-2">
                            <span class="text-yellow-400">{{ $item->user->fname }}</span>
                            <span class="text-white">{{ $item->user->lname }}</span>
                        </h3>

                        <!-- Bio with Read More -->
                        <div
                            class="text-gray-400 mb-4 line-clamp-3 hover:line-clamp-none transition-all duration-300 cursor-default">
                            {{ $item->bio }}
                        </div>


                    </div>
                @endforeach
            </div>
            <!-- CTA Section -->
            <div class="mt-16">
                <a href="#Membership"
                    class="inline-block px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-400 hover:to-blue-500 text-white font-bold rounded-full shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
                    <i class="fas fa-users mr-2"></i> Train With Our Coaches
                </a>
            </div>
        </div>
    </section>

    <!-- Enhanced Gallery Section -->
    <section id="Gallery"
        class="min-h-screen py-16 px-6 lg:px-20 bg-gradient-to-b from-gray-900 to-black text-white opacity-0 transition-opacity duration-1000 ease-in-out"
        x-data="gallery()" x-init="init()">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold">
                    <span class="text-yellow-400">Our</span>
                    <span class="text-blue-400">Gallery</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-blue-500 mx-auto mt-4 rounded-full"></div>
                <p class="text-lg text-gray-400 max-w-2xl mx-auto mt-4">
                    Moments from our games, training sessions, and community events
                </p>
            </div>
            <!-- Gallery Carousel -->
            <div class="relative w-full max-w-4xl mx-auto group">
                <!-- Slides -->
                <div class="overflow-hidden rounded-xl shadow-2xl">
                    <template x-for="(image, index) in images" :key="index">
                        <div x-show="currentIndex === index" x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100" class="relative w-full">
                            <img :src="image" :alt="'Gallery Image ' + (index + 1)"
                                class="w-full h-[500px] object-cover">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                                <div class="text-white">
                                    <h3 x-text="captions[index]" class="text-2xl font-bold mb-2"></h3>
                                    <p x-text="descriptions[index]" class="text-gray-300"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <!-- Navigation Arrows -->
                <button @click="prev()"
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 text-white p-3 rounded-full hover:bg-black/75 transition-all duration-300 opacity-0 group-hover:opacity-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click="next()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 text-white p-3 rounded-full hover:bg-black/75 transition-all duration-300 opacity-0 group-hover:opacity-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <!-- Pagination Dots -->
                <div class="flex justify-center mt-6 space-x-2">
                    <template x-for="(image, index) in images" :key="index">
                        <button @click="goTo(index)"
                            :class="{
                                'bg-yellow-400 w-4': currentIndex === index,
                                'bg-gray-600 w-2': currentIndex !== index
                            }"
                            class="h-2 rounded-full cursor-pointer transition-all duration-300 hover:bg-yellow-400"
                            :aria-label="'Go to slide ' + (index + 1)"></button>
                    </template>
                </div>
            </div>
            <!-- Thumbnail Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12 max-w-4xl mx-auto">
                <template x-for="(image, index) in images" :key="index">
                    <button @click="goTo(index)"
                        :class="{
                            'ring-2 ring-yellow-400': currentIndex === index
                        }"
                        class="relative overflow-hidden rounded-lg aspect-square hover:scale-105 transition-transform duration-300">
                        <img :src="image" :alt="'Thumbnail ' + (index + 1)"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/30 hover:bg-transparent transition-all duration-300">
                        </div>
                    </button>
                </template>
            </div>
        </div>
        <script>
            function gallery() {
                return {
                    images: [
                        @foreach ($gallery as $items)
                            "{{ asset('gallery/' . $items->image) }}",
                        @endforeach
                    ],
                    captions: [
                        @foreach ($gallery as $items)
                            "{{ $items->title ?? 'Team Moment' }}",
                        @endforeach
                    ],
                    descriptions: [
                        @foreach ($gallery as $items)
                            "{{ $items->description ?? 'Action from our latest game' }}",
                        @endforeach
                    ],
                    currentIndex: 0,
                    interval: null,
                    init() {
                        document.getElementById('Gallery').classList.remove('opacity-0');
                        document.getElementById('Gallery').classList.add('opacity-100');
                        this.startAutoSlide();
                    },
                    next() {
                        this.currentIndex = (this.currentIndex + 1) % this.images.length;
                        this.resetAutoSlide();
                    },
                    prev() {
                        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                        this.resetAutoSlide();
                    },
                    goTo(index) {
                        this.currentIndex = index;
                        this.resetAutoSlide();
                    },
                    startAutoSlide() {
                        this.interval = setInterval(() => {
                            this.next();
                        }, 5000);
                    },
                    resetAutoSlide() {
                        clearInterval(this.interval);
                        this.startAutoSlide();
                    }
                }
            }
        </script>
    </section>


    <!-- Enhanced About Us Section -->
    <section id="About"
        class="min-h-screen py-16 px-6 lg:px-20 bg-black opacity-0 transition-opacity duration-1000 ease-in-out">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold">
                    <span class="text-yellow-400">About</span>
                    <span class="text-blue-400">Jumpshot</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-blue-500 mx-auto mt-4 rounded-full"></div>
            </div>
            <!-- Content Grid -->
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Mission Statement -->
                <div class="space-y-6">
                    <div class="bg-gray-900 bg-opacity-70 p-8 rounded-xl border border-gray-800">
                        <h3 class="text-2xl font-bold text-yellow-400 mb-4">Our Mission</h3>
                        <p class="text-gray-300 mb-4">
                            At Jumpshot Basketball Club, we believe in nurturing talent, building character, and
                            creating a supportive community.
                            Our club is open to all skill levels, offering a safe space for growth, teamwork, and
                            competition.
                        </p>
                        <p class="text-gray-300">
                            We're committed to developing both athletic skills and life skills through the discipline of
                            basketball.
                        </p>
                    </div>
                    <!-- Values List -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="bg-gray-900 bg-opacity-50 p-4 rounded-lg border-l-4 border-yellow-400">
                            <h4 class="font-bold text-white mb-2">Excellence</h4>
                            <p class="text-gray-400 text-sm">Striving for the highest standards in everything we do</p>
                        </div>
                        <div class="bg-gray-900 bg-opacity-50 p-4 rounded-lg border-l-4 border-blue-400">
                            <h4 class="font-bold text-white mb-2">Community</h4>
                            <p class="text-gray-400 text-sm">Building lasting relationships through basketball</p>
                        </div>
                        <div class="bg-gray-900 bg-opacity-50 p-4 rounded-lg border-l-4 border-blue-400">
                            <h4 class="font-bold text-white mb-2">Growth</h4>
                            <p class="text-gray-400 text-sm">Continuous improvement for players and coaches</p>
                        </div>
                        <div class="bg-gray-900 bg-opacity-50 p-4 rounded-lg border-l-4 border-yellow-400">
                            <h4 class="font-bold text-white mb-2">Passion</h4>
                            <p class="text-gray-400 text-sm">Love for the game that drives us forward</p>
                        </div>
                    </div>
                </div>
                <!-- Image -->
                <div class="relative group">
                    <div
                        class="absolute -inset-2 bg-gradient-to-r from-yellow-400 to-blue-500 rounded-2xl blur opacity-75 group-hover:opacity-100 transition duration-500">
                    </div>
                    <img src="{{ asset('Images/aboutUs.jpg') }}" alt="Jumpshot Team"
                        class="relative w-full rounded-xl shadow-2xl transform group-hover:-rotate-1 group-hover:scale-[1.02] transition duration-500">
                </div>
            </div>
        </div>
    </section>
    <!-- Enhanced Footer -->
    <footer class="bg-black text-white py-12 px-6 lg:px-20 border-t border-gray-800">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Logo and Info -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <img src="{{ asset('Images/IMG_0016.PNG') }}" alt="Logo"
                            class="h-12 w-12 rounded-full mr-3">
                        <span class="text-xl font-bold">
                            <span class="text-yellow-400">Jump</span><span class="text-blue-400">Shot</span>
                        </span>
                    </div>
                    <p class="text-gray-400">
                        Developing basketball talent and building character since 2015.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/profile.php?id=61555373334435"
                            class="text-gray-400 hover:text-yellow-400 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        {{-- <a href="#" class="text-gray-400 hover:text-blue-400 transition">
                        <i class="fab fa-twitter"></i>
                        </a> --}}
                        <a href="https://www.instagram.com/jumpshotbasketballclub/"
                            class="text-gray-400 hover:text-pink-500 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-yellow-400">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#Home" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="#Membership" class="text-gray-400 hover:text-white transition">Membership</a>
                        </li>
                        <li><a href="#History" class="text-gray-400 hover:text-white transition">Our History</a></li>
                        <li><a href="#Coaches" class="text-gray-400 hover:text-white transition">Coaches</a></li>
                        <li><a href="#About" class="text-gray-400 hover:text-white transition">About Us</a></li>
                    </ul>
                </div>
                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-blue-400">Contact Us</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-yellow-400"></i>
                            <span>4688 175 avenue NW Edmonton Alberta T5Y 3Z8</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-3 text-yellow-400"></i>
                            <span>587-785-7123</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3 text-yellow-400"></i>
                            <span>jumpshotbasketballclub@gmail.com</span>
                        </li>
                    </ul>
                </div>
                <!-- Newsletter -->
                {{-- <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Newsletter</h4>
                    <p class="text-gray-400 mb-4">
                        Subscribe for updates on tournaments, camps, and club news.
                    </p>
                    <form class="flex">
                        <input type="email" placeholder="Your email"
                            class="px-4 py-2 bg-gray-800 text-white rounded-l-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 w-full">
                        <button type="submit"
                            class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-r-lg transition">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div> --}}
            </div>
            <!-- Copyright -->
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500">
                <p>
                    © {{ date('Y') }} Jumpshot Basketball Club. All rights reserved.<br>
                    Developed by <span class="text-yellow-400 font-semibold">Ribie John Paul Santos</span>
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Mobile Menu (Keep this as is) -->
    <script>
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobile-menu').classList.add('hidden');
            });
        });
        document.getElementById('menu-btn').addEventListener('click', () => {
            const menu = document.getElementById('mobile-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                menu.classList.add('opacity-100', 'scale-y-100'); // Added scale-y for vertical animation
            } else {
                menu.classList.add('hidden');
                menu.classList.remove('opacity-100', 'scale-y-100');
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const sections = document.querySelectorAll('section');

            const observerOptions = {
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0');
                        entry.target.classList.add('opacity-100');
                        observer.unobserve(entry
                            .target); // Remove if you only want it to animate once
                    }
                });
            }, observerOptions);

            sections.forEach(section => {
                observer.observe(section);
            });
        });
    </script>

</body>

</html>

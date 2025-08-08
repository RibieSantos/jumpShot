@extends('admin.layouts.navigation')
@section('title', 'Dashboard Page')
@section('content')

    <!-- Main Content Wrapper - Added responsive padding and max-width for better structure -->
    <div class="max-w-7xl mx-auto p-4 md:p-6 lg:p-8">

        <!-- Page Heading -->
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-white">Dashboard Overview</h1>
            <p class="text-gray-400 mt-1">Quick stats and summaries for your basketball club.</p>
        </div>

        <!-- Charts Section - Improved spacing and consistent styling -->
        <div class="flex w-full flex-col md:flex-row gap-6"> {{-- Increased gap from 4 to 6 for more breathing room --}}
            <!-- User Growth Chart -->
            <div class="flex-1 bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-700"> {{-- Added shadow-lg for more depth --}}
                <h2 class="text-lg font-semibold text-white mb-4">User Growth Over Time</h2>
                <canvas id="userGrowthChart" height="100"></canvas>
            </div>
            <!-- Club Statistics Chart -->
            <div class="flex-1 bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-700"> {{-- Added shadow-lg for more depth --}}
                <h2 class="text-lg font-semibold text-white mb-4">Club Statistics</h2>
                <canvas id="clubChart" height="100"></canvas>
            </div>
        </div>

        <!-- Recent Registrations Table Section -->
        <div class="mt-8 bg-gray-800 rounded-lg shadow-lg border border-gray-700"> {{-- Added shadow-lg for more depth --}}
            <div class="p-4 border-b border-gray-700">
                <h3 class="text-lg font-semibold text-white">Recent Member Registrations</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700 text-sm text-left">
                    <thead class="bg-gray-700 text-center text-gray-300">
                        <tr>
                            <th class="px-3 py-2 md:px-4 md:py-3 font-bold text-center whitespace-nowrap">ID</th> {{-- Adjusted padding, added whitespace-nowrap --}}
                            <th class="px-3 py-2 md:px-4 md:py-3 font-bold text-center whitespace-nowrap">First Name</th> {{-- Adjusted padding, added whitespace-nowrap --}}
                            <th class="px-3 py-2 md:px-4 md:py-3 font-bold text-center whitespace-nowrap">Middle Name</th> {{-- Adjusted padding, added whitespace-nowrap --}}
                            <th class="px-3 py-2 md:px-4 md:py-3 font-bold text-center whitespace-nowrap">Last Name</th> {{-- Adjusted padding, added whitespace-nowrap --}}
                            <th class="px-3 py-2 md:px-4 md:py-3 font-bold text-center whitespace-nowrap">Email</th> {{-- Adjusted padding, added whitespace-nowrap --}}
                            <th class="px-3 py-2 md:px-4 md:py-3 font-bold text-center whitespace-nowrap">Role</th> {{-- Adjusted padding, added whitespace-nowrap --}}
                            <th class="px-3 py-2 md:px-4 md:py-3 font-bold text-center whitespace-nowrap">Date Created</th> {{-- Adjusted padding, added whitespace-nowrap --}}
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700 text-center">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-700 transition duration-150 ease-in-out"> {{-- Added smooth hover transition --}}
                                <td class="px-3 py-2 md:px-4 md:py-2">{{ $user->id }}</td> {{-- Adjusted padding --}}
                                <td class="px-3 py-2 md:px-4 md:py-2">{{ $user->fname }}</td> {{-- Adjusted padding --}}
                                <td class="px-3 py-2 md:px-4 md:py-2">{{ $user->mname }}</td> {{-- Adjusted padding --}}
                                <td class="px-3 py-2 md:px-4 md:py-2">{{ $user->lname }}</td> {{-- Adjusted padding --}}
                                <td class="px-3 py-2 md:px-4 md:py-2 truncate max-w-[150px] mx-auto">{{ $user->email }}</td> {{-- Added truncate and max-width for long emails --}}
                                <td class="px-3 py-2 md:px-4 md:py-2">
                                    <span class="px-2 py-1 rounded-full text-xs 
                                        {{ $user->role === 'member' ? 'bg-blue-500 text-white' : 'bg-yellow-500 text-white' }}"> {{-- Added styling for roles --}}
                                        {{ $user->role }}
                                    </span>
                                </td> {{-- Adjusted padding --}}
                                <td class="px-3 py-2 md:px-4 md:py-2 whitespace-nowrap">{{ $user->created_at->format('Y-m-d') }}</td> {{-- Adjusted padding, added whitespace-nowrap --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-4 text-center text-gray-400">No recent registrations found.</td> {{-- Adjusted padding, updated message --}}
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div> {{-- End of main content wrapper --}}

    <!-- Chart.js CDN (Already present) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart Initialization (Minor adjustments for consistency) -->
    <script>
        // Club Chart (Bar Chart)
        const ctxClub = document.getElementById('clubChart').getContext('2d'); // Changed ctx to ctxClub for clarity
        const clubChart = new Chart(ctxClub, {
            type: 'bar',
            data: {
                labels: ['Members', 'Coaches', 'Trainings'],
                datasets: [{
                    label: 'Total Count',
                    data: [{{ $member }}, {{ $coach }}, {{ $training }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)', // Blue
                        'rgba(75, 192, 192, 0.7)', // Teal
                        'rgba(255, 206, 86, 0.7)' // Yellow
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true, // Ensure chart is responsive
                maintainAspectRatio: true, // Maintain aspect ratio
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#e2e8f0' // Light gray for ticks
                        },
                        grid: {
                            color: '#4a5568' // Darker gray for grid lines
                        }
                    },
                    x: {
                        ticks: {
                            color: '#e2e8f0' // Light gray for ticks
                        },
                        grid: {
                            color: '#4a5568' // Darker gray for grid lines
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#e2e8f0' // Light gray for legend labels
                        }
                    },
                    tooltip: {
                        // Optional: Tooltip styling for dark theme
                        backgroundColor: 'rgba(30, 41, 59, 0.9)', // bg-gray-900 with transparency
                        titleColor: '#e2e8f0',
                        bodyColor: '#cbd5e0',
                        borderColor: '#4a5568',
                        borderWidth: 1
                    }
                }
            }
        });

        // User Growth Chart (Line Chart)
        const ctxLine = document.getElementById('userGrowthChart').getContext('2d');
        const userGrowthChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'User Registrations',
                    data: {!! json_encode($counts) !!},
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7 // Added hover radius
                }]
            },
            options: {
                responsive: true, // Ensure chart is responsive
                maintainAspectRatio: true, // Maintain aspect ratio
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#e2e8f0' // Light gray for ticks
                        },
                        grid: {
                            color: '#4a5568' // Darker gray for grid lines
                        }
                    },
                    x: {
                        ticks: {
                            color: '#e2e8f0' // Light gray for ticks
                        },
                        grid: {
                            color: '#4a5568' // Darker gray for grid lines
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#e2e8f0' // Light gray for legend labels
                        }
                    },
                    tooltip: {
                        // Optional: Tooltip styling for dark theme
                        backgroundColor: 'rgba(30, 41, 59, 0.9)', // bg-gray-900 with transparency
                        titleColor: '#e2e8f0',
                        bodyColor: '#cbd5e0',
                        borderColor: '#4a5568',
                        borderWidth: 1
                    }
                }
            }
        });
    </script>
@endsection 
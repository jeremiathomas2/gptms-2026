@extends('layouts.app')

@section('title', 'Dashboard - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 sm:mb-0">Dashboard Overview</h1>
            <p class="text-sm sm:text-base text-gray-500">
                @if(session('user.name'))
                    Welcome back, {{ session('user.name') }}!
                    @if(session('user.role'))
                        <br class="sm:hidden" />
                        You are logged in as a 
                        <span class="font-medium text-blue-600">
                            {{ ucfirst(session('user.role')) }}
                        </span>
                    @endif
                @else
                    Welcome back to your management dashboard
                @endif
            </p>
        </div>
        <div class="flex flex-col sm:flex-row sm:space-x-3 space-y-2 sm:space-y-0">
            @if(session('user.role') !== 'student')
            <button class="w-full sm:w-auto px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center justify-center sm:justify-start space-x-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span class="whitespace-nowrap">Export Report</span>
            </button>
            @endif
            {{-- Debug: Show survey completion status --}}
            @if(session('user.role') === 'student' && !$surveyCompleted)
            <a href="/survey" class="w-full sm:w-auto px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 flex items-center justify-center sm:justify-start space-x-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span class="whitespace-nowrap">Complete Survey</span>
            </a>
            @endif
            @if(session('user.role') === 'student')
            <button onclick="window.location.href='/skills'" class="w-full sm:w-auto px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 flex items-center justify-center sm:justify-start space-x-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="whitespace-nowrap">Add Skills</span>
            </button>
            @endif
            <button class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="whitespace-nowrap">Create Project</span>
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Groups -->
        <div class="bg-white rounded-lg shadow p-6 hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Groups</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_groups'] ?? 0 }}</p>
                    <div class="flex items-center space-x-2 mt-2">
                        <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded">+{{ $stats['groups_growth'] ?? 0 }}%</span>
                        <span class="text-xs text-gray-500">from last month</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $stats['active_groups'] ?? 0 }} active, {{ $stats['pending_groups'] ?? 0 }} pending, {{ $stats['completed_groups'] ?? 0 }} completed</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Projects -->
        <div class="bg-white rounded-lg shadow p-6 hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Projects</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_projects'] ?? 0 }}</p>
                    <div class="flex items-center space-x-2 mt-2">
                        <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded">+{{ $stats['projects_growth'] ?? 0 }}%</span>
                        <span class="text-xs text-gray-500">from last month</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $stats['active_projects'] ?? 0 }} on track, {{ $stats['total_projects'] - ($stats['active_projects'] + $stats['completed_projects']) ?? 0 }} at risk, {{ $stats['total_projects'] - ($stats['active_projects'] + $stats['completed_projects']) ?? 0 }} delayed</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Students -->
        <div class="bg-white rounded-lg shadow p-6 hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Students</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_students'] ?? 0 }}</p>
                    <div class="flex items-center space-x-2 mt-2">
                        <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded">+{{ $stats['students_growth'] ?? 0 }}%</span>
                        <span class="text-xs text-gray-500">from last month</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $stats['active_students'] ?? 0 }} active, {{ $stats['inactive_students'] ?? 0 }} inactive, {{ $stats['total_students'] - ($stats['active_students'] + $stats['inactive_students']) ?? 0 }} new</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332-.477-4.5-1.253"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completion Rate -->
        <div class="bg-white rounded-lg shadow p-6 hover-scale">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Completion Rate</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['completion_rate'] ?? 0 }}%</p>
                    <div class="flex items-center space-x-2 mt-2">
                        <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded">+{{ $stats['completion_growth'] ?? 0 }}%</span>
                        <span class="text-xs text-gray-500">from last month</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $stats['on_time_delivery'] ?? 0 }}% on-time delivery</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Group Creation Countdown (for students) -->
    @if(session('user.role') === 'student')
    <div id="countdown-container" class="hidden">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg shadow-lg p-6 border border-blue-200">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Group Creation Countdown</h3>
                        <p class="text-sm text-gray-600">Groups will be automatically created when the timer ends</p>
                    </div>
                </div>
                <div class="text-right">
                    <div id="student-countdown" class="text-3xl font-bold text-blue-600">--:--:--</div>
                    <p class="text-xs text-gray-500">Time remaining</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div class="bg-white rounded-lg p-3 text-center">
                    <div class="text-xl font-bold text-gray-900" id="total-students">--</div>
                    <div class="text-xs text-gray-500">Total Students</div>
                </div>
                <div class="bg-white rounded-lg p-3 text-center">
                    <div class="text-xl font-bold text-gray-900" id="participants-per-group">--</div>
                    <div class="text-xs text-gray-500">Per Group</div>
                </div>
                <div class="bg-white rounded-lg p-3 text-center">
                    <div class="text-xl font-bold text-gray-900" id="groups-to-create">--</div>
                    <div class="text-xs text-gray-500">Groups to Create</div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Activity Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Activity Overview</h3>
                <select class="text-sm border border-gray-300 rounded px-3 py-1">
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                    <option>Last 3 months</option>
                </select>
            </div>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                <div class="text-center">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <p class="text-gray-500 text-sm">Activity chart will be displayed here</p>
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Performance Metrics</h3>
                <button class="text-sm text-blue-600 hover:text-blue-800 flex items-center space-x-1">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 01-.707 0L3.293 8.707A1 1 0 013 8V4z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16a1 1 0 001 1h16a1 1 0 001-1v-2.586a1 1 0 00-.293-.707l-6.414-6.414a1 1 0 00-.707 0L3.293 15.293A1 1 0 003 16z"/>
                    </svg>
                    <span class="whitespace-nowrap">Advanced Filters</span>
                </button>
            </div>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Group Efficiency</span>
                    <div class="flex items-center space-x-2">
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 78%"></div>
                        </div>
                        <span class="text-sm font-medium">78%</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Project Success Rate</span>
                    <div class="flex items-center space-x-2">
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                        <span class="text-sm font-medium">85%</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Student Engagement</span>
                    <div class="flex items-center space-x-2">
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-600 h-2 rounded-full" style="width: 92%"></div>
                        </div>
                        <span class="text-sm font-medium">92%</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Resource Utilization</span>
                    <div class="flex items-center space-x-2">
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: 68%"></div>
                        </div>
                        <span class="text-sm font-medium">68%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">New group created</p>
                        <p class="text-xs text-gray-500">Web Development Team - 2 hours ago</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Project completed</p>
                        <p class="text-xs text-gray-500">Mobile App Development - 5 hours ago</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332-.477-4.5-1.253"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">New student enrolled</p>
                        <p class="text-xs text-gray-500">Alice Johnson - 1 day ago</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">New message received</p>
                        <p class="text-xs text-gray-500">From project mentor - 2 days ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if(session('user.role') === 'student')
<script>
let studentCountdownInterval = null;

function checkCountdownStatus() {
    fetch('{{ route("admin.countdown-status") }}')
        .then(response => response.json())
        .then(data => {
            if (data.is_active && data.remaining_time > 0) {
                // Show countdown container
                document.getElementById('countdown-container').classList.remove('hidden');
                
                // Update countdown display
                updateStudentCountdown(data.remaining_time);
                
                // Start interval for real-time updates
                if (!studentCountdownInterval) {
                    studentCountdownInterval = setInterval(() => {
                        checkCountdownStatus();
                    }, 1000);
                }
            } else {
                // Hide countdown container
                document.getElementById('countdown-container').classList.add('hidden');
                
                // Clear interval
                if (studentCountdownInterval) {
                    clearInterval(studentCountdownInterval);
                    studentCountdownInterval = null;
                }
                
                // If countdown ended, refresh page to show groups
                if (data.remaining_time === 0) {
                    setTimeout(() => {
                        showNotification('Groups have been created! Refreshing...', 'success');
                        setTimeout(() => window.location.reload(), 2000);
                    }, 1000);
                }
            }
        })
        .catch(error => {
            console.error('Error checking countdown status:', error);
        });
}

function updateStudentCountdown(remainingTime) {
    const hours = Math.floor(remainingTime / 3600);
    const minutes = Math.floor((remainingTime % 3600) / 60);
    const seconds = remainingTime % 60;
    
    const timeString = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    document.getElementById('student-countdown').textContent = timeString;
    
    // Update statistics
    fetch('{{ route("admin.countdown-status") }}')
        .then(response => response.json())
        .then(data => {
            if (data.total_students) {
                document.getElementById('total-students').textContent = data.total_students;
                document.getElementById('participants-per-group').textContent = data.participants_per_group || 4;
                document.getElementById('groups-to-create').textContent = Math.ceil(data.total_students / (data.participants_per_group || 4));
            }
        });
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Check countdown status on page load
document.addEventListener('DOMContentLoaded', function() {
    checkCountdownStatus();
});
</script>
@endif
@endpush

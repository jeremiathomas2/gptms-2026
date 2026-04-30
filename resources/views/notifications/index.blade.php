@extends('layouts.app')

@section('title', 'Notifications - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
            <p class="text-gray-500">Manage your notifications and alerts</p>
        </div>
        <div class="flex space-x-3">
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                </svg>
                <span>Mark All Read</span>
            </button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Settings</span>
            </button>
        </div>
    </div>

    <!-- Notification Filters -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-wrap gap-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">All</button>
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Unread</button>
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Projects</button>
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Groups</button>
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">System</button>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="space-y-4">
        <!-- Unread Notification -->
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-900">New project assigned</h3>
                        <p class="text-sm text-gray-600 mt-1">You have been assigned to the "Mobile App Development" project. Please review the project details and update your availability.</p>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="text-xs text-gray-500">2 hours ago</span>
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">Project</span>
                        </div>
                    </div>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Read Notifications -->
        <div class="bg-white rounded-lg shadow p-4 opacity-75">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-900">Group invitation accepted</h3>
                        <p class="text-sm text-gray-600 mt-1">Sarah Davis has accepted your invitation to join the "Web Development Squad" group.</p>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="text-xs text-gray-500">Yesterday</span>
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Group</span>
                        </div>
                    </div>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 opacity-75">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-900">Project deadline approaching</h3>
                        <p class="text-sm text-gray-600 mt-1">The "E-commerce Platform" project deadline is approaching in 3 days. Please update your progress.</p>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="text-xs text-gray-500">2 days ago</span>
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded">Project</span>
                        </div>
                    </div>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 opacity-75">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-900">Task completed</h3>
                        <p class="text-sm text-gray-600 mt-1">Great job! You have completed the "Database Schema Design" task for the Data Science Research project.</p>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="text-xs text-gray-500">3 days ago</span>
                            <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded">Task</span>
                        </div>
                    </div>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 opacity-75">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-900">System maintenance</h3>
                        <p class="text-sm text-gray-600 mt-1">The system will undergo scheduled maintenance tonight from 2:00 AM to 4:00 AM EST.</p>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="text-xs text-gray-500">1 week ago</span>
                            <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">System</span>
                        </div>
                    </div>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Load More -->
    <div class="text-center">
        <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Load More Notifications</button>
    </div>
</div>
@endsection

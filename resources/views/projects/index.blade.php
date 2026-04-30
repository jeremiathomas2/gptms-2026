@extends('layouts.app')

@section('title', 'Projects Management - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Projects Management</h1>
            <p class="text-gray-500">Track and manage all project activities</p>
        </div>
        <div class="flex space-x-3">
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span>Kanban Board</span>
            </button>
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Gantt Chart</span>
            </button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>New Project</span>
            </button>
        </div>
    </div>

    <!-- Project Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Projects</p>
                    <p class="text-2xl font-bold text-gray-900">12</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">In Progress</p>
                    <p class="text-2xl font-bold text-gray-900">8</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Completed</p>
                    <p class="text-2xl font-bold text-gray-900">3</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">At Risk</p>
                    <p class="text-2xl font-bold text-gray-900">1</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Kanban Board View -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- To Do Column -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b border-gray-200">
                <h3 class="font-semibold text-gray-900">To Do</h3>
                <p class="text-sm text-gray-500">3 projects</p>
            </div>
            <div class="p-4 space-y-4">
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900">Mobile App Development</h4>
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">High</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Cross-platform mobile application for campus services</p>
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span>Due: Feb 15, 2024</span>
                        <div class="flex -space-x-2">
                            <img src="https://picsum.photos/seed/user1/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                            <img src="https://picsum.photos/seed/user2/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                            <img src="https://picsum.photos/seed/user3/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900">API Documentation</h4>
                        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded">Medium</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Complete API documentation for all services</p>
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span>Due: Feb 20, 2024</span>
                        <div class="flex -space-x-2">
                            <img src="https://picsum.photos/seed/user4/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- In Progress Column -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b border-gray-200">
                <h3 class="font-semibold text-gray-900">In Progress</h3>
                <p class="text-sm text-gray-500">5 projects</p>
            </div>
            <div class="p-4 space-y-4">
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900">E-commerce Platform</h4>
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">High</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Full-stack e-commerce solution with payment integration</p>
                    <div class="mb-3">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>Progress</span>
                            <span>65%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span>Due: Mar 1, 2024</span>
                        <div class="flex -space-x-2">
                            <img src="https://picsum.photos/seed/user5/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                            <img src="https://picsum.photos/seed/user6/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                            <img src="https://picsum.photos/seed/user7/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                            <img src="https://picsum.photos/seed/user8/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                        </div>
                    </div>
                </div>
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900">Data Analytics Dashboard</h4>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Low</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Real-time analytics dashboard for project metrics</p>
                    <div class="mb-3">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>Progress</span>
                            <span>40%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 40%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span>Due: Feb 28, 2024</span>
                        <div class="flex -space-x-2">
                            <img src="https://picsum.photos/seed/user9/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                            <img src="https://picsum.photos/seed/user10/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Column -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b border-gray-200">
                <h3 class="font-semibold text-gray-900">Review</h3>
                <p class="text-sm text-gray-500">2 projects</p>
            </div>
            <div class="p-4 space-y-4">
                <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900">User Authentication System</h4>
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">High</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Secure authentication system with OAuth integration</p>
                    <div class="mb-3">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>Progress</span>
                            <span>90%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-600 h-2 rounded-full" style="width: 90%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span>Due: Feb 10, 2024</span>
                        <div class="flex -space-x-2">
                            <img src="https://picsum.photos/seed/user11/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                            <img src="https://picsum.photos/seed/user12/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Column -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b border-gray-200">
                <h3 class="font-semibold text-gray-900">Completed</h3>
                <p class="text-sm text-gray-500">2 projects</p>
            </div>
            <div class="p-4 space-y-4">
                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900">Database Migration</h4>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Completed</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Migrated legacy database to new schema</p>
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span>Completed: Jan 30, 2024</span>
                        <div class="flex -space-x-2">
                            <img src="https://picsum.photos/seed/user13/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                            <img src="https://picsum.photos/seed/user14/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900">UI/UX Redesign</h4>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Completed</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Complete redesign of user interface</p>
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span>Completed: Jan 25, 2024</span>
                        <div class="flex -space-x-2">
                            <img src="https://picsum.photos/seed/user15/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                            <img src="https://picsum.photos/seed/user16/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                            <img src="https://picsum.photos/seed/user17/24/24.jpg" class="w-6 h-6 rounded-full border-2 border-white">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Timeline -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Project Timeline</h3>
        <div class="space-y-4">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 w-4 h-4 bg-blue-600 rounded-full"></div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium text-gray-900">Mobile App Development</h4>
                            <p class="text-sm text-gray-600">Start: Jan 15, 2024 - End: Feb 15, 2024</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">In Progress</span>
                    </div>
                    <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 45%"></div>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 w-4 h-4 bg-green-600 rounded-full"></div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium text-gray-900">Database Migration</h4>
                            <p class="text-sm text-gray-600">Start: Jan 10, 2024 - End: Jan 30, 2024</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Completed</span>
                    </div>
                    <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 w-4 h-4 bg-yellow-600 rounded-full"></div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium text-gray-900">E-commerce Platform</h4>
                            <p class="text-sm text-gray-600">Start: Jan 20, 2024 - End: Mar 1, 2024</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">In Progress</span>
                    </div>
                    <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

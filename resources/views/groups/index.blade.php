@extends('layouts.app')

@section('title', 'Groups Management - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Groups Management</h1>
            <p class="text-gray-500">Manage and monitor all project groups</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="toggleAdvancedFilters()" class="btn btn-secondary flex items-center space-x-2">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 01-.707.293l-6.586-6.586a1 1 0 01-.293-.707V5a1 1 0 011-1H6a1 1 0 011-1V4z"/>
                </svg>
                <span>Advanced Filters</span>
            </button>
            <button class="btn btn-secondary flex items-center space-x-2">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Export</span>
            </button>
            <button onclick="openCreateModal()" class="btn btn-primary flex items-center space-x-2">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Create Group</span>
            </button>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div id="advanced-filters" class="hidden bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="form-label">Status</label>
                <select class="form-input">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div>
                <label class="form-label">Project</label>
                <select class="form-input">
                    <option value="all">All Projects</option>
                    <option value="ecommerce">E-commerce Platform</option>
                    <option value="mobile">Mobile App</option>
                    <option value="research">Data Research</option>
                </select>
            </div>
            <div>
                <label class="form-label">Priority</label>
                <select class="form-input">
                    <option value="all">All Priorities</option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
            </div>
            <div>
                <label class="form-label">Date Range</label>
                <select class="form-input">
                    <option value="all">All Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
            </div>
        </div>
        <div class="flex justify-end mt-4 space-x-3">
            <button onclick="resetFilters()" class="btn btn-secondary">
                Reset
            </button>
            <button onclick="applyFilters()" class="btn btn-primary">
                Apply Filters
            </button>
        </div>
    </div>

    <!-- Search and View Controls -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search groups..." 
                           class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <select class="border border-gray-300 rounded-lg px-3 py-2">
                    <option value="name">Sort by Name</option>
                    <option value="created">Sort by Created</option>
                    <option value="progress">Sort by Progress</option>
                    <option value="rating">Sort by Rating</option>
                </select>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="setViewMode('grid')" class="p-2 rounded-lg bg-blue-100 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </button>
                <button onclick="setViewMode('list')" class="p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Groups Grid View -->
    <div id="groups-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Group Card 1 -->
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow hover-scale">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Web Development Squad</h3>
                        <p class="text-sm text-gray-500">E-commerce Platform</p>
                    </div>
                    <div class="flex space-x-1">
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Active</span>
                        <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">High Priority</span>
                    </div>
                </div>
                
                <p class="text-sm text-gray-600 mb-4">Building modern web applications with cutting-edge technologies</p>
                
                <div class="flex items-center space-x-4 mb-4">
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="text-sm text-gray-600">4/5 members</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <span class="text-sm text-gray-600">4.8</span>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Progress</span>
                        <span class="font-medium">85%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 85%"></div>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-1 mb-4">
                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">React</span>
                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">Node.js</span>
                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">TypeScript</span>
                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">MongoDB</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <img src="https://picsum.photos/seed/user1/32/32.jpg" alt="Leader" class="w-8 h-8 rounded-full">
                        <div>
                            <p class="text-sm font-medium">John Doe</p>
                            <p class="text-xs text-gray-500">Group Leader</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="p-1 text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        <button class="p-1 text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button class="p-1 text-gray-400 hover:text-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Group Card 2 -->
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow hover-scale">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Data Science Research</h3>
                        <p class="text-sm text-gray-500">Predictive Analytics</p>
                    </div>
                    <div class="flex space-x-1">
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Active</span>
                        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded">Medium Priority</span>
                    </div>
                </div>
                
                <p class="text-sm text-gray-600 mb-4">Machine learning and data analysis for predictive modeling</p>
                
                <div class="flex items-center space-x-4 mb-4">
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="text-sm text-gray-600">3/4 members</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <span class="text-sm text-gray-600">4.6</span>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Progress</span>
                        <span class="font-medium">72%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 72%"></div>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-1 mb-4">
                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">Python</span>
                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">TensorFlow</span>
                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">Pandas</span>
                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">Jupyter</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <img src="https://picsum.photos/seed/user2/32/32.jpg" alt="Leader" class="w-8 h-8 rounded-full">
                        <div>
                            <p class="text-sm font-medium">Jane Smith</p>
                            <p class="text-xs text-gray-500">Group Leader</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="p-1 text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        <button class="p-1 text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button class="p-1 text-gray-400 hover:text-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Group Card 3 -->
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow hover-scale">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Mobile App Team</h3>
                        <p class="text-sm text-gray-500">iOS/Android Development</p>
                    </div>
                    <div class="flex space-x-1">
                        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded">Pending</span>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Low Priority</span>
                    </div>
                </div>
                
                <p class="text-sm text-gray-600 mb-4">Cross-platform mobile application development with React Native</p>
                
                <div class="flex items-center space-x-4 mb-4">
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="text-sm text-gray-600">2/4 members</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <span class="text-sm text-gray-600">4.2</span>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Progress</span>
                        <span class="font-medium">45%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-600 h-2 rounded-full" style="width: 45%"></div>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-1 mb-4">
                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">React Native</span>
                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">TypeScript</span>
                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">Redux</span>
                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">Firebase</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <img src="https://picsum.photos/seed/user3/32/32.jpg" alt="Leader" class="w-8 h-8 rounded-full">
                        <div>
                            <p class="text-sm font-medium">Mike Johnson</p>
                            <p class="text-xs text-gray-500">Group Leader</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="p-1 text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        <button class="p-1 text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button class="p-1 text-gray-400 hover:text-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Groups List View (Hidden by default) -->
    <div id="groups-list" class="hidden">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" class="rounded border-gray-300">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Group</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leader</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Members</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="rounded border-gray-300">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">Web Development Squad</div>
                                <div class="text-sm text-gray-500">E-commerce Platform</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img src="https://picsum.photos/seed/user1/32/32.jpg" alt="" class="w-8 h-8 rounded-full">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">John Doe</div>
                                    <div class="text-sm text-gray-500">john.doe@university.edu</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">4/5</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-16 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                                <span class="ml-2 text-sm text-gray-900">85%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <span class="ml-1 text-sm text-gray-900">4.8</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">View</button>
                                <button class="text-gray-600 hover:text-gray-900">Edit</button>
                                <button class="text-red-600 hover:text-red-900">Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Group Modal -->
<div id="create-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Create New Group</h3>
        </div>
        <div class="p-6">
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Group Name</label>
                    <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Enter group name">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea class="w-full border border-gray-300 rounded-lg px-3 py-2" rows="3" placeholder="Enter group description"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Project</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option>Select Project</option>
                            <option>E-commerce Platform</option>
                            <option>Mobile App</option>
                            <option>Data Research</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Max Members</label>
                        <input type="number" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="5" min="2" max="10">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Skills Required</label>
                    <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Enter skills (comma separated)">
                </div>
            </form>
        </div>
        <div class="p-6 border-t border-gray-200 flex justify-end space-x-3">
            <button onclick="closeCreateModal()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Group</button>
        </div>
    </div>
</div>

<script>
function toggleAdvancedFilters() {
    const filters = document.getElementById('advanced-filters');
    filters.classList.toggle('hidden');
}

function setViewMode(mode) {
    const gridView = document.getElementById('groups-grid');
    const listView = document.getElementById('groups-list');
    
    if (mode === 'grid') {
        gridView.classList.remove('hidden');
        listView.classList.add('hidden');
    } else {
        gridView.classList.add('hidden');
        listView.classList.remove('hidden');
    }
}

function openCreateModal() {
    document.getElementById('create-modal').classList.remove('hidden');
}

function closeCreateModal() {
    document.getElementById('create-modal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('create-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCreateModal();
    }
});
</script>
@endsection

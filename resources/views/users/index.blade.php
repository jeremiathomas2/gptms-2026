@extends('layouts.app')

@section('title', 'User Management - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
            <p class="text-gray-500">Manage users, roles, and permissions</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="downloadTemplate('students')" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="whitespace-nowrap">Student Template</span>
            </button>
            <button onclick="downloadTemplate('supervisors')" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="whitespace-nowrap">Supervisor Template</span>
            </button>
            <button onclick="showImportModal('students')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center space-x-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="whitespace-nowrap">Import Students</span>
            </button>
            <button onclick="showImportModal('supervisors')" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 flex items-center space-x-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="whitespace-nowrap">Import Supervisors</span>
            </button>
            <button onclick="exportUsers()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <span class="whitespace-nowrap">Export Users</span>
            </button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <span class="whitespace-nowrap">Add User</span>
            </button>
        </div>
    </div>

    <!-- User Statistics -->
    <div class="flex flex-col lg:flex-row gap-4 sm:gap-6">
        <div class="flex-1 bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $users->count() }}</p>
                    <p class="text-xs text-green-600 mt-1">Registered users</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0H6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="flex-1 bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Users</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $users->where('status', 'active')->count() }}</p>
                    <p class="text-xs text-green-600 mt-1">{{ $users->count() > 0 ? round(($users->where('status', 'active')->count() / $users->count()) * 100) : 0 }}% active rate</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="flex-1 bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                <div>
                    <p class="text-sm font-medium text-gray-600">Admin Users</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $users->filter(function($user) { return $user->hasRole('admin'); })->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">System administrators</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15l-9-5m9 5v6a2 2 0 012-2h6a2 2 0 012 2v-4a2 2 0 11-2 2h-6a2 2 0 00-2 2v-2z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="flex-1 bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                <div>
                    <p class="text-sm font-medium text-gray-600">Students</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $users->filter(function($user) { return $user->hasRole('student'); })->count() }}</p>
                    <p class="text-xs text-blue-600 mt-1">Student accounts</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253a9 9 0 11-18 0 9 9 0 0118 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 8.25a.75.75 0 111.5 0 1.5v1.5a.75.75 0 001.5 0H8.25V7.5a.75.75 0 001.5 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="flex-1 bg-white rounded-lg shadow p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                <div>
                    <p class="text-sm font-medium text-gray-600">Supervisors</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $users->filter(function($user) { return $user->hasRole('supervisor'); })->count() }}</p>
                    <p class="text-xs text-orange-600 mt-1">Supervisor accounts</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Search users..." 
                           class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <select id="roleFilter" class="border border-gray-300 rounded-lg px-3 py-2">
                    <option value="all">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="student">Student</option>
                </select>
                <select id="statusFilter" class="border border-gray-300 rounded-lg px-3 py-2">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="suspended">Suspended</option>
                </select>
                <select id="departmentFilter" class="border border-gray-300 rounded-lg px-3 py-2">
                    <option value="all">All Departments</option>
                    <option value="cs">Computer Science</option>
                    <option value="eng">Engineering</option>
                    <option value="business">Business</option>
                </select>
            </div>
            <div class="flex items-center space-x-2">
                <button id="gridViewBtn" onclick="toggleView('grid')" class="px-4 py-2 bg-blue-600 text-white border border-blue-600 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 01-.707.293l-6.586-6.586a1 1 0 01-.293-.707V5a1 1 0 011-1H6a1 1 0 011-1V4z"/>
                    </svg>
                    <span class="whitespace-nowrap">Grid View</span>
                </button>
                <button id="listViewBtn" onclick="toggleView('list')" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span class="whitespace-nowrap">List View</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Users Grid -->
    <div id="usersGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        @forelse ($users as $user)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-3 sm:space-y-0 mb-4">
                        <img src="https://picsum.photos/seed/{{ $user->email }}/64/64.jpg" alt="{{ $user->name }}" class="w-12 h-12 sm:w-16 sm:h-16 rounded-full mx-auto sm:mx-0">
                        <div class="text-center sm:text-left flex-1">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-1">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            <div class="flex flex-wrap justify-center sm:justify-start items-center gap-2 mt-2">
                                @if ($user->hasRole('admin'))
                                    <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded">Admin</span>
                                @elseif ($user->hasRole('supervisor'))
                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">Supervisor</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Student</span>
                                @endif
                                
                                @if ($user->status === 'active')
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Active</span>
                                @elseif ($user->status === 'inactive')
                                    <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded">Inactive</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">Suspended</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2 sm:space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Phone</span>
                            <span class="font-medium text-xs sm:text-sm">{{ $user->phone ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Gender</span>
                            <span class="font-medium text-xs sm:text-sm">
                                @if($user->gender)
                                    {{ ucfirst($user->gender) }}
                                @else
                                    <span class="text-gray-400">Not specified</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Groups</span>
                            <span class="font-medium text-xs sm:text-sm">{{ $user->groupMemberships()->count() }} groups</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Last Active</span>
                            <span class="font-medium text-xs sm:text-sm">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Joined</span>
                            <span class="font-medium text-xs sm:text-sm">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-2 sm:space-y-0 mt-4">
                        <a href="{{ route('users.show', $user->id) }}" class="flex-1 px-2 sm:px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm text-center">View</a>
                        <a href="{{ route('users.edit', $user->id) }}" class="flex-1 px-2 sm:px-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm text-center">Edit</a>
                        <form action="{{ route('users.delete', $user->id) }}" method="POST" onsubmit="return confirmDelete('{{ $user->name }}')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 sm:px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1 1h-4a1 1 0 00-1 1v3m0 0h6v-1a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow p-6 sm:p-8 text-center">
                    <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2">No users found</h3>
                    <p class="text-sm text-gray-500">Try adjusting your search criteria or filters</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Users List (hidden by default) -->
    <div id="usersList" class="hidden">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registration</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img src="https://picsum.photos/seed/{{ $user->email }}/40/40.jpg" alt="{{ $user->name }}" class="w-10 h-10 rounded-full mr-3">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($user->hasRole('admin'))
                                        <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded">Admin</span>
                                    @elseif ($user->hasRole('supervisor'))
                                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">Supervisor</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Student</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($user->status === 'active')
                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Active</span>
                                    @elseif ($user->status === 'inactive')
                                        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded">Inactive</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">Suspended</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $user->registration_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('users.show', $user->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('users.delete', $user->id) }}" method="POST" onsubmit="return confirmDelete('{{ $user->name }}')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No users found. Try adjusting your search criteria or filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between">
        <div class="text-sm text-gray-700">
            Showing <span class="font-medium">1</span> to <span class="font-medium">6</span> of <span class="font-medium">45</span> results
        </div>
        <div class="flex items-center space-x-2">
            <button class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50" disabled>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-50">1</button>
            <button class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
            <button class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-50">3</button>
            <button class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-50">4</button>
            <button class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
// View toggle functionality
function toggleView(viewType) {
    const gridView = document.getElementById('usersGrid');
    const listView = document.getElementById('usersList');
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');
    
    if (viewType === 'grid') {
        // Show grid view
        gridView.classList.remove('hidden');
        listView.classList.add('hidden');
        
        // Update button styles
        gridBtn.classList.remove('bg-white', 'border-gray-300');
        gridBtn.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
        listBtn.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
        listBtn.classList.add('bg-white', 'border-gray-300');
        
        // Save preference
        localStorage.setItem('usersViewPreference', 'grid');
    } else if (viewType === 'list') {
        // Show list view
        gridView.classList.add('hidden');
        listView.classList.remove('hidden');
        
        // Update button styles
        listBtn.classList.remove('bg-white', 'border-gray-300');
        listBtn.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
        gridBtn.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
        gridBtn.classList.add('bg-white', 'border-gray-300');
        
        // Save preference
        localStorage.setItem('usersViewPreference', 'list');
    }
}

// Initialize view preference on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedPreference = localStorage.getItem('usersViewPreference');
    if (savedPreference === 'list') {
        toggleView('list');
    } else {
        toggleView('grid');
    }
});

// Filter functionality
function applyFilters() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const roleFilter = document.getElementById('roleFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    const departmentFilter = document.getElementById('departmentFilter').value;
    
    const userCards = document.querySelectorAll('#usersGrid .bg-white');
    const userRows = document.querySelectorAll('#usersList tbody tr');
    
    // Filter grid view
    userCards.forEach(card => {
        const userName = card.querySelector('h3')?.textContent.toLowerCase() || '';
        const userEmail = card.querySelector('p')?.textContent.toLowerCase() || '';
        const userRole = card.querySelector('.px-2.py-1')?.textContent.toLowerCase() || '';
        const userStatus = card.querySelectorAll('.px-2.py-1')[1]?.textContent.toLowerCase() || '';
        
        const matchesSearch = userName.includes(searchTerm) || userEmail.includes(searchTerm);
        const matchesRole = roleFilter === 'all' || userRole.includes(roleFilter.toLowerCase());
        const matchesStatus = statusFilter === 'all' || userStatus.includes(statusFilter.toLowerCase());
        const matchesDepartment = departmentFilter === 'all' || true; // Department filter to be implemented
        
        if (matchesSearch && matchesRole && matchesStatus && matchesDepartment) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
    
    // Filter list view
    userRows.forEach(row => {
        const userName = row.querySelector('.text-sm.font-medium')?.textContent.toLowerCase() || '';
        const userEmail = row.querySelector('.text-sm.text-gray-500')?.textContent.toLowerCase() || '';
        const userRole = row.querySelector('td:nth-child(2) .px-2.py-1')?.textContent.toLowerCase() || '';
        const userStatus = row.querySelector('td:nth-child(3) .px-2.py-1')?.textContent.toLowerCase() || '';
        
        const matchesSearch = userName.includes(searchTerm) || userEmail.includes(searchTerm);
        const matchesRole = roleFilter === 'all' || userRole.includes(roleFilter.toLowerCase());
        const matchesStatus = statusFilter === 'all' || userStatus.includes(statusFilter.toLowerCase());
        const matchesDepartment = departmentFilter === 'all' || true; // Department filter to be implemented
        
        if (matchesSearch && matchesRole && matchesStatus && matchesDepartment) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Real-time search
document.getElementById('searchInput')?.addEventListener('input', applyFilters);
document.getElementById('roleFilter')?.addEventListener('change', applyFilters);
document.getElementById('statusFilter')?.addEventListener('change', applyFilters);
document.getElementById('departmentFilter')?.addEventListener('change', applyFilters);

// User management functions
function viewUser(userId) {
    // Navigate to user detail page or show modal
    console.log('View user:', userId);
    // For now, show a notification
    showNotification('User details view coming soon!', 'info');
}

function editUser(userId) {
    // Navigate to user edit page or show modal
    console.log('Edit user:', userId);
    // For now, show a notification
    showNotification('User edit functionality coming soon!', 'info');
}

function deleteUser(userId, userName) {
    // Confirm and delete user
    if (confirm(`Are you sure you want to delete user "${userName}"? This action cannot be undone.`)) {
        console.log('Delete user:', userId);
        // For now, show a notification
        showNotification(`User "${userName}" deletion functionality coming soon!`, 'warning');
    }
}

function addUser() {
    // Navigate to user creation page or show modal
    console.log('Add new user');
    // For now, show a notification
    showNotification('User creation functionality coming soon!', 'info');
}

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing user management functionality');
    
    const searchInput = document.querySelector('input[placeholder="Search users..."]');
    const roleFilter = document.querySelector('select');
    const statusFilter = document.querySelectorAll('select')[1];
    
    // Initialize button functionality after DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing user management functionality');
    
    // Test button clicks after a short delay to ensure DOM is ready
    setTimeout(() => {
        // Try multiple selectors for buttons
        const exportBtn = document.querySelector('button[onclick*="export"]') || 
                          document.querySelector('button[onclick*="exportUsers()"]');
        const importStudentBtn = document.querySelector('button[onclick*="showImportModal(\'students\')"]') || 
                             document.querySelector('button[onclick*="showImportModal(\'students\')"]');
        const importSupervisorBtn = document.querySelector('button[onclick*="showImportModal(\'supervisors\')"]') || 
                               document.querySelector('button[onclick*="showImportModal(\'supervisors\')"]');
        
        console.log('Button elements found:', {
            exportBtn: !!exportBtn,
            importStudentBtn: !!importStudentBtn,
            importSupervisorBtn: !!importSupervisorBtn
        });
        
        // Test click functionality with comprehensive error handling
        const addClickListener = (button, name) => {
            if (button) {
                button.addEventListener('click', () => {
                    console.log(`${name} button clicked`);
                    try {
                        if (button.onclick) {
                            eval(button.onclick);
                        } else {
                            console.error(`${name} button has no onclick handler`);
                        }
                    } catch (error) {
                        console.error(`Error executing ${name} button:`, error);
                    }
                });
            } else {
                console.error(`${name} button not found`);
            }
        };
        
        addClickListener(exportBtn, 'Export');
        addClickListener(importStudentBtn, 'Import Students');
        addClickListener(importSupervisorBtn, 'Import Supervisors');
        
        // Test modal function
        if (typeof showImportModal === 'function') {
            console.log('showImportModal function exists, testing modal creation');
            showImportModal('students'); // Test modal creation
        }
        
        // Test template function
        if (typeof downloadTemplate === 'function') {
            console.log('downloadTemplate function exists, testing template download');
            downloadTemplate('students'); // Test template download
        }
        
        // Test direct function calls
        if (typeof exportUsers === 'function') {
            console.log('exportUsers function exists, testing direct call');
            exportUsers();
        }
        
        // Test direct function calls
        if (typeof downloadTemplate === 'function') {
            console.log('downloadTemplate function exists, testing direct call');
            downloadTemplate('supervisors'); // Test supervisor template download
        }
        
        // Test direct function calls
        if (typeof showImportModal === 'function') {
            console.log('showImportModal function exists, testing modal creation');
            showImportModal('supervisors'); // Test supervisor modal creation
        }
        
        // Test direct function calls
        if (typeof exportUsers === 'function') {
            console.log('exportUsers function exists, testing direct call');
            exportUsers();
        }
    }, 1000); // Longer delay to ensure DOM is fully ready
});
    
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const userCards = document.querySelectorAll('.grid > div');
            
            userCards.forEach(card => {
                const userName = card.querySelector('h3')?.textContent.toLowerCase() || '';
                const userEmail = card.querySelector('p')?.textContent.toLowerCase() || '';
                
                if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
    
    if (roleFilter) {
        roleFilter.addEventListener('change', function(e) {
            filterUsers('role', e.target.value);
        });
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', function(e) {
            filterUsers('status', e.target.value);
        });
    }
});

function filterUsers(filterType, filterValue) {
    const userCards = document.querySelectorAll('.grid > div');
    
    userCards.forEach(card => {
        if (filterType === 'role') {
            const roleBadge = card.querySelector('.bg-purple-100, .bg-blue-100, .bg-green-100');
            const roleText = roleBadge?.textContent.toLowerCase() || '';
            
            if (filterValue === 'all' || roleText.includes(filterValue)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        } else if (filterType === 'status') {
            const statusBadge = card.querySelectorAll('.bg-green-100, .bg-yellow-100, .bg-red-100')[1];
            const statusText = statusBadge?.textContent.toLowerCase() || '';
            
            if (filterValue === 'all' || statusText.includes(filterValue)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        }
    });
}

// Show notification function (reuse from app.js)
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    // Add notification styles if not already present
    if (!document.querySelector('#notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 12px 20px;
                border-radius: 6px;
                color: white;
                font-weight: 500;
                z-index: 1000;
                animation: slideIn 0.3s ease-out;
            }
            .notification-info { background-color: #3b82f6; }
            .notification-success { background-color: #10b981; }
            .notification-warning { background-color: #f59e0b; }
            .notification-error { background-color: #ef4444; }
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }
    
    document.body.appendChild(notification);
    
    // Auto-remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Delete confirmation function
function confirmDelete(userName) {
    return confirm('Are you sure you want to delete the user "' + userName + '"? This action cannot be undone.');
}

// Import functionality
function showImportModal(type) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Import ${type === 'students' ? 'Students' : 'Supervisors'}</h3>
            <form id="importForm" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select CSV File</label>
                    <input type="file" name="csv_file" accept=".csv" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Only CSV files are allowed</p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeImportModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Import</button>
                </div>
            </form>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Handle form submission
    const form = document.getElementById('importForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        handleImport(type, form);
    });
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeImportModal();
        }
    });
}

function closeImportModal() {
    const modal = document.querySelector('.fixed.inset-0');
    if (modal) {
        modal.remove();
    }
}

// Ensure functions are globally accessible and available
window.showImportModal = showImportModal;
window.closeImportModal = closeImportModal;
window.downloadTemplate = downloadTemplate;
window.exportUsers = exportUsers;
window.handleImport = handleImport;

// Initialize all functions when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing user management functionality');
    
    // Test button clicks after a short delay to ensure DOM is ready
    setTimeout(() => {
        // Try multiple selectors for buttons
        const exportBtn = document.querySelector('button[onclick*="export"]') || 
                          document.querySelector('button[onclick*="exportUsers()"]');
        const importStudentBtn = document.querySelector('button[onclick*="showImportModal(\'students\')"]') || 
                             document.querySelector('button[onclick*="showImportModal(\'students\')"]');
        const importSupervisorBtn = document.querySelector('button[onclick*="showImportModal(\'supervisors\')"]') || 
                               document.querySelector('button[onclick*="showImportModal(\'supervisors\')"]');
        
        console.log('Button elements found:', {
            exportBtn: !!exportBtn,
            importStudentBtn: !!importStudentBtn,
            importSupervisorBtn: !!importSupervisorBtn
        });
        
        // Test click functionality with comprehensive error handling
        const addClickListener = (button, name) => {
            if (button) {
                button.addEventListener('click', () => {
                    console.log(`${name} button clicked`);
                    try {
                        if (button.onclick) {
                            eval(button.onclick);
                        } else {
                            console.error(`${name} button has no onclick handler`);
                        }
                    } catch (error) {
                        console.error(`Error executing ${name} button:`, error);
                    }
                });
            } else {
                console.error(`${name} button not found`);
            }
        };
        
        addClickListener(exportBtn, 'Export');
        addClickListener(importStudentBtn, 'Import Students');
        addClickListener(importSupervisorBtn, 'Import Supervisors');
    }, 2000); // Longer delay to ensure DOM is fully ready
});

function handleImport(type, form) {
    const formData = new FormData(form);
    const file = formData.get('csv_file');
    
    if (!file) {
        showNotification('Please select a CSV file', 'error');
        return;
    }
    
    if (!file.name.endsWith('.csv')) {
        showNotification('Please select a valid CSV file', 'error');
        return;
    }
    
    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="animate-pulse">Importing...</span>';
    submitBtn.disabled = true;
    
    // Send raw CSV file to server for processing
    const url = '/import-users';
}
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    })
    .then(response => response.json())
    .then(result => {
        closeImportModal();
        
        if (result.success) {
            let message = `Successfully imported ${result.imported} ${type}`;
            if (result.errors && result.errors.length > 0) {
                message += ` (${result.errors.length} errors skipped)`;
            }
            showNotification(message, 'success');
            
            // Refresh page to show new users
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            showNotification('Import failed: ' + (result.error || 'Unknown error'), 'error');
        }
        
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    })
    .catch(error => {
        showNotification('Upload failed: ' + error.message, 'error');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}

function createCSVContent(data) {
    if (data.length === 0) return '';
    
    const headers = Object.keys(data[0]);
    const csvRows = [headers.join(',')];
    
    data.forEach(row => {
        const values = headers.map(header => {
            const value = row[header] || '';
            return `"${value}"`;
        });
        csvRows.push(values.join(','));
    });
    
    return csvRows.join('\n');
}

function downloadTemplate(type) {
    const headers = type === 'students' 
        ? ['first_name', 'last_name', 'email', 'phone', 'gender', 'registration_number']
        : ['first_name', 'last_name', 'email', 'phone', 'gender'];
    
    const sampleData = type === 'students'
        ? ['John', 'Doe', 'john.doe@student.edu', '+255123456789', 'male', 'STU001']
        : ['Jane', 'Smith', 'jane.smith@supervisor.ac.tz', '+255987654321', 'female'];
    
    let csvContent = headers.join(',') + '\n';
    csvContent += sampleData.join(',');
    
    // Create and download CSV file
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${type}_template.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    showNotification(`${type === 'students' ? 'Student' : 'Supervisor'} template downloaded`, 'success');
}

function exportUsers() {
    // Get current filter values
    const roleFilter = document.getElementById('roleFilter')?.value || 'all';
    const statusFilter = document.getElementById('statusFilter')?.value || 'all';
    const searchQuery = document.getElementById('searchInput')?.value || '';
    
    // Show loading state
    const exportBtn = event.target;
    const originalText = exportBtn.innerHTML;
    exportBtn.disabled = true;
    exportBtn.innerHTML = `
        <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018 0 8 8 0 0116 0zm0 0a8 8 0 00-8 0v8a8 8 0 018 0z"/>
        </svg>
        Exporting...
    `;
    
    // Collect all visible user cards
    const userCards = document.querySelectorAll('.grid > div:not([style*="display: none"])');
    const userData = [];
    
    userCards.forEach(card => {
        const nameElement = card.querySelector('.text-gray-900');
        const emailElement = card.querySelector('.text-gray-500');
        const roleElement = card.querySelector('.bg-purple-100, .bg-blue-100, .bg-green-100');
        const statusElement = card.querySelectorAll('.bg-green-100, .bg-yellow-100, .bg-red-100')[1];
        
        if (nameElement && emailElement && roleElement && statusElement) {
            const name = nameElement.textContent.trim();
            const email = emailElement.textContent.trim();
            const role = roleElement.textContent.toLowerCase().replace(' accounts', '').replace(' users', '');
            const status = statusElement.textContent.toLowerCase();
            
            userData.push({
                name: name,
                email: email,
                role: role,
                status: status
            });
        }
    });
    
    // Apply filters
    let filteredData = userData;
    
    if (roleFilter !== 'all') {
        filteredData = filteredData.filter(user => user.role === roleFilter);
    }
    
    if (statusFilter !== 'all') {
        filteredData = filteredData.filter(user => user.status === statusFilter);
    }
    
    if (searchQuery) {
        const searchLower = searchQuery.toLowerCase();
        filteredData = filteredData.filter(user => 
            user.name.toLowerCase().includes(searchLower) ||
            user.email.toLowerCase().includes(searchLower)
        );
    }
    
    // Generate CSV content
    const headers = ['name', 'email', 'role', 'status'];
    let csvContent = headers.join(',') + '\n';
    
    filteredData.forEach(user => {
        csvContent += `"${user.name}","${user.email}","${user.role}","${user.status}"\n`;
    });
    
    // Create and download CSV file
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `users_export_${new Date().toISOString().split('T')[0]}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    // Reset button state
    exportBtn.disabled = false;
    exportBtn.innerHTML = originalText;
    
    showNotification(`Successfully exported ${filteredData.length} users`, 'success');
}
</script>
@endsection

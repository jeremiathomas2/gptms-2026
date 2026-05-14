@extends('layouts.app')

@section('title', 'User Management - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Page Header with Shortcuts -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
            <p class="text-gray-500">Manage all users and their roles</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <!-- Quick Action Buttons -->
            <button onclick="exportUsers()" class="px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center space-x-1 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span class="hidden sm:inline">Export</span>
            </button>
            <button onclick="importUsers()" class="px-3 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 flex items-center space-x-1 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                <span class="hidden sm:inline">Import</span>
            </button>
            <button onclick="bulkActions()" class="px-3 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 flex items-center space-x-1 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span class="hidden sm:inline">Bulk</span>
            </button>
            <button onclick="window.location.reload()" class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-1 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h1m15 2A8 8 0 005 9m0 0H9m0 0l3 9m-3-9v12m0 0l-3-9m3 9H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="hidden sm:inline">Refresh</span>
            </button>
            <button onclick="addUser()" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-1 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6a1 1 0 011 1l5 5a1 1 0 011 1V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="hidden sm:inline">Add User</span>
            </button>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-col lg:flex-row gap-4">
            <div class="flex-1">
                <input type="text" id="userSearch" placeholder="Search users by name, email, or role..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex flex-wrap gap-2">
                <select id="roleFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="student">Student</option>
                </select>
                <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="suspended">Suspended</option>
                </select>
                <div class="flex items-center border-l border-gray-300 pl-2">
                    <button onclick="setViewMode('grid')" id="gridViewBtn" class="p-2 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition-colors" title="Grid View">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </button>
                    <button onclick="setViewMode('list')" id="listViewBtn" class="p-2 rounded-lg hover:bg-gray-100 text-gray-600 transition-colors" title="List View">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
                <button onclick="clearFilters()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Clear Filters
                </button>
            </div>
        </div>
    </div>

    <!-- User Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $users->count() }}</p>
                    <p class="text-xs text-green-600 mt-1">Registered users</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4a4 4 0 110 6M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $users->where('status', 'active')->count() }}</p>
                    <p class="text-xs text-green-600 mt-1">{{ $users->count() > 0 ? round(($users->where('status', 'active')->count() / $users->count()) * 100) : 0 }}% active rate</p>
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
                    <p class="text-sm font-medium text-gray-600">Admin Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $users->filter(function($user) { return $user->hasRole('admin'); })->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">System administrators</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Students</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $users->filter(function($user) { return $user->hasRole('student'); })->count() }}</p>
                    <p class="text-xs text-blue-600 mt-1">Student accounts</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3h6m-6 3a2 2 0 00-2 2v3m0 0h6v-3m-6 3a2 2 0 00-2 2v3m0 0h6v3"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Grid -->
    <div id="usersGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($users as $user)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <img src="https://picsum.photos/seed/{{ $user->email }}/64/64.jpg" alt="{{ $user->name }}" class="w-12 h-12 sm:w-16 sm:h-16 rounded-full">
                            <div>
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                                <p class="text-xs sm:text-sm text-gray-500">{{ $user->email }}</p>
                                <div class="flex items-center space-x-2 mt-1">
                                    @if ($user->hasRole('admin'))
                                        <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded">Admin</span>
                                    @elseif ($user->hasRole('supervisor'))
                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Supervisor</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">Student</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-1">
                            <button onclick="toggleUserStatus({{ $user->id }}, '{{ $user->status ?? 'active' }}')" 
                                    class="p-2 rounded-lg hover:bg-gray-100 transition-colors" 
                                    title="Toggle Status">
                                @if($user->status == 'active')
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                @endif
                            </button>
                            <button onclick="editUserRole({{ $user->id }}, '{{ $user->roles->first()->name ?? 'student' }}')" 
                                    class="p-2 rounded-lg hover:bg-gray-100 transition-colors" 
                                    title="Edit Role">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="space-y-2 sm:space-y-3">
                        <div class="flex justify-between text-xs sm:text-sm">
                            <span class="text-gray-600">Status</span>
                            <span class="font-medium">
                                @if($user->status == 'active')
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">Inactive</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between text-xs sm:text-sm">
                            <span class="text-gray-600">Phone</span>
                            <span class="font-medium">{{ $user->phone ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex justify-between text-xs sm:text-sm">
                            <span class="text-gray-600">Gender</span>
                            <span class="font-medium">
                                @if($user->gender)
                                    {{ ucfirst($user->gender) }}
                                @else
                                    <span class="text-gray-400">Not specified</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between text-xs sm:text-sm">
                            <span class="text-gray-600">Groups</span>
                            <span class="font-medium">{{ $user->groupMemberships()->count() }} groups</span>
                        </div>
                        <div class="flex justify-between text-xs sm:text-sm">
                            <span class="text-gray-600">Last Active</span>
                            <span class="font-medium">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                        </div>
                        <div class="flex justify-between text-xs sm:text-sm">
                            <span class="text-gray-600">Joined</span>
                            <span class="font-medium">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mt-4">
                        <button onclick="viewUserDetails({{ $user->id }})" class="flex-1 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-xs sm:text-sm">View</button>
                        <button onclick="editUser({{ $user->id }})" class="flex-1 px-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-xs sm:text-sm">Edit</button>
                        <button onclick="resetPassword({{ $user->id }}, '{{ $user->name }}')" class="px-3 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 text-xs sm:text-sm">Reset</button>
                        <form action="{{ route('users.delete', $user->id) }}" method="POST" onsubmit="return confirmDelete('{{ $user->name }}')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 text-xs sm:text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-1 12a2 2 0 01-2 2H8a2 2 0 01-2-2L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m0 0h6v-1a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4a4 4 0 110 6M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                    <p class="text-gray-500">Get started by adding your first user.</p>
                    <button onclick="addUser()" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Add User
                    </button>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Users List View (Table) - Hidden by default -->
    <div id="usersList" class="hidden">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Groups</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Active</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img src="https://picsum.photos/seed/{{ $user->email }}/40/40.jpg" alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($user->hasRole('admin'))
                                    <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded">Admin</span>
                                @elseif ($user->hasRole('supervisor'))
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Supervisor</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">Student</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->status == 'active')
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->phone ?? 'Not provided' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->groupMemberships()->count() }} groups
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="viewUserDetails({{ $user->id }})" class="text-blue-600 hover:text-blue-900">View</button>
                                    <button onclick="editUser({{ $user->id }})" class="text-gray-600 hover:text-gray-900">Edit</button>
                                    <button onclick="toggleUserStatus({{ $user->id }}, '{{ $user->status ?? 'active' }}')" class="text-green-600 hover:text-green-900">Toggle</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4a4 4 0 110 6M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                                <p class="text-gray-500">Get started by adding your first user.</p>
                                <button onclick="addUser()" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Add User
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// View Mode Management
let currentViewMode = 'grid';

function setViewMode(mode) {
    currentViewMode = mode;
    const usersGrid = document.getElementById('usersGrid');
    const usersList = document.getElementById('usersList');
    const gridViewBtn = document.getElementById('gridViewBtn');
    const listViewBtn = document.getElementById('listViewBtn');
    
    if (!usersGrid || !usersList || !gridViewBtn || !listViewBtn) {
        console.error('View toggle elements not found');
        return;
    }
    
    if (mode === 'grid') {
        usersGrid.classList.remove('hidden');
        usersList.classList.add('hidden');
        gridViewBtn.classList.add('bg-blue-100', 'text-blue-600');
        gridViewBtn.classList.remove('hover:bg-gray-100', 'text-gray-600');
        listViewBtn.classList.remove('bg-blue-100', 'text-blue-600');
        listViewBtn.classList.add('hover:bg-gray-100', 'text-gray-600');
    } else {
        usersGrid.classList.add('hidden');
        usersList.classList.remove('hidden');
        listViewBtn.classList.add('bg-blue-100', 'text-blue-600');
        listViewBtn.classList.remove('hover:bg-gray-100', 'text-gray-600');
        gridViewBtn.classList.remove('bg-blue-100', 'text-blue-600');
        gridViewBtn.classList.add('hover:bg-gray-100', 'text-gray-600');
    }
    
    // Re-apply filters after switching views
    filterUsers();
}

// User Management Functions
function addUser() {
    window.location.href = '/register';
}

function viewUserDetails(userId) {
    window.location.href = `/users/${userId}`;
}

function editUser(userId) {
    window.location.href = `/users/${userId}/edit`;
}

function toggleUserStatus(userId, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const action = newStatus === 'active' ? 'activate' : 'deactivate';
    
    if (confirm(`Are you sure you want to ${action} this user?`)) {
        fetch(`/admin/users/${userId}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                window.location.reload();
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to update user status', 'error');
        });
    }
}

function editUserRole(userId, currentRole) {
    const roles = ['admin', 'supervisor', 'student'];
    const currentRoleIndex = roles.indexOf(currentRole);
    const nextRole = roles[(currentRoleIndex + 1) % roles.length];
    
    if (confirm(`Change user role from "${currentRole}" to "${nextRole}"?`)) {
        fetch(`/admin/users/${userId}/role`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify({ role: nextRole })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                window.location.reload();
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to update user role', 'error');
        });
    }
}

function resetPassword(userId, userName) {
    if (confirm(`Reset password for "${userName}"?\n\nA new temporary password will be generated and sent to their email.`)) {
        fetch(`/admin/users/${userId}/reset-password`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to reset password', 'error');
        });
    }
}

function confirmDelete(userName) {
    return confirm(`Are you sure you want to delete the user "${userName}"? This action cannot be undone.`);
}

// Shortcut Functions
function exportUsers() {
    // Enhanced export with options
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Export Options</h3>
            
            <div class="space-y-3 mb-4">
                <label class="flex items-center">
                    <input type="checkbox" id="exportActive" checked class="mr-2">
                    <span>Active Users</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" id="exportInactive" checked class="mr-2">
                    <span>Inactive Users</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" id="exportAdmin" checked class="mr-2">
                    <span>Admin Users</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" id="exportSupervisor" checked class="mr-2">
                    <span>Supervisor Users</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" id="exportStudent" checked class="mr-2">
                    <span>Student Users</span>
                </label>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</button>
                <button onclick="processExport()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Export</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

function processExport() {
    // Build export parameters based on selected options
    const params = new URLSearchParams();
    
    if (document.getElementById('exportActive').checked) params.append('status', 'active');
    if (document.getElementById('exportInactive').checked) params.append('status', 'inactive');
    if (document.getElementById('exportAdmin').checked) params.append('role', 'admin');
    if (document.getElementById('exportSupervisor').checked) params.append('role', 'supervisor');
    if (document.getElementById('exportStudent').checked) params.append('role', 'student');
    
    // Close modal and start export
    document.querySelector('.fixed').remove();
    
    // Redirect to export endpoint with parameters
    window.location.href = `/admin/users/export?${params.toString()}`;
    
    showNotification('Export started...', 'success');
}

function importUsers() {
    // Show import modal
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Import Users</h3>
            <p class="text-gray-600 mb-4">Upload a CSV file with user data (name, email, role, etc.)</p>
            <input type="file" accept=".csv" class="w-full p-2 border rounded mb-4" id="importFile">
            <div class="flex justify-end space-x-2">
                <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Cancel</button>
                <button onclick="processImport()" class="px-4 py-2 bg-blue-600 text-white rounded">Import</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

function bulkActions() {
    // Show bulk actions modal
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Bulk Actions</h3>
            <div class="space-y-2">
                <button onclick="bulkActivate()" class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Bulk Activate</button>
                <button onclick="bulkDeactivate()" class="w-full px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Bulk Deactivate</button>
                <button onclick="bulkDelete()" class="w-full px-4 py-2 bg-red-700 text-white rounded hover:bg-red-800">Bulk Delete</button>
                <button onclick="bulkRoleChange()" class="w-full px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Bulk Role Change</button>
            </div>
            <div class="mt-4">
                <button onclick="this.closest('.fixed').remove()" class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded">Cancel</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

// Search and Filter Functions
let searchTimeout;

function clearFilters() {
    const searchInput = document.getElementById('userSearch');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    
    if (searchInput) searchInput.value = '';
    if (roleFilter) roleFilter.value = '';
    if (statusFilter) statusFilter.value = '';
    
    // Clear any pending search timeout
    if (searchTimeout) {
        clearTimeout(searchTimeout);
        searchTimeout = null;
    }
    
    filterUsers();
}

function debounceSearch() {
    // Clear any pending search timeout
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }
    
    // Set new timeout for 300ms delay
    searchTimeout = setTimeout(() => {
        filterUsers();
        searchTimeout = null;
    }, 300);
}

function filterUsers() {
    const searchInput = document.getElementById('userSearch');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    
    if (!searchInput || !roleFilter || !statusFilter) {
        return;
    }
    
    const searchTerm = searchInput.value.toLowerCase().trim();
    const roleFilterValue = roleFilter.value.toLowerCase();
    const statusFilterValue = statusFilter.value.toLowerCase();
    
    // Show loading state for better UX
    showSearchLoading(true);
    
    let visibleCount = 0;
    let totalCount = 0;
    
    // Use setTimeout to prevent UI blocking during search
    setTimeout(() => {
        performFiltering(searchTerm, roleFilterValue, statusFilterValue);
        showSearchLoading(false);
    }, 10);
}

function performFiltering(searchTerm, roleFilterValue, statusFilterValue) {
    // Clear previous highlights
    clearSearchHighlights();
    
    let visibleCount = 0;
    let totalCount = 0;
    
    // Filter grid view
    const usersGrid = document.getElementById('usersGrid');
    if (usersGrid) {
        const userCards = usersGrid.children;
        for (let card of userCards) {
            if (card.classList.contains('col-span-full')) {
                card.style.display = '';
                continue;
            }
            
            totalCount++;
            
            // Get user data from card
            const userNameElement = card.querySelector('h3');
            const userEmailElement = card.querySelector('p[class*="text-gray-500"]');
            const userRoleElement = card.querySelector('span[class*="bg-purple-100"], span[class*="bg-green-100"], span[class*="bg-blue-100"]');
            const userStatusElement = card.querySelector('.space-y-2 > div:first-child span span');
            
            const userName = userNameElement ? userNameElement.textContent.toLowerCase() : '';
            const userEmail = userEmailElement ? userEmailElement.textContent.toLowerCase() : '';
            const userRole = userRoleElement ? userRoleElement.textContent.toLowerCase() : '';
            const userStatus = userStatusElement ? userStatusElement.textContent.toLowerCase() : '';
            
            // Enhanced search: search in name, email, role, and status
            const matchesSearch = !searchTerm || 
                userName.includes(searchTerm) || 
                userEmail.includes(searchTerm) || 
                userRole.includes(searchTerm) || 
                userStatus.includes(searchTerm);
            
            const matchesRole = !roleFilterValue || userRole.includes(roleFilterValue);
            const matchesStatus = !statusFilterValue || userStatus.includes(statusFilterValue);
            
            const shouldShow = matchesSearch && matchesRole && matchesStatus;
            card.style.display = shouldShow ? '' : 'none';
            
            if (shouldShow) {
                visibleCount++;
                // Highlight search terms in visible items
                if (searchTerm && userNameElement) highlightSearchTerm(userNameElement, searchTerm);
                if (searchTerm && userEmailElement) highlightSearchTerm(userEmailElement, searchTerm);
            }
        }
    }
    
    // Filter list view (table)
    const usersList = document.getElementById('usersList');
    if (usersList) {
        const tableBody = usersList.querySelector('tbody');
        if (tableBody) {
            const tableRows = tableBody.querySelectorAll('tr');
            tableRows.forEach(row => {
                totalCount++;
                
                // Get user data from table row
                const userNameElement = row.querySelector('.font-medium');
                const userEmailElement = row.querySelector('.text-gray-500');
                const userRoleElement = row.querySelector('.bg-purple-100, .bg-green-100, .bg-blue-100');
                const userStatusElement = row.querySelector('.bg-green-100, .bg-red-100');
                
                const userName = userNameElement ? userNameElement.textContent.toLowerCase() : '';
                const userEmail = userEmailElement ? userEmailElement.textContent.toLowerCase() : '';
                const userRole = userRoleElement ? userRoleElement.textContent.toLowerCase() : '';
                const userStatus = userStatusElement ? userStatusElement.textContent.toLowerCase() : '';
                
                // Enhanced search: search in name, email, role, and status
                const matchesSearch = !searchTerm || 
                    userName.includes(searchTerm) || 
                    userEmail.includes(searchTerm) || 
                    userRole.includes(searchTerm) || 
                    userStatus.includes(searchTerm);
                
                const matchesRole = !roleFilterValue || userRole.includes(roleFilterValue);
                const matchesStatus = !statusFilterValue || userStatus.includes(statusFilterValue);
                
                const shouldShow = matchesSearch && matchesRole && matchesStatus;
                row.style.display = shouldShow ? '' : 'none';
                
                if (shouldShow) {
                    visibleCount++;
                    // Highlight search terms in visible items
                    if (searchTerm && userNameElement) highlightSearchTerm(userNameElement, searchTerm);
                    if (searchTerm && userEmailElement) highlightSearchTerm(userEmailElement, searchTerm);
                }
            });
        }
    }
    
    // Show real-time search feedback
    showSearchFeedback(visibleCount, totalCount, searchTerm, roleFilterValue, statusFilterValue);
}

// Search Loading Indicator
function showSearchLoading(show) {
    const searchInput = document.getElementById('userSearch');
    if (!searchInput) return;
    
    if (show) {
        searchInput.classList.add('pl-8');
        // Use a simple spinner SVG that's properly encoded
        searchInput.style.backgroundImage = "url('data:image/svg+xml,%3Csvg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\"%3E%3Ccircle cx=\"12\" cy=\"12\" r=\"10\" stroke=\"%239CA3AF\" stroke-width=\"4\"%3E%3C/circle%3E%3Cpath fill=\"%233B82F6\" d=\"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\"%3E%3C/path%3E%3C/svg%3E')";
        searchInput.style.backgroundRepeat = 'no-repeat';
        searchInput.style.backgroundPosition = '8px center';
        searchInput.style.backgroundSize = '16px 16px';
    } else {
        searchInput.classList.remove('pl-8');
        searchInput.style.backgroundImage = '';
    }
}

// Clear Search Highlights
function clearSearchHighlights() {
    document.querySelectorAll('.search-highlight').forEach(element => {
        const parent = element.parentNode;
        parent.replaceChild(document.createTextNode(element.textContent), element);
        parent.normalize();
    });
}

// Highlight Search Terms
function highlightSearchTerm(element, searchTerm) {
    if (!searchTerm || !element) return;
    
    const text = element.textContent;
    const regex = new RegExp(`(${searchTerm})`, 'gi');
    
    if (regex.test(text)) {
        const highlightedHTML = text.replace(regex, '<span class="search-highlight bg-yellow-200 px-1 rounded">$1</span>');
        element.innerHTML = highlightedHTML;
    }
}

// Search Feedback Helper
function showSearchFeedback(visibleCount, totalCount, searchTerm, roleFilter, statusFilter) {
    // Remove existing feedback
    const existingFeedback = document.getElementById('searchFeedback');
    if (existingFeedback) {
        existingFeedback.remove();
    }
    
    // Create feedback element
    const feedback = document.createElement('div');
    feedback.id = 'searchFeedback';
    feedback.className = 'text-sm text-gray-600 mt-2 mb-4 text-center';
    
    let message = '';
    
    if (visibleCount === 0) {
        message = `<span class="text-red-600">No users found</span>`;
        if (searchTerm || roleFilter || statusFilter) {
            message += ` matching your criteria`;
        }
    } else if (searchTerm || roleFilter || statusFilter) {
        message = `Showing <span class="font-medium text-blue-600">${visibleCount}</span> of <span class="font-medium">${totalCount}</span> users`;
        
        const activeFilters = [];
        if (searchTerm) activeFilters.push(`search: "${searchTerm}"`);
        if (roleFilter) activeFilters.push(`role: ${roleFilter}`);
        if (statusFilter) activeFilters.push(`status: ${statusFilter}`);
        
        if (activeFilters.length > 0) {
            message += ` (filtered by ${activeFilters.join(', ')})`;
        }
    } else {
        // No active filters, don't show feedback
        return;
    }
    
    feedback.innerHTML = message;
    
    // Insert feedback after the search/filter bar
    const searchFilterBar = document.querySelector('.bg-white.rounded-lg.shadow.p-4');
    if (searchFilterBar && searchFilterBar.parentNode) {
        searchFilterBar.parentNode.insertBefore(feedback, searchFilterBar.nextSibling);
    }
}

// Notification Helper
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

// Initialize event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality with debouncing
    const searchInput = document.getElementById('userSearch');
    if (searchInput) {
        searchInput.addEventListener('input', debounceSearch);
        searchInput.addEventListener('keyup', function(e) {
            // Clear search on Escape key
            if (e.key === 'Escape') {
                searchInput.value = '';
                filterUsers();
            }
            // Focus search on Ctrl/Cmd+F
            if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
        });
        
        // Add visual feedback for search state
        searchInput.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-blue-500');
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-blue-500');
        });
    }
    
    // Filter functionality
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    if (roleFilter) roleFilter.addEventListener('change', filterUsers);
    if (statusFilter) statusFilter.addEventListener('change', filterUsers);
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + N: Add new user
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            addUser();
        }
        // Ctrl/Cmd + E: Export users
        if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
            e.preventDefault();
            exportUsers();
        }
        // Ctrl/Cmd + I: Import users
        if ((e.ctrlKey || e.metaKey) && e.key === 'i') {
            e.preventDefault();
            importUsers();
        }
        // Ctrl/Cmd + B: Bulk actions
        if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
            e.preventDefault();
            bulkActions();
        }
        // Ctrl/Cmd + F: Focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            searchInput?.focus();
        }
    });
});

// Additional helper functions for bulk actions
function bulkActivate() {
    if (confirm('Activate all filtered users?')) {
        // Implementation would go here
        showNotification('Bulk activation feature coming soon', 'info');
    }
}

function bulkDeactivate() {
    if (confirm('Deactivate all filtered users?')) {
        // Implementation would go here
        showNotification('Bulk deactivation feature coming soon', 'info');
    }
}

function bulkDelete() {
    if (confirm('Delete all filtered users? This action cannot be undone!')) {
        // Implementation would go here
        showNotification('Bulk deletion feature coming soon', 'info');
    }
}

function bulkRoleChange() {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Change Role for All Filtered Users</h3>
            <select class="w-full p-2 border rounded mb-4" id="bulkRoleSelect">
                <option value="admin">Admin</option>
                <option value="supervisor">Supervisor</option>
                <option value="student">Student</option>
            </select>
            <div class="flex justify-end space-x-2">
                <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Cancel</button>
                <button onclick="processBulkRoleChange()" class="px-4 py-2 bg-purple-600 text-white rounded">Change Role</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

function processImport() {
    const fileInput = document.getElementById('importFile');
    if (fileInput.files.length > 0) {
        showNotification('Import feature coming soon', 'info');
        document.querySelector('.fixed').remove();
    } else {
        alert('Please select a file to import');
    }
}

function processBulkRoleChange() {
    const role = document.getElementById('bulkRoleSelect').value;
    showNotification(`Bulk role change to "${role}" feature coming soon`, 'info');
    document.querySelector('.fixed').remove();
}

// Missing functions that were referenced in HTML
function downloadTemplate() {
    // Create CSV template for user import
    const csvContent = "Name,Email,Role,Status,Phone\nJohn Doe,john.doe@example.com,student,active,+1234567890\nJane Smith,jane.smith@example.com,supervisor,active,+1234567891\n";
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'user_import_template.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    showNotification('Template downloaded successfully', 'success');
}

function showImportModal() {
    // Enhanced import modal with file upload and template download
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-xl font-semibold mb-4">Import Users</h3>
            
            <div class="mb-6">
                <h4 class="font-medium mb-2">Instructions:</h4>
                <ol class="text-sm text-gray-600 space-y-1 list-decimal list-inside">
                    <li>Download the CSV template below</li>
                    <li>Fill in user data (name, email, role, status, phone)</li>
                    <li>Upload the completed CSV file</li>
                    <li>Click Import to process the file</li>
                </ol>
            </div>
            
            <div class="mb-4">
                <button onclick="downloadTemplate()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 mb-4">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h6a1 1 0 011 1l5 5a1 1 0 011 1V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download CSV Template
                </button>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload CSV File:</label>
                <input type="file" accept=".csv" class="w-full p-2 border rounded mb-2" id="importFile">
                <p class="text-xs text-gray-500">Supported format: CSV (Comma Separated Values)</p>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</button>
                <button onclick="processImport()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Import Users</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}
</script>
@endsection

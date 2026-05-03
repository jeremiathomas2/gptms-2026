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
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Export Users</span>
            </button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <span>Add User</span>
            </button>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
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
                    <input type="text" placeholder="Search users..." 
                           class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <select class="border border-gray-300 rounded-lg px-3 py-2">
                    <option value="all">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="student">Student</option>
                </select>
                <select class="border border-gray-300 rounded-lg px-3 py-2">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="suspended">Suspended</option>
                </select>
                <select class="border border-gray-300 rounded-lg px-3 py-2">
                    <option value="all">All Departments</option>
                    <option value="cs">Computer Science</option>
                    <option value="eng">Engineering</option>
                    <option value="business">Business</option>
                </select>
            </div>
            <div class="flex items-center space-x-2">
                <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 01-.707.293l-6.586-6.586a1 1 0 01-.293-.707V5a1 1 0 011-1H6a1 1 0 011-1V4z"/>
                    </svg>
                    <span>Grid View</span>
                </button>
                <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span>List View</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Users Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($users as $user)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="https://picsum.photos/seed/{{ $user->email }}/64/64.jpg" alt="{{ $user->name }}" class="w-16 h-16 rounded-full">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            <div class="flex items-center space-x-2 mt-1">
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
                    
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Phone</span>
                            <span class="font-medium">{{ $user->phone ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Groups</span>
                            <span class="font-medium">{{ $user->groupMemberships()->count() }} groups</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Last Active</span>
                            <span class="font-medium">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Joined</span>
                            <span class="font-medium">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="flex space-x-2 mt-4">
                        <button onclick="viewUser({{ $user->id }})" class="flex-1 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">View</button>
                        <button onclick="editUser({{ $user->id }})" class="flex-1 px-3 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">Edit</button>
                        <button onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')" class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
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
    const searchInput = document.querySelector('input[placeholder="Search users..."]');
    const roleFilter = document.querySelector('select');
    const statusFilter = document.querySelectorAll('select')[1];
    
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
</script>
@endsection

@extends('layouts.app')

@section('title', 'User Details - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">User Details</h1>
            <p class="text-gray-500">View and manage user information</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('users') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="whitespace-nowrap">Back to Users</span>
            </a>
            <a href="{{ route('users.edit', $user->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span class="whitespace-nowrap">Edit User</span>
            </a>
        </div>
    </div>

    <!-- Success Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- User Profile Card -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center space-x-6">
                <img src="https://picsum.photos/seed/{{ $user->email }}/120/120.jpg" alt="{{ $user->name }}" class="w-24 h-24 rounded-full">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-500">{{ $user->email }}</p>
                    <div class="flex items-center space-x-2 mt-2">
                        @if ($user->hasRole('admin'))
                            <span class="px-3 py-1 text-sm font-medium bg-purple-100 text-purple-800 rounded">Admin</span>
                        @elseif ($user->hasRole('supervisor'))
                            <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded">Supervisor</span>
                        @else
                            <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded">Student</span>
                        @endif
                        
                        @if ($user->status === 'active')
                            <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded">Active</span>
                        @elseif ($user->status === 'inactive')
                            <span class="px-3 py-1 text-sm font-medium bg-yellow-100 text-yellow-800 rounded">Inactive</span>
                        @else
                            <span class="px-3 py-1 text-sm font-medium bg-red-100 text-red-800 rounded">Suspended</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">First Name</span>
                            <span class="font-medium">{{ $user->first_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Last Name</span>
                            <span class="font-medium">{{ $user->last_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email</span>
                            <span class="font-medium">{{ $user->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phone</span>
                            <span class="font-medium">{{ $user->phone ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Gender</span>
                            <span class="font-medium">{{ $user->gender ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Registration Number</span>
                            <span class="font-medium">{{ $user->registration_number ?? 'Not provided' }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Account Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">User ID</span>
                            <span class="font-medium">#{{ $user->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Account Status</span>
                            <span class="font-medium">{{ ucfirst($user->status) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Member Since</span>
                            <span class="font-medium">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Last Login</span>
                            <span class="font-medium">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Last Activity</span>
                            <span class="font-medium">{{ $user->last_activity_at ? $user->last_activity_at->diffForHumans() : 'Never' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            @if ($user->bio)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Bio</h3>
                    <p class="text-gray-700">{{ $user->bio }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Groups and Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Groups -->
        @if($user->hasRole('supervisor'))
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Supervising Groups</h3>
                <p class="text-sm text-gray-500">Groups this supervisor is currently supervising</p>
            </div>
            <div class="p-6">
                @php
                    $supervisingGroups = \App\Models\Group::where('created_by', $user->id)->get();
                @endphp
                @if ($supervisingGroups->count() > 0)
                    <div class="space-y-3">
                        @foreach ($supervisingGroups as $group)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $group->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $group->description }}</p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $group->members ? $group->members->count() : 0 }} member(s) • 
                                        {{ $group->projects ? $group->projects->count() : 0 }} project(s)
                                    </p>
                                </div>
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">
                                    Supervisor
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="text-gray-500">No supervising groups found</p>
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                <p class="text-sm text-gray-500">Latest actions and updates</p>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <div>
                            <p class="text-sm text-gray-900">Account created</p>
                            <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @if ($user->last_login_at)
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <div>
                                <p class="text-sm text-gray-900">Last login</p>
                                <p class="text-xs text-gray-500">{{ $user->last_login_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($user->last_activity_at)
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                            <div>
                                <p class="text-sm text-gray-900">Last activity</p>
                                <p class="text-xs text-gray-500">{{ $user->last_activity_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

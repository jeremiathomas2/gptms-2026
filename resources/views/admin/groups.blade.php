@extends('layouts.app')

@section('title', 'Groups Management - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Groups Management</h1>
            <p class="text-gray-500">View all groups, members, and supervisor information</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="exportGroups()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <span>Export</span>
            </button>
            <a href="{{ route('admin.group-settings') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>Group Settings</span>
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Groups</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $groups->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Members</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalMembers }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Supervisors</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $supervisors->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Avg. Group Size</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $groups->count() > 0 ? round($totalMembers / $groups->count(), 1) : 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" id="search-input" placeholder="Search groups, members, or supervisors..." 
                           class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <select id="status-filter" class="border border-gray-300 rounded-lg px-3 py-2">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="forming">Forming</option>
                    <option value="completed">Completed</option>
                    <option value="archived">Archived</option>
                </select>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="setViewMode('grid')" id="grid-view-btn" class="p-2 rounded-lg bg-blue-100 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </button>
                <button onclick="setViewMode('list')" id="list-view-btn" class="p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Groups Grid View -->
    <div id="groups-grid" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($groups as $group)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                <!-- Group Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $group->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $group->description ?? 'No description' }}</p>
                        </div>
                        <div class="flex space-x-1">
                            <span class="px-2 py-1 text-xs font-medium rounded 
                                {{ $group->status === 'active' ? 'bg-green-100 text-green-800' : 
                                   ($group->status === 'forming' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($group->status === 'completed' ? 'bg-blue-100 text-blue-800' : 
                                   'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($group->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Group Stats -->
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span>{{ $group->activeMembers()->count() }}/{{ $group->max_members ?? '∞' }} members</span>
                        </div>
                        @if($group->project)
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span>{{ $group->project->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Supervisor Information -->
                @if($group->creator)
                    <div class="p-4 bg-blue-50 border-b border-blue-100">
                        <h4 class="text-sm font-semibold text-blue-900 mb-2">Supervisor</h4>
                        <div class="flex items-center space-x-3">
                            <img src="https://picsum.photos/seed/{{ $group->creator->email }}/40/40.jpg" 
                                 alt="{{ $group->creator->name }}" 
                                 class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-blue-900">{{ $group->creator->name }}</p>
                                <p class="text-xs text-blue-600">{{ $group->creator->email }}</p>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded">
                                        {{ $group->creator->roles->first()->name ?? 'No role' }}
                                    </span>
                                    <span class="text-xs text-blue-600">
                                        {{ $group->creator->phone ?? 'No phone' }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex space-x-1">
                                <a href="{{ route('users.show', $group->creator->id) }}" 
                                   class="p-1 text-blue-600 hover:text-blue-800" 
                                   title="View Profile">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <button onclick="sendEmail('{{ $group->creator->email }}')" 
                                        class="p-1 text-blue-600 hover:text-blue-800" 
                                        title="Send Email">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Group Members -->
                <div class="p-4">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="text-sm font-semibold text-gray-900">Group Members</h4>
                        <span class="text-xs text-gray-500">{{ $group->activeMembers()->count() }} active</span>
                    </div>
                    
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @foreach($group->activeMembers()->with('user')->get() as $member)
                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <img src="https://picsum.photos/seed/{{ $member->user->email }}/32/32.jpg" 
                                         alt="{{ $member->user->name }}" 
                                         class="w-8 h-8 rounded-full">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $member->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $member->user->email }}</p>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="text-xs bg-gray-100 text-gray-700 px-1.5 py-0.5 rounded">
                                                {{ ucfirst($member->role) }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                {{ $member->user->gender ?? 'Not specified' }}
                                            </span>
                                            @if($member->user->registration_number)
                                                <span class="text-xs text-gray-500">
                                                    Reg: {{ $member->user->registration_number }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <a href="{{ route('users.show', $member->user->id) }}" 
                                       class="p-1 text-gray-400 hover:text-gray-600" 
                                       title="View Profile">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <button onclick="sendEmail('{{ $member->user->email }}')" 
                                            class="p-1 text-gray-400 hover:text-gray-600" 
                                            title="Send Email">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                        
                        @if($group->activeMembers()->count() === 0)
                            <div class="text-center py-4 text-gray-500">
                                <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <p class="text-sm">No active members</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Group Actions -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-xs text-gray-500">
                            Created: {{ $group->created_at->format('M d, Y') }}
                            @if($group->formed_at)
                                • Formed: {{ $group->formed_at->format('M d, Y') }}
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="viewGroupDetails({{ $group->id }})" 
                                    class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">
                                View Details
                            </button>
                            <button onclick="editGroup({{ $group->id }})" 
                                    class="px-3 py-1 text-xs bg-gray-600 text-white rounded hover:bg-gray-700">
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Groups List View (Hidden by default) -->
    <div id="groups-list" class="hidden">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Group</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supervisor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Members</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($groups as $group)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $group->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $group->description ?? 'No description' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($group->creator)
                                    <div class="flex items-center">
                                        <img src="https://picsum.photos/seed/{{ $group->creator->email }}/32/32.jpg" 
                                             alt="{{ $group->creator->name }}" 
                                             class="w-8 h-8 rounded-full">
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $group->creator->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $group->creator->email }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-500">No supervisor</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $group->activeMembers()->count() }}/{{ $group->max_members ?? '∞' }}</div>
                                <div class="text-xs text-gray-500">active members</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $group->status === 'active' ? 'bg-green-100 text-green-800' : 
                                       ($group->status === 'forming' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($group->status === 'completed' ? 'bg-blue-100 text-blue-800' : 
                                       'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst($group->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $group->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="viewGroupDetails({{ $group->id }})" class="text-blue-600 hover:text-blue-900">View</button>
                                    <button onclick="editGroup({{ $group->id }})" class="text-gray-600 hover:text-gray-900">Edit</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($groups->count() === 0)
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No groups found</h3>
            <p class="text-gray-500 mb-4">Get started by creating your first group or adjusting the group settings.</p>
            <a href="{{ route('admin.group-settings') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Configure Group Settings
            </a>
        </div>
    @endif
</div>

<!-- Group Details Modal -->
<div id="group-details-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div id="group-details-content">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentViewMode = 'grid';

function setViewMode(mode) {
    currentViewMode = mode;
    const gridView = document.getElementById('groups-grid');
    const listView = document.getElementById('groups-list');
    const gridBtn = document.getElementById('grid-view-btn');
    const listBtn = document.getElementById('list-view-btn');
    
    if (mode === 'grid') {
        gridView.classList.remove('hidden');
        listView.classList.add('hidden');
        gridBtn.classList.add('bg-blue-100', 'text-blue-600');
        gridBtn.classList.remove('hover:bg-gray-100');
        listBtn.classList.remove('bg-blue-100', 'text-blue-600');
        listBtn.classList.add('hover:bg-gray-100');
    } else {
        gridView.classList.add('hidden');
        listView.classList.remove('hidden');
        listBtn.classList.add('bg-blue-100', 'text-blue-600');
        listBtn.classList.remove('hover:bg-gray-100');
        gridBtn.classList.remove('bg-blue-100', 'text-blue-600');
        gridBtn.classList.add('hover:bg-gray-100');
    }
}

function viewGroupDetails(groupId) {
    fetch(`/admin/groups/${groupId}/details`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('group-details-content').innerHTML = data.html;
                document.getElementById('group-details-modal').classList.remove('hidden');
            } else {
                showNotification('Error loading group details', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error loading group details', 'error');
        });
}

function editGroup(groupId) {
    window.location.href = `/groups/${groupId}/edit`;
}

function sendEmail(email) {
    window.location.href = `mailto:${email}`;
}

function exportGroups() {
    window.location.href = '/admin/groups/export';
}

// Search functionality
document.getElementById('search-input')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const statusFilter = document.getElementById('status-filter').value;
    filterGroups(searchTerm, statusFilter);
});

document.getElementById('status-filter')?.addEventListener('change', function(e) {
    const searchTerm = document.getElementById('search-input').value.toLowerCase();
    const statusFilter = e.target.value;
    filterGroups(searchTerm, statusFilter);
});

function filterGroups(searchTerm, statusFilter) {
    const groups = document.querySelectorAll('[data-group-id]');
    
    groups.forEach(group => {
        const groupData = JSON.parse(group.getAttribute('data-group-info') || '{}');
        const matchesSearch = !searchTerm || 
            groupData.name?.toLowerCase().includes(searchTerm) ||
            groupData.description?.toLowerCase().includes(searchTerm) ||
            groupData.supervisor?.toLowerCase().includes(searchTerm) ||
            groupData.members?.some(member => member.toLowerCase().includes(searchTerm));
            
        const matchesStatus = statusFilter === 'all' || groupData.status === statusFilter;
        
        if (matchesSearch && matchesStatus) {
            group.style.display = '';
        } else {
            group.style.display = 'none';
        }
    });
}

// Close modal when clicking outside
document.getElementById('group-details-modal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});

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
</script>
@endsection

@extends('layouts.app')

@section('title', 'Group Details - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $group->name }}</h1>
            <p class="text-gray-500">{{ $group->description ?? 'Group project details' }}</p>
        </div>
        @if(session('user.role') !== 'student')
        <div class="flex space-x-3">
            <button class="btn btn-secondary flex items-center space-x-2">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                <span>Export Group</span>
            </button>
            <button class="btn btn-primary flex items-center space-x-2">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Edit Group</span>
            </button>
        </div>
        @endif
    </div>

    <!-- Group Information -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Group Information</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Group Number</dt>
                        <dd class="text-sm text-gray-900">{{ $group->id }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created</dt>
                        <dd class="text-sm text-gray-900">{{ $group->created_at->format('M d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="text-sm">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                        </dd>
                    </div>
                </dl>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Group Statistics</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Total Members</dt>
                        <dd class="text-sm text-gray-900">{{ $group->members ? $group->members->count() : 0 }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Projects</dt>
                        <dd class="text-sm text-gray-900">0</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tasks</dt>
                        <dd class="text-sm text-gray-900">0</dd>
                    </div>
                </dl>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                <div class="space-y-2">
                    <div class="text-sm text-gray-500">
                        <span class="font-medium text-gray-900">Group created</span> - {{ $group->created_at->diffForHumans() }}
                    </div>
                    <div class="text-sm text-gray-500">
                        <span class="font-medium text-gray-900">No recent activity</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Supervisor Information -->
    @if($group->creator)
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Group Supervisor</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center space-x-4">
                    <img src="https://picsum.photos/seed/{{ $group->creator->email }}/64/64.jpg" 
                         alt="{{ $group->creator->name }}" 
                         class="w-16 h-16 rounded-full border-2 border-purple-200">
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-900">{{ $group->creator->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $group->creator->email }}</p>
                        <div class="flex items-center space-x-3 mt-2">
                            <span class="px-3 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">
                                {{ $group->creator->roles->first()->name ?? 'Supervisor' }}
                            </span>
                            @if($group->creator->phone)
                                <span class="text-sm text-gray-500">
                                    📞 {{ $group->creator->phone }}
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-2 mt-3">
                            <a href="mailto:{{ $group->creator->email }}" 
                               class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Contact Supervisor
                            </a>
                            @if(isset($group->creator->profile->office_hours))
                                <span class="text-xs text-gray-500 bg-gray-100 px-3 py-2 rounded-lg">
                                    🕐 Office Hours: {{ $group->creator->profile->office_hours }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                @if(isset($group->creator->profile->bio) || isset($group->creator->profile->expertise))
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h5 class="text-sm font-semibold text-gray-900 mb-3">About Supervisor</h5>
                        @if(isset($group->creator->profile->bio))
                            <p class="text-sm text-gray-600 mb-3">{{ $group->creator->profile->bio }}</p>
                        @endif
                        @if(isset($group->creator->profile->expertise))
                            <div class="flex flex-wrap gap-2">
                                <span class="text-xs text-gray-500">Expertise:</span>
                                @foreach(explode(',', $group->creator->profile->expertise) as $skill)
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                        {{ trim($skill) }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Group Members -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Group Members</h3>
        </div>
        <div class="p-6">
            @if($group->members && $group->members->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($group->members as $member)
                        <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                            <div class="w-10 h-10 bg-{{ ['blue', 'green', 'purple', 'teal', 'orange', 'cyan'][$loop->index % 6] }}-500 rounded-full flex items-center justify-center text-white font-medium">
                                {{ substr($member->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $member->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $member->user->email }}</p>
                                <p class="text-xs text-gray-400">Joined {{ $member->joined_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No members yet</h3>
                    <p class="mt-1 text-sm text-gray-500">This group doesn't have any members yet.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Group Projects -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Group Projects</h3>
                @if(session('user.role') !== 'student')
                <button class="btn btn-primary btn-sm">Create Project</button>
                @endif
            </div>
        </div>
        <div class="p-6">
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No projects yet</h3>
                <p class="mt-1 text-sm text-gray-500">This group hasn't started any projects yet.</p>
            </div>
        </div>
    </div>
</div>
@endsection

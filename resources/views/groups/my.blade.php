@extends('layouts.app')

@section('title', 'My Groups - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My group</h1>
            <p class="text-gray-500">Group you are a member of or manage</p>
        </div>
        @if(session('user.role') !== 'student')
        <div class="flex space-x-3">
            <button class="btn btn-secondary flex items-center space-x-2">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                <span>Import Groups</span>
            </button>
            <button class="btn btn-primary flex items-center space-x-2">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Create New Group</span>
            </button>
        </div>
        @endif
    </div>

    <!-- Check if user has groups -->
    @if($userGroups->isEmpty())
        <!-- Enhanced No Groups Message -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <div class="text-center">
                <!-- Animated Icon -->
                <div class="w-24 h-24 bg-gradient-to-br from-blue-50 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-blue-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                
                <!-- Main Message -->
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Your group is not yet generated</h3>
                <p class="text-gray-600 text-lg mb-8 max-w-2xl mx-auto">
                    Groups will be automatically created by the administrator based on your skills and preferences. This process ensures balanced and effective team formation.
                </p>
                
                @if(session('user.role') === 'student')
                    <!-- Student Information Box -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6 max-w-2xl mx-auto mb-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <h4 class="text-lg font-semibold text-blue-900 mb-2">What's happening?</h4>
                                <div class="space-y-3">
                                    <p class="text-blue-700">
                                        The administrator is setting up groups based on student skills, experience levels, and preferences. This process happens automatically after the countdown timer ends.
                                    </p>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                        <div class="bg-white rounded-lg p-3 border border-blue-100">
                                            <div class="text-2xl mb-1">🎯</div>
                                            <h5 class="font-medium text-blue-900 text-sm">Skills Matching</h5>
                                            <p class="text-xs text-blue-600 mt-1">Groups balanced by technical abilities</p>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 border border-blue-100">
                                            <div class="text-2xl mb-1">⚖️</div>
                                            <h5 class="font-medium text-blue-900 text-sm">Fair Distribution</h5>
                                            <p class="text-xs text-blue-600 mt-1">Equal opportunity for all students</p>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 border border-blue-100">
                                            <div class="text-2xl mb-1">🤝</div>
                                            <h5 class="font-medium text-blue-900 text-sm">Team Success</h5>
                                            <p class="text-xs text-blue-600 mt-1">Optimized for project outcomes</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Steps -->
                    <div class="bg-gray-50 rounded-lg p-6 max-w-2xl mx-auto">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Next Steps:</h4>
                        <div class="space-y-3 text-left">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="text-gray-700">Complete your skills survey if not already done</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-gray-700">Wait for the countdown timer to complete</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <span class="text-gray-700">Check back here for your group assignment</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- Enhanced Groups Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($userGroups as $group)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <!-- Group Header -->
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $group->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $group->description ?? 'Collaborative project group' }}</p>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Active</span>
                        </div>
                        
                        <!-- Group Members -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex -space-x-3">
                                    @if($group->members && $group->members->count() > 0)
                                        @for($i = 0; $i < min(4, $group->members->count()); $i++)
                                            <div class="w-10 h-10 bg-{{ ['blue', 'green', 'purple', 'teal', 'orange', 'cyan', 'pink', 'indigo'][$i % 8] }}-500 rounded-full flex items-center justify-center text-white font-semibold border-2 border-white shadow-sm">
                                                {{ substr($group->members[$i]->user->name, 0, 1) }}
                                            </div>
                                        @endfor
                                        @if($group->members->count() > 4)
                                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-semibold border-2 border-white shadow-sm">
                                                +{{ $group->members->count() - 4 }}
                                            </div>
                                        @endif
                                    @else
                                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-semibold border-2 border-white shadow-sm">
                                            --
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $group->members ? $group->members->count() : 0 }}</p>
                                    <p class="text-xs text-gray-500">members</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Group Body -->
                    <div class="p-6 space-y-4">
                        <!-- Group Stats -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <div class="text-2xl font-bold text-gray-900">{{ $group->id }}</div>
                                <div class="text-xs text-gray-500">Group ID</div>
                            </div>
                            <div class="bg-blue-50 rounded-lg p-3 text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $group->created_at->format('M d') }}</div>
                                <div class="text-xs text-gray-500">Created</div>
                            </div>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center space-x-2 text-sm text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $group->created_at->diffForHumans() }}</span>
                            </div>
                            <a href="{{ route('groups.show', $group->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                <span>View Details</span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('title', 'My Groups - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Groups</h1>
            <p class="text-gray-500">Groups you are a member of or manage</p>
        </div>
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
    </div>

    <!-- Groups Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Group Card 1 -->
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Development Team Alpha</h3>
                        <p class="text-sm text-gray-500">E-commerce Platform</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                </div>
            </div>
            <div class="card-body">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">JD</div>
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-medium">AS</div>
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm font-medium">MK</div>
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-sm font-medium">+3</div>
                    </div>
                    <span class="text-sm text-gray-500">6 members</span>
                </div>
                
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Progress</span>
                        <span class="font-medium">75%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <span>Next meeting: Tomorrow, 2:00 PM</span>
                    <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary w-full">View Details</button>
            </div>
        </div>

        <!-- Group Card 2 -->
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Research Squad</h3>
                        <p class="text-sm text-gray-500">Data Research Project</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                </div>
            </div>
            <div class="card-body">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white text-sm font-medium">RT</div>
                        <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center text-white text-sm font-medium">LW</div>
                        <div class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center text-white text-sm font-medium">KP</div>
                    </div>
                    <span class="text-sm text-gray-500">3 members</span>
                </div>
                
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Progress</span>
                        <span class="font-medium">30%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-600 h-2 rounded-full" style="width: 30%"></div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <span>Next meeting: Friday, 10:00 AM</span>
                    <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary w-full">View Details</button>
            </div>
        </div>

        <!-- Group Card 3 -->
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Mobile Innovators</h3>
                        <p class="text-sm text-gray-500">Mobile App Development</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Planning</span>
                </div>
            </div>
            <div class="card-body">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 bg-teal-500 rounded-full flex items-center justify-center text-white text-sm font-medium">MJ</div>
                        <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white text-sm font-medium">SC</div>
                        <div class="w-8 h-8 bg-cyan-500 rounded-full flex items-center justify-center text-white text-sm font-medium">NB</div>
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-sm font-medium">+2</div>
                    </div>
                    <span class="text-sm text-gray-500">5 members</span>
                </div>
                
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Progress</span>
                        <span class="font-medium">15%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 15%"></div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <span>Next meeting: Monday, 3:30 PM</span>
                    <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary w-full">View Details</button>
            </div>
        </div>
    </div>

    <!-- Empty State (hidden when groups exist) -->
    <div class="text-center py-12 hidden">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No groups yet</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by creating a new group.</p>
        <div class="mt-6">
            <button class="btn btn-primary">Create Group</button>
        </div>
    </div>
</div>
@endsection

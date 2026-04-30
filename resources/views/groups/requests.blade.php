@extends('layouts.app')

@section('title', 'Group Requests - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Group Requests</h1>
            <p class="text-gray-500">Manage membership requests and invitations</p>
        </div>
        <div class="flex space-x-3">
            <button class="btn btn-secondary flex items-center space-x-2">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>Refresh</span>
            </button>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-lg shadow">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <button class="px-4 py-2 border-b-2 border-blue-500 text-blue-600 font-medium">
                    Incoming Requests
                    <span class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-600 rounded-full">3</span>
                </button>
                <button class="px-4 py-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium">
                    Sent Requests
                    <span class="ml-2 px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">2</span>
                </button>
                <button class="px-4 py-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium">
                    Invitations
                    <span class="ml-2 px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">5</span>
                </button>
            </nav>
        </div>

        <!-- Incoming Requests Tab -->
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Incoming Membership Requests</h3>
            
            <!-- Request Item 1 -->
            <div class="border rounded-lg p-4 mb-4">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-medium">
                            JD
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">John Doe</h4>
                            <p class="text-sm text-gray-500">john.doe@example.com</p>
                            <p class="text-sm text-gray-600 mt-1">Wants to join <strong>Development Team Alpha</strong></p>
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                <span>Requested 2 hours ago</span>
                                <span>Role: Developer</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="btn btn-secondary btn-sm">View Profile</button>
                        <button class="btn btn-primary btn-sm">Accept</button>
                        <button class="btn btn-secondary btn-sm">Reject</button>
                    </div>
                </div>
            </div>

            <!-- Request Item 2 -->
            <div class="border rounded-lg p-4 mb-4">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-medium">
                            AS
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Alice Smith</h4>
                            <p class="text-sm text-gray-500">alice.smith@example.com</p>
                            <p class="text-sm text-gray-600 mt-1">Wants to join <strong>Research Squad</strong></p>
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                <span>Requested 1 day ago</span>
                                <span>Role: Data Analyst</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="btn btn-secondary btn-sm">View Profile</button>
                        <button class="btn btn-primary btn-sm">Accept</button>
                        <button class="btn btn-secondary btn-sm">Reject</button>
                    </div>
                </div>
            </div>

            <!-- Request Item 3 -->
            <div class="border rounded-lg p-4 mb-4">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white font-medium">
                            MK
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Mike Johnson</h4>
                            <p class="text-sm text-gray-500">mike.johnson@example.com</p>
                            <p class="text-sm text-gray-600 mt-1">Wants to join <strong>Mobile Innovators</strong></p>
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                <span>Requested 3 days ago</span>
                                <span>Role: UI Designer</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button class="btn btn-secondary btn-sm">View Profile</button>
                        <button class="btn btn-primary btn-sm">Accept</button>
                        <button class="btn btn-secondary btn-sm">Reject</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sent Requests Section (Hidden by default) -->
    <div class="bg-white rounded-lg shadow p-6 hidden">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Your Sent Requests</h3>
        
        <div class="border rounded-lg p-4 mb-4">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-4">
                    <div class="w-10 h-10 bg-gray-400 rounded-full flex items-center justify-center text-white font-medium">
                        RT
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Request to join Data Analytics Team</h4>
                        <p class="text-sm text-gray-500">Sent 2 days ago</p>
                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                            <span>Status: Pending</span>
                            <span>Requested role: Data Scientist</span>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button class="btn btn-secondary btn-sm">Withdraw</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Invitations Section (Hidden by default) -->
    <div class="bg-white rounded-lg shadow p-6 hidden">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Group Invitations</h3>
        
        <div class="border rounded-lg p-4 mb-4">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-4">
                    <div class="w-10 h-8 bg-blue-600 rounded flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Invitation to join Backend Development Team</h4>
                        <p class="text-sm text-gray-500">Invited by Sarah Chen</p>
                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                            <span>Invited 1 week ago</span>
                            <span>Role: Backend Developer</span>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button class="btn btn-primary btn-sm">Accept</button>
                    <button class="btn btn-secondary btn-sm">Decline</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tab switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('nav button');
    const tabContents = document.querySelectorAll('.bg-white.rounded-lg.shadow');
    
    tabs.forEach((tab, index) => {
        tab.addEventListener('click', function() {
            // Remove active states
            tabs.forEach(t => {
                t.classList.remove('border-blue-500', 'text-blue-600');
                t.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Add active state to clicked tab
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-blue-500', 'text-blue-600');
            
            // Hide all tab contents
            tabContents.forEach(content => content.classList.add('hidden'));
            
            // Show selected tab content
            if (index === 0) {
                tabContents[0].classList.remove('hidden');
            } else if (index === 1) {
                tabContents[1].classList.remove('hidden');
            } else if (index === 2) {
                tabContents[2].classList.remove('hidden');
            }
        });
    });
});
</script>
@endsection

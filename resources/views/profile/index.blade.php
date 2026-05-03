@extends('layouts.app')

@section('title', 'Profile - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Profile</h1>
            <p class="text-gray-500">Manage your personal information and preferences</p>
        </div>
        <div class="flex space-x-3">
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Export Profile</span>
            </button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Save Changes</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Overview -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center">
                    <div class="relative inline-block">
                        <img src="https://picsum.photos/seed/{{ session('user.email') ?? 'profile' }}/120/120.jpg" alt="Profile" class="w-32 h-32 rounded-full mx-auto">
                        <button class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                    <h2 class="mt-4 text-xl font-semibold text-gray-900">{{ session('user.name') ?? 'User Name' }}</h2>
                    <p class="text-sm text-gray-500">{{ session('user.email') ?? 'user@example.com' }}</p>
                    <div class="mt-4 flex items-center justify-center space-x-2">
                        @if(session('user.role'))
                            @if(session('user.role') === 'admin')
                                <span class="px-3 py-1 text-sm font-medium bg-purple-100 text-purple-800 rounded">Admin</span>
                            @elseif(session('user.role') === 'supervisor')
                                <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded">Supervisor</span>
                            @else
                                <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded">Student</span>
                            @endif
                        @endif
                        <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded">Active</span>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Member Since</span>
                        <span class="font-medium">January 15, 2024</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Department</span>
                        <span class="font-medium">Computer Science</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Groups</span>
                        <span class="font-medium">3 active groups</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Projects</span>
                        <span class="font-medium">8 completed</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Last Login</span>
                        <span class="font-medium">2 hours ago</span>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Quick Stats</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">12</div>
                            <div class="text-xs text-gray-500">Projects</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">87%</div>
                            <div class="text-xs text-gray-500">Completion</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">4.8</div>
                            <div class="text-xs text-gray-500">Rating</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600">156</div>
                            <div class="text-xs text-gray-500">Hours</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skills -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Skills & Expertise</h3>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded-full">JavaScript</span>
                    <span class="px-3 py-1 text-sm bg-green-100 text-green-800 rounded-full">React</span>
                    <span class="px-3 py-1 text-sm bg-purple-100 text-purple-800 rounded-full">Node.js</span>
                    <span class="px-3 py-1 text-sm bg-yellow-100 text-yellow-800 rounded-full">Python</span>
                    <span class="px-3 py-1 text-sm bg-red-100 text-red-800 rounded-full">TypeScript</span>
                    <span class="px-3 py-1 text-sm bg-indigo-100 text-indigo-800 rounded-full">MongoDB</span>
                    <span class="px-3 py-1 text-sm bg-pink-100 text-pink-800 rounded-full">Docker</span>
                    <span class="px-3 py-1 text-sm bg-gray-100 text-gray-800 rounded-full">Git</span>
                </div>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>
                </div>
                <div class="p-6">
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                <input type="text" value="John" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                <input type="text" value="Doe" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" value="john.doe@university.edu" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" value="+1 (555) 123-4567" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                            <textarea rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tell us about yourself...">Experienced software developer with a passion for building scalable web applications. Specialized in React, Node.js, and cloud technologies.</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                                <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option>Computer Science</option>
                                    <option>Engineering</option>
                                    <option>Business</option>
                                    <option>Mathematics</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option>Admin</option>
                                    <option>Supervisor</option>
                                    <option>Student</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Security Settings</h3>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Change Password</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                <input type="password" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <input type="password" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                <input type="password" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update Password</button>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Two-Factor Authentication</h4>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-900">Enable 2FA for added security</p>
                                <p class="text-xs text-gray-500">Receive a code on your phone when signing in</p>
                            </div>
                            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Enable</button>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Active Sessions</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Chrome on Windows</p>
                                        <p class="text-xs text-gray-500">Current session</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Active</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Safari on iPhone</p>
                                        <p class="text-xs text-gray-500">Last active 2 days ago</p>
                                    </div>
                                </div>
                                <button class="text-red-600 hover:text-red-800 text-sm">Revoke</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Preferences -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Notification Preferences</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Email Notifications</p>
                            <p class="text-xs text-gray-500">Receive email updates about your activity</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Push Notifications</p>
                            <p class="text-xs text-gray-500">Receive push notifications on your devices</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Group Messages</p>
                            <p class="text-xs text-gray-500">Get notified about new messages in your groups</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Project Updates</p>
                            <p class="text-xs text-gray-500">Get notified about project status changes</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

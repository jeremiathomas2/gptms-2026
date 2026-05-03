@extends('layouts.app')

@section('title', 'Settings - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Success Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
            <p class="text-gray-500">Manage your account settings and preferences</p>
        </div>
        <div class="flex space-x-3">
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>Reset to Defaults</span>
            </button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Save Changes</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Settings Navigation -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-4">
                <nav class="space-y-2">
                    <button class="w-full text-left px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg">General</button>
                    <button class="w-full text-left px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Appearance</button>
                    <button class="w-full text-left px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Notifications</button>
                    <button class="w-full text-left px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Privacy</button>
                    <button class="w-full text-left px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Security</button>
                    <button class="w-full text-left px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Integrations</button>
                    <button class="w-full text-left px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Advanced</button>
                </nav>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="lg:col-span-3 space-y-6">
            <!-- Profile Settings -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Profile Information</h3>
                    <p class="text-sm text-gray-500 mt-1">Update your personal information</p>
                </div>
                <form class="p-6 space-y-6" action="/settings/profile" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                            <input type="text" name="first_name" value="{{ session('user.first_name') ?? '' }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Enter your first name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                            <input type="text" name="last_name" value="{{ session('user.last_name') ?? '' }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Enter your last name">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ session('user.email') ?? '' }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Enter your email address">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" name="phone" value="{{ session('user.phone') ?? '' }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Enter your phone number">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Registration Number</label>
                        <input type="text" name="registration_number" value="{{ session('user.registration_number') ?? '' }}" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Enter your registration number" readonly>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Save Profile Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Settings -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Security Settings</h3>
                    <p class="text-sm text-gray-500 mt-1">Manage your password and security preferences</p>
                </div>
                <form class="p-6 space-y-6" action="/settings/password" method="POST">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                        <input type="password" name="current_password" 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Enter your current password" required>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                            <input type="password" name="new_password" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Enter your new password" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Confirm your new password" required>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Notification Settings -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Notification Preferences</h3>
                    <p class="text-sm text-gray-500 mt-1">Choose how you want to receive notifications</p>
                </div>
                <form class="p-6 space-y-6" action="/settings/notifications" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Email Notifications</p>
                                <p class="text-xs text-gray-500">Receive notifications via email</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="email_notifications" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Group Invitations</p>
                                <p class="text-xs text-gray-500">Get notified when invited to join a group</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="group_invitations" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Project Updates</p>
                                <p class="text-xs text-gray-500">Receive updates about project changes</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="project_updates" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">System Messages</p>
                                <p class="text-xs text-gray-500">Receive important system announcements</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="system_messages" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Save Notification Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Settings functionality
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submissions with AJAX
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const url = form.action;
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            
            // Show loading state
            submitButton.textContent = 'Saving...';
            submitButton.disabled = true;
            
            // Simulate API call (replace with actual fetch)
            setTimeout(() => {
                submitButton.textContent = 'Saved!';
                submitButton.classList.add('bg-green-600');
                submitButton.classList.remove('bg-blue-600');
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    submitButton.textContent = originalText;
                    submitButton.disabled = false;
                    submitButton.classList.remove('bg-green-600');
                    submitButton.classList.add('bg-blue-600');
                }, 2000);
            }, 1000);
        });
    });
    
    // Navigation tabs functionality
    const navButtons = document.querySelectorAll('nav button');
    navButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            navButtons.forEach(btn => {
                btn.classList.remove('text-blue-600', 'bg-blue-50');
                btn.classList.add('text-gray-700');
            });
            
            // Add active class to clicked button
            this.classList.remove('text-gray-700');
            this.classList.add('text-blue-600', 'bg-blue-50');
        });
    });
});
</script>

            <!-- Appearance Settings -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Appearance</h3>
                    <p class="text-sm text-gray-500 mt-1">Customize the look and feel of your interface</p>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Theme</label>
                        <div class="grid grid-cols-3 gap-4">
                            <label class="relative">
                                <input type="radio" name="theme" value="light" checked class="sr-only peer">
                                <div class="w-full p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                    <div class="w-full h-16 bg-white border border-gray-300 rounded mb-2"></div>
                                    <p class="text-sm font-medium text-center">Light</p>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="theme" value="dark" class="sr-only peer">
                                <div class="w-full p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                    <div class="w-full h-16 bg-gray-900 border border-gray-700 rounded mb-2"></div>
                                    <p class="text-sm font-medium text-center">Dark</p>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="theme" value="auto" class="sr-only peer">
                                <div class="w-full p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                    <div class="w-full h-16 bg-gradient-to-r from-white to-gray-900 border border-gray-300 rounded mb-2"></div>
                                    <p class="text-sm font-medium text-center">Auto</p>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Accent Color</label>
                        <div class="flex space-x-2">
                            <button class="w-8 h-8 bg-blue-600 rounded-full border-2 border-gray-300"></button>
                            <button class="w-8 h-8 bg-green-600 rounded-full border-2 border-transparent"></button>
                            <button class="w-8 h-8 bg-purple-600 rounded-full border-2 border-transparent"></button>
                            <button class="w-8 h-8 bg-red-600 rounded-full border-2 border-transparent"></button>
                            <button class="w-8 h-8 bg-yellow-600 rounded-full border-2 border-transparent"></button>
                            <button class="w-8 h-8 bg-pink-600 rounded-full border-2 border-transparent"></button>
                            <button class="w-8 h-8 bg-gray-600 rounded-full border-2 border-transparent"></button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Font Size</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Small</option>
                            <option selected>Medium</option>
                            <option>Large</option>
                            <option>Extra Large</option>
                        </select>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Sidebar Collapsed</p>
                            <p class="text-xs text-gray-500">Keep sidebar collapsed by default</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
                    <p class="text-sm text-gray-500 mt-1">Manage your notification preferences</p>
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
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">System Updates</p>
                            <p class="text-xs text-gray-500">Get notified about system maintenance and updates</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Privacy Settings -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Privacy</h3>
                    <p class="text-sm text-gray-500 mt-1">Manage your privacy and data sharing preferences</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Profile Visibility</p>
                            <p class="text-xs text-gray-500">Make your profile visible to other users</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Show Online Status</p>
                            <p class="text-xs text-gray-500">Let others see when you're online</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Activity Status</p>
                            <p class="text-xs text-gray-500">Share your activity status with team members</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Data Analytics</p>
                            <p class="text-xs text-gray-500">Help us improve by sharing usage data</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Advanced Settings -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Advanced</h3>
                    <p class="text-sm text-gray-500 mt-1">Advanced system configurations</p>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">API Access</label>
                        <div class="flex items-center space-x-2">
                            <input type="text" value="sk-1234567890abcdef" readonly class="flex-1 border border-gray-300 rounded-lg px-3 py-2 bg-gray-50">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Regenerate</button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Keep your API key secure and never share it publicly</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Session Timeout</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>15 minutes</option>
                            <option>30 minutes</option>
                            <option selected>1 hour</option>
                            <option>2 hours</option>
                            <option>4 hours</option>
                            <option>Never</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cache Duration</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>5 minutes</option>
                            <option selected>15 minutes</option>
                            <option>30 minutes</option>
                            <option>1 hour</option>
                            <option>4 hours</option>
                        </select>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">Debug Mode</p>
                            <p class="text-xs text-gray-500">Enable debug logging for troubleshooting</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <div class="pt-6 border-t border-gray-200">
                        <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Delete Account</button>
                        <p class="text-xs text-gray-500 mt-2">This action cannot be undone. All your data will be permanently deleted.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

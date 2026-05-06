@extends('layouts.app')

@section('title', 'Profile - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Success Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <div>
                    <span class="text-red-700 font-medium">Please fix the following errors:</span>
                    <ul class="text-red-600 text-sm mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Profile</h1>
            <p class="text-gray-500">Manage your personal information and preferences</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="exportProfile()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Export Profile</span>
            </button>
            <button type="submit" form="profileForm" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
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
                    <h2 class="mt-4 text-xl font-semibold text-gray-900">{{ $user->name ?? 'User Name' }}</h2>
                    <p class="text-sm text-gray-500">{{ $user->email ?? 'user@example.com' }}</p>
                    <div class="mt-4 flex items-center justify-center space-x-2">
                        @if($user->roles->isNotEmpty())
                            @if($user->roles->first()->name === 'admin')
                                <span class="px-3 py-1 text-sm font-medium bg-purple-100 text-purple-800 rounded">Admin</span>
                            @elseif($user->roles->first()->name === 'supervisor')
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

            <!-- Additional Profile Information -->
            @if($skillsData)
                <div class="bg-white rounded-lg shadow p-6 mt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Skills Survey Information</h3>
                        <button onclick="editSkillsSurvey()" class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 flex items-center space-x-1">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span class="whitespace-nowrap">Edit Survey</span>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Experience Level</h4>
                            <span class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded-full">{{ ucfirst($skillsData->experience_level) }}</span>
                        </div>
                        
                        @if($skillsData->skills)
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Technical Skills</h4>
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $skills = is_string($skillsData->skills) ? json_decode($skillsData->skills, true) : $skillsData->skills;
                                        $skills = is_array($skills) ? $skills : [];
                                    @endphp
                                    @foreach($skills as $skill)
                                        <span class="px-3 py-1 text-sm bg-green-100 text-green-800 rounded-full">{{ ucfirst($skill) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        @if($skillsData->interests)
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Areas of Interest</h4>
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $interests = is_string($skillsData->interests) ? json_decode($skillsData->interests, true) : $skillsData->interests;
                                        $interests = is_array($interests) ? $interests : [];
                                    @endphp
                                    @foreach($interests as $interest)
                                        <span class="px-3 py-1 text-sm bg-yellow-100 text-yellow-800 rounded-full">{{ ucfirst(str_replace('_', ' ', $interest)) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        @if($skillsData->project_type)
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Project Preferences</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-gray-600">Preferred Project Type:</span>
                                        <span class="font-medium">{{ ucfirst($skillsData->project_type) }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Project Duration:</span>
                                        <span class="font-medium">{{ ucfirst($skillsData->project_duration) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if($skillsData->goals)
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Goals</h4>
                                <p class="text-gray-700">{{ $skillsData->goals }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            
            @if($profileData)
                <div class="bg-white rounded-lg shadow p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Supervisor Profile Information</h3>
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Department</h4>
                            <span class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded-full">{{ $profileData->department }}</span>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Position</h4>
                            <span class="px-3 py-1 text-sm bg-green-100 text-green-800 rounded-full">{{ $profileData->position }}</span>
                        </div>
                        
                        @if($profileData->specializations)
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Specializations</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($profileData->specializations as $specialization)
                                        <span class="px-3 py-1 text-sm bg-purple-100 text-purple-800 rounded-full">{{ $specialization }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        @if($profileData->preferences)
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Project Preferences</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($profileData->preferences as $preference)
                                        @if(is_array($preference))
                                            @if(isset($preference['name']))
                                                <span class="px-3 py-1 text-sm bg-yellow-100 text-yellow-800 rounded-full">{{ $preference['name'] }}</span>
                                            @elseif(isset($preference[0]))
                                                <span class="px-3 py-1 text-sm bg-yellow-100 text-yellow-800 rounded-full">{{ $preference[0] }}</span>
                                            @endif
                                        @else
                                            <span class="px-3 py-1 text-sm bg-yellow-100 text-yellow-800 rounded-full">{{ $preference }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Profile Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6" id="profileForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                <input type="text" name="first_name" value="{{ $user->first_name ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('first_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                <input type="text" name="last_name" value="{{ $user->last_name ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('last_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ $user->email ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" name="phone" value="{{ $user->phone ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                            <textarea name="bio" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tell us about yourself...">{{ $user->bio ?? '' }}</textarea>
                            @error('bio')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Registration Number</label>
                                <input type="text" name="registration_number" value="{{ $user->registration_number ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                <input type="text" name="role" value="{{ $user->roles->first()->name ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
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

<script>
function editSkillsSurvey() {
    // Redirect to the survey page for editing
    window.location.href = '/survey';
}

function exportProfile() {
    // Show loading state
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    button.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Exporting...';
    button.disabled = true;
    
    // Fetch the profile data
    fetch('/profile/export', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Export failed');
        }
        return response.blob();
    })
    .then(blob => {
        // Create download link
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `profile_${new Date().toISOString().split('T')[0]}.pdf`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
        
        // Show success message
        showNotification('Profile exported successfully as PDF!', 'success');
    })
    .catch(error => {
        console.error('Export error:', error);
        showNotification('Failed to export profile', 'error');
    })
    .finally(() => {
        // Restore button
        button.innerHTML = originalContent;
        button.disabled = false;
    });
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>

@endsection

@extends('layouts.app')

@section('title', 'Group Settings - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Group Settings</h1>
            <p class="text-gray-500">Configure automatic group creation and countdown timer</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="window.location.reload()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.032 6.974V16.013a8.25 8.25 0 0013.803 3.7l-3.181-3.183"/>
                </svg>
                <span class="whitespace-nowrap">Refresh</span>
            </button>
        </div>
    </div>

    <!-- Current Status Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Current Group Creation Status</h2>
            <div class="flex items-center space-x-2">
                <div id="status-indicator" class="w-3 h-3 rounded-full {{ $settings?->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></div>
                <span id="status-text" class="text-sm font-medium {{ $settings?->is_active ? 'text-green-600' : 'text-gray-500' }}">
                    {{ $settings?->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>

        @if($settings && $settings->is_countdown_running())
            <!-- Countdown Timer Display -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 mb-6">
                <div class="text-center">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Group Creation Countdown</h3>
                    <div id="countdown-display" class="text-4xl font-bold text-blue-600 mb-2">
                        {{ $settings->formatted_remaining_time }}
                    </div>
                    <p class="text-sm text-gray-600">
                        Ends at: {{ $settings->countdown_end_time->format('M d, Y H:i:s') }}
                    </p>
                    <div class="mt-4 flex justify-center space-x-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'student'); })->count() }}</div>
                            <div class="text-xs text-gray-500">Total Students</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $settings->participants_per_group }}</div>
                            <div class="text-xs text-gray-500">Per Group</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ floor(\App\Models\User::whereHas('roles', function($q) { $q->where('name', 'student'); })->count() / $settings->participants_per_group) }}</div>
                            <div class="text-xs text-gray-500">Groups to Create</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Settings Form -->
        <form id="group-settings-form" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Participants Per Group -->
                <div>
                    <label for="participants_per_group" class="block text-sm font-medium text-gray-700 mb-2">
                        Participants Per Group
                    </label>
                    <input type="number" 
                           id="participants_per_group" 
                           name="participants_per_group" 
                           min="2" 
                           max="10" 
                           value="{{ $settings->participants_per_group ?? 4 }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Number of students to assign to each group (2-10)</p>
                </div>

                <!-- Countdown Minutes -->
                <div>
                    <label for="countdown_minutes" class="block text-sm font-medium text-gray-700 mb-2">
                        Countdown Duration (minutes)
                    </label>
                    <input type="number" 
                           id="countdown_minutes" 
                           name="countdown_minutes" 
                           min="1" 
                           max="1440" 
                           value="{{ $settings->countdown_minutes ?? 60 }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Duration before automatic group creation (1-1440 minutes)</p>
                </div>
            </div>

            <!-- Balancing Options -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Group Balancing Options</h3>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="balance_by_gender" 
                               value="1" 
                               {{ $settings->balance_by_gender ?? 'checked' }}
                               class="mr-3 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Balance groups by gender</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="balance_by_skills" 
                               value="1" 
                               {{ $settings->balance_by_skills ?? 'checked' }}
                               class="mr-3 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Balance groups by skills (based on student profiles)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="auto_create_groups" 
                               value="1" 
                               {{ $settings->auto_create_groups ?? 'checked' }}
                               class="mr-3 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Automatically create groups when countdown ends</span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-4 pt-6 border-t">
                @if($settings?->is_active)
                    <button type="button" 
                            onclick="stopCountdown()" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10h6v4H9z"/>
                        </svg>
                        <span>Stop Countdown</span>
                    </button>
                @else
                    <button type="button" 
                            onclick="startCountdown()" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Start Countdown</span>
                    </button>
                @endif
                
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Save Settings</span>
                </button>
                
                <button type="button" 
                        onclick="createGroupsNow()" 
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Create Groups Now</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Recent Groups -->
    @if($groups && $groups->count() > 0)
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Recently Created Groups</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($groups->take(6) as $group)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-medium text-gray-900">{{ $group->name }}</h4>
                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                {{ $group->members->count() }} members
                            </span>
                        </div>
                        <div class="space-y-2">
                            @foreach($group->members->take(3) as $member)
                                <div class="flex items-center space-x-2">
                                    <img src="https://picsum.photos/seed/{{ $member->email }}/24/24.jpg" 
                                         alt="{{ $member->name }}" 
                                         class="w-6 h-6 rounded-full">
                                    <span class="text-sm text-gray-600">{{ $member->name }}</span>
                                </div>
                            @endforeach
                            @if($group->members->count() > 3)
                                <div class="text-xs text-gray-500">+{{ $group->members->count() - 3 }} more...</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
let countdownInterval = null;

function startCountdown() {
    console.log('Start countdown button clicked');
    
    const form = document.getElementById('group-settings-form');
    if (!form) {
        console.error('Form not found');
        showNotification('Form not found', 'error');
        return;
    }
    
    const formData = new FormData(form);
    
    // Add action to indicate countdown start
    formData.append('action', 'start_countdown');
    
    console.log('Sending request to start countdown...');
    
    fetch('{{ route("admin.group-settings.update") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response received:', response);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            showNotification('Countdown started successfully!', 'success');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showNotification(data.message || 'Error starting countdown', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error starting countdown', 'error');
    });
}

function stopCountdown() {
    fetch('{{ route("admin.group-settings.update") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'stop_countdown'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Countdown stopped successfully!', 'success');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showNotification(data.message || 'Error stopping countdown', 'error');
        }
    })
    .catch(error => {
        showNotification('Error stopping countdown', 'error');
    });
}

function createGroupsNow() {
    if (confirm('Are you sure you want to create groups now? This will use the current settings and cannot be undone.')) {
        fetch('{{ route("admin.create-groups") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(`Successfully created ${data.groups_created} groups!`, 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showNotification(data.message || 'Error creating groups', 'error');
            }
        })
        .catch(error => {
            showNotification('Error creating groups', 'error');
        });
    }
}

// Form submission
document.getElementById('group-settings-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route("admin.group-settings.update") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Settings saved successfully!', 'success');
        } else {
            showNotification(data.message || 'Error saving settings', 'error');
        }
    })
    .catch(error => {
        showNotification('Error saving settings', 'error');
    });
});

// Live countdown update
@if($settings && $settings->is_countdown_running())
function updateCountdown() {
    fetch('{{ route("admin.countdown-status") }}')
        .then(response => response.json())
        .then(data => {
            if (data.remaining_time > 0) {
                const hours = Math.floor(data.remaining_time / 3600);
                const minutes = Math.floor((data.remaining_time % 3600) / 60);
                const seconds = data.remaining_time % 60;
                
                document.getElementById('countdown-display').textContent = 
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            } else {
                // Countdown finished, reload page
                setTimeout(() => window.location.reload(), 2000);
            }
        })
        .catch(error => {
            console.error('Error updating countdown:', error);
        });
}

// Update countdown every second
countdownInterval = setInterval(updateCountdown, 1000);
@endif

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

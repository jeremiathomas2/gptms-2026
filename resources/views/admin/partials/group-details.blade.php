<div class="max-h-[90vh] overflow-y-auto">
    <!-- Modal Header -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $group->name }}</h2>
                <p class="text-gray-500 mt-1">{{ $group->description ?? 'No description available' }}</p>
                <div class="flex items-center space-x-2 mt-2">
                    <span class="px-2 py-1 text-xs font-medium rounded 
                        {{ $group->status === 'active' ? 'bg-green-100 text-green-800' : 
                           $group->status === 'forming' ? 'bg-yellow-100 text-yellow-800' : 
                           $group->status === 'completed' ? 'bg-blue-100 text-blue-800' : 
                           'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($group->status) }}
                    </span>
                    @if($group->project)
                        <span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded">
                            {{ $group->project->name }}
                        </span>
                    @endif
                </div>
            </div>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Modal Content -->
    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Group Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Supervisor Information -->
                @if($group->creator)
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4">Supervisor Information</h3>
                        <div class="flex items-start space-x-4">
                            <img src="https://picsum.photos/seed/{{ $group->creator->email }}/80/80.jpg" 
                                 alt="{{ $group->creator->name }}" 
                                 class="w-20 h-20 rounded-full">
                            <div class="flex-1">
                                <h4 class="text-lg font-medium text-blue-900">{{ $group->creator->name }}</h4>
                                <p class="text-blue-700">{{ $group->creator->email }}</p>
                                <div class="mt-2 space-y-1">
                                    <p class="text-sm text-blue-600">
                                        <span class="font-medium">Role:</span> {{ $group->creator->roles->first()->name ?? 'No role' }}
                                    </p>
                                    <p class="text-sm text-blue-600">
                                        <span class="font-medium">Phone:</span> {{ $group->creator->phone ?? 'Not provided' }}
                                    </p>
                                    <p class="text-sm text-blue-600">
                                        <span class="font-medium">Gender:</span> {{ ucfirst($group->creator->gender ?? 'Not specified') }}
                                    </p>
                                    @if($group->creator->registration_number)
                                        <p class="text-sm text-blue-600">
                                            <span class="font-medium">Registration:</span> {{ $group->creator->registration_number }}
                                        </p>
                                    @endif
                                </div>
                                <div class="mt-3 flex space-x-2">
                                    <a href="{{ route('users.show', $group->creator->id) }}" 
                                       class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                                        View Profile
                                    </a>
                                    <button onclick="sendEmail('{{ $group->creator->email }}')" 
                                            class="px-3 py-1 text-sm bg-white text-blue-600 border border-blue-300 rounded hover:bg-blue-50">
                                        Send Email
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Group Members -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Group Members ({{ $group->activeMembers()->count() }})
                    </h3>
                    
                    @if($group->activeMembers()->count() > 0)
                        <div class="space-y-4">
                            @foreach($group->activeMembers as $member)
                                <div class="bg-white border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-4">
                                            <img src="https://picsum.photos/seed/{{ $member->user->email }}/60/60.jpg" 
                                                 alt="{{ $member->user->name }}" 
                                                 class="w-16 h-16 rounded-full">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2 mb-1">
                                                    <h4 class="text-lg font-medium text-gray-900">{{ $member->user->name }}</h4>
                                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">
                                                        {{ ucfirst($member->role) }}
                                                    </span>
                                                </div>
                                                <p class="text-gray-600 mb-2">{{ $member->user->email }}</p>
                                                
                                                <div class="grid grid-cols-2 gap-4 text-sm">
                                                    <div>
                                                        <span class="font-medium text-gray-700">Gender:</span>
                                                        <span class="text-gray-600">{{ ucfirst($member->user->gender ?? 'Not specified') }}</span>
                                                    </div>
                                                    @if($member->user->registration_number)
                                                        <div>
                                                            <span class="font-medium text-gray-700">Registration:</span>
                                                            <span class="text-gray-600">{{ $member->user->registration_number }}</span>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <span class="font-medium text-gray-700">Joined:</span>
                                                        <span class="text-gray-600">{{ $member->joined_at->format('M d, Y') }}</span>
                                                    </div>
                                                    @if($member->contribution_score)
                                                        <div>
                                                            <span class="font-medium text-gray-700">Contribution:</span>
                                                            <span class="text-gray-600">{{ $member->contribution_score }}/5.0</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Skills and Profile Info -->
                                                @if($member->user->studentProfile || $member->user->skills->count() > 0)
                                                    <div class="mt-3 pt-3 border-t border-gray-100">
                                                        @if($member->user->studentProfile)
                                                            <div class="mb-2">
                                                                <span class="text-sm font-medium text-gray-700">GPA:</span>
                                                                <span class="text-sm text-gray-600">{{ $member->user->studentProfile->gpa ?? 'N/A' }}</span>
                                                            </div>
                                                        @endif
                                                        
                                                        @if($member->user->skills->count() > 0)
                                                            <div class="flex flex-wrap gap-1">
                                                                @foreach($member->user->skills as $skill)
                                                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">
                                                                        {{ $skill->name }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="flex space-x-2">
                                            <a href="{{ route('users.show', $member->user->id) }}" 
                                               class="p-2 text-blue-600 hover:text-blue-800" 
                                               title="View Profile">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <button onclick="sendEmail('{{ $member->user->email }}')" 
                                                    class="p-2 text-gray-600 hover:text-gray-800" 
                                                    title="Send Email">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-lg">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p class="text-gray-500">No active members in this group</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar Information -->
            <div class="space-y-6">
                <!-- Group Statistics -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Group Statistics</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Total Members</span>
                            <span class="text-sm font-medium">{{ $group->activeMembers()->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Max Members</span>
                            <span class="text-sm font-medium">{{ $group->max_members ?? 'Unlimited' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Group Status</span>
                            <span class="text-sm font-medium">{{ ucfirst($group->status) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Created</span>
                            <span class="text-sm font-medium">{{ $group->created_at->format('M d, Y') }}</span>
                        </div>
                        @if($group->formed_at)
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Formed</span>
                                <span class="text-sm font-medium">{{ $group->formed_at->format('M d, Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Gender Distribution -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Gender Distribution</h3>
                    <div class="space-y-2">
                        @php
                            $genderCounts = $group->activeMembers->groupBy(function($member) {
                                return $member->user->gender ?? 'not_specified';
                            })->map->count();
                        @endphp
                        @foreach(['male', 'female', 'other', 'prefer_not_to_say', 'not_specified'] as $gender)
                            @php
                                $count = $genderCounts->get($gender, 0);
                                $percentage = $group->activeMembers()->count() > 0 ? 
                                    round(($count / $group->activeMembers()->count()) * 100, 1) : 0;
                                $label = ucfirst(str_replace('_', ' ', $gender));
                            @endphp
                            @if($count > 0)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">{{ $label }}</span>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-16 bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium">{{ $count }} ({{ $percentage }}%)</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Actions -->
                <div class="space-y-2">
                    <button onclick="editGroup({{ $group->id }})" 
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Edit Group
                    </button>
                    <button onclick="exportGroupData({{ $group->id }})" 
                            class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                        Export Group Data
                    </button>
                    <button onclick="sendGroupEmail({{ $group->id }})" 
                            class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Email All Members
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function closeModal() {
    document.getElementById('group-details-modal').classList.add('hidden');
}

function exportGroupData(groupId) {
    window.location.href = `/admin/groups/${groupId}/export`;
}

function sendGroupEmail(groupId) {
    // This would open a compose email with all group members
    alert('Email functionality would be implemented here');
}
</script>

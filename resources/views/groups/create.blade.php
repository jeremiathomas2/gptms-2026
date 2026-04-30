@extends('layouts.app')

@section('title', 'Create Group - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create New Group</h1>
            <p class="text-gray-500">Set up a new group for your project team</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('groups.all') }}" class="btn btn-secondary flex items-center space-x-2">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to Groups</span>
            </a>
        </div>
    </div>

    <!-- Create Group Form -->
    <div class="card">
        <div class="card-header">
            <h2 class="text-lg font-semibold text-gray-900">Group Information</h2>
            <p class="text-sm text-gray-500">Fill in the details for your new group</p>
        </div>
        <div class="card-body">
            <form class="space-y-6">
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">Group Name *</label>
                        <input type="text" name="name" required class="form-input" placeholder="Enter group name">
                        <p class="mt-1 text-sm text-gray-500">Choose a descriptive name for your group</p>
                    </div>
                    <div>
                        <label class="form-label">Project *</label>
                        <select name="project" required class="form-input">
                            <option value="">Select a project</option>
                            <option value="ecommerce">E-commerce Platform</option>
                            <option value="mobile">Mobile App</option>
                            <option value="research">Data Research</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-input" placeholder="Describe the purpose and goals of this group"></textarea>
                    <p class="mt-1 text-sm text-gray-500">Optional: Provide more details about the group's objectives</p>
                </div>

                <!-- Group Settings -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Group Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="form-label">Max Members</label>
                            <input type="number" name="max_members" min="2" max="50" value="10" class="form-input">
                            <p class="mt-1 text-sm text-gray-500">Maximum number of members</p>
                        </div>
                        <div>
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-input">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Status</label>
                            <select name="status" class="form-input">
                                <option value="planning">Planning</option>
                                <option value="active" selected>Active</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Meeting Schedule -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Meeting Schedule</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Meeting Day</label>
                            <select name="meeting_day" class="form-input">
                                <option value="">No regular meeting</option>
                                <option value="monday">Monday</option>
                                <option value="tuesday">Tuesday</option>
                                <option value="wednesday">Wednesday</option>
                                <option value="thursday">Thursday</option>
                                <option value="friday">Friday</option>
                                <option value="saturday">Saturday</option>
                                <option value="sunday">Sunday</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Meeting Time</label>
                            <input type="time" name="meeting_time" class="form-input">
                        </div>
                    </div>
                </div>

                <!-- Initial Members -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Initial Members</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1">
                                <input type="email" name="member_email[]" placeholder="Enter email address" class="form-input">
                            </div>
                            <button type="button" onclick="addMemberField()" class="btn btn-secondary">
                                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add Member
                            </button>
                        </div>
                        <div id="additional-members" class="space-y-2"></div>
                        <p class="text-sm text-gray-500">Add team members by email. They will receive an invitation to join the group.</p>
                    </div>
                </div>

                <!-- Permissions -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Group Permissions</h3>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="allow_members_invite" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Allow members to invite others</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="require_approval" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Require approval for new members</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="public_group" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Make group discoverable to others</span>
                        </label>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="window.history.back()" class="btn btn-secondary">Cancel</button>
                <button type="submit" onclick="submitGroupForm()" class="btn btn-primary">Create Group</button>
            </div>
        </div>
    </div>
</div>

<script>
function addMemberField() {
    const container = document.getElementById('additional-members');
    const memberField = document.createElement('div');
    memberField.className = 'flex items-center space-x-4';
    memberField.innerHTML = `
        <div class="flex-1">
            <input type="email" name="member_email[]" placeholder="Enter email address" class="form-input">
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="btn btn-secondary btn-sm">
            <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;
    container.appendChild(memberField);
}

function submitGroupForm() {
    // Here you would normally submit the form via AJAX or regular form submission
    alert('Group created successfully!');
    window.location.href = '/groups';
}
</script>
@endsection

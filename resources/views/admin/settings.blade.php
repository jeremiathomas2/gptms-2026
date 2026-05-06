@extends('layouts.app')

@section('title', 'Admin Settings - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Admin Settings</h1>
            <p class="text-sm sm:text-base text-gray-500">Configure system-wide settings and preferences</p>
        </div>
        <div class="flex flex-col sm:flex-row sm:space-x-3 space-y-2 sm:space-y-0">
            <button type="button" onclick="window.GPTFMS.navigateToPage('/dashboard')" class="w-full sm:w-auto px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to Dashboard</span>
            </button>
        </div>
    </div>

    <!-- Settings Form -->
    <form action="{{ route('admin.settings') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- General Settings -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">General Settings</h2>
                <p class="text-sm text-gray-500">Basic system configuration</p>
            </div>
            <div class="p-4 sm:p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                        <input type="text" name="site_name" value="{{ \Cache::get('admin.settings.site_name', 'GPTFMS') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site Email</label>
                        <input type="email" name="site_email" value="{{ \Cache::get('admin.settings.site_email', 'admin@gptfms.com') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Default User Role</label>
                        <select name="default_role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="student" {{ \Cache::get('admin.settings.default_role') == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="supervisor" {{ \Cache::get('admin.settings.default_role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                            <option value="admin" {{ \Cache::get('admin.settings.default_role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Registration Status</label>
                        <select name="registration_enabled" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="enabled" {{ \Cache::get('admin.settings.registration_enabled') == 'enabled' ? 'selected' : '' }}>Enabled</option>
                            <option value="disabled" {{ \Cache::get('admin.settings.registration_enabled') == 'disabled' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Settings -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Email Settings</h2>
                <p class="text-sm text-gray-500">Configure email notifications and SMTP</p>
            </div>
            <div class="p-4 sm:p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Host</label>
                        <input type="text" name="smtp_host" value="{{ \Cache::get('admin.settings.smtp_host') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Port</label>
                        <input type="number" name="smtp_port" value="{{ \Cache::get('admin.settings.smtp_port', '587') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Username</label>
                        <input type="text" name="smtp_username" value="{{ \Cache::get('admin.settings.smtp_username') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Password</label>
                        <input type="password" name="smtp_password" value="{{ \Cache::get('admin.settings.smtp_password') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Settings -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Security Settings</h2>
                <p class="text-sm text-gray-500">Security and authentication preferences</p>
            </div>
            <div class="p-4 sm:p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Session Timeout (minutes)</label>
                        <input type="number" name="session_timeout" value="{{ \Cache::get('admin.settings.session_timeout', '120') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Minimum Length</label>
                        <input type="number" name="password_min_length" value="{{ \Cache::get('admin.settings.password_min_length', '8') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="space-y-3">
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" name="require_email_verification" value="1" 
                               {{ \Cache::get('admin.settings.require_email_verification') ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700">Require Email Verification</span>
                    </label>
                    
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" name="enable_two_factor" value="1" 
                               {{ \Cache::get('admin.settings.enable_two_factor') ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700">Enable Two-Factor Authentication</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Role Settings -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Role Settings</h2>
                <p class="text-sm text-gray-500">Configure user role permissions and access levels</p>
            </div>
            <div class="p-4 sm:p-6">
                <!-- Role Permission Matrix -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-900">Menu Item</th>
                                <th class="text-center py-3 px-4 text-sm font-semibold text-gray-900">
                                    <div class="flex items-center justify-center space-x-2">
                                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                        </svg>
                                        <span>Admin</span>
                                    </div>
                                </th>
                                <th class="text-center py-3 px-4 text-sm font-semibold text-gray-900">
                                    <div class="flex items-center justify-center space-x-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                        </svg>
                                        <span>Supervisor</span>
                                    </div>
                                </th>
                                <th class="text-center py-3 px-4 text-sm font-semibold text-gray-900">
                                    <div class="flex items-center justify-center space-x-2">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                        </svg>
                                        <span>Student</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <!-- Dashboard -->
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm text-gray-900 font-medium">Dashboard</td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[admin][dashboard]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.admin.dashboard', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[supervisor][dashboard]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.supervisor.dashboard', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[student][dashboard]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.student.dashboard', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                </td>
                            </tr>
                            
                            <!-- Users Management -->
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm text-gray-900 font-medium">Users Management</td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[admin][users]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.admin.users', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[supervisor][users]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.supervisor.users', false) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[student][users]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.student.users', false) ? 'checked' : '' }}
                                           class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                </td>
                            </tr>
                            
                            <!-- Groups -->
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm text-gray-900 font-medium">Groups</td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[admin][groups]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.admin.groups', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[supervisor][groups]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.supervisor.groups', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[student][groups]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.student.groups', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                </td>
                            </tr>
                            
                            <!-- Projects -->
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm text-gray-900 font-medium">Projects</td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[admin][projects]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.admin.projects', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[supervisor][projects]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.supervisor.projects', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[student][projects]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.student.projects', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                </td>
                            </tr>
                            
                            <!-- Analytics -->
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm text-gray-900 font-medium">Analytics</td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[admin][analytics]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.admin.analytics', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[supervisor][analytics]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.supervisor.analytics', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[student][analytics]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.student.analytics', false) ? 'checked' : '' }}
                                           class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                </td>
                            </tr>
                            
                            <!-- Reports -->
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm text-gray-900 font-medium">Reports</td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[admin][reports]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.admin.reports', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[supervisor][reports]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.supervisor.reports', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[student][reports]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.student.reports', false) ? 'checked' : '' }}
                                           class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                </td>
                            </tr>
                            
                            <!-- Messages -->
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm text-gray-900 font-medium">Messages</td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[admin][messages]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.admin.messages', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[supervisor][messages]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.supervisor.messages', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[student][messages]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.student.messages', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                </td>
                            </tr>
                            
                            <!-- Settings -->
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm text-gray-900 font-medium">Settings</td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[admin][settings]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.admin.settings', true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[supervisor][settings]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.supervisor.settings', false) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="permissions[student][settings]" value="1" 
                                           {{ \Cache::get('admin.settings.permissions.student.settings', false) ? 'checked' : '' }}
                                           class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Quick Actions -->
                <div class="mt-6 flex flex-wrap gap-3">
                    <button type="button" onclick="selectAllPermissions('admin')" class="px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 text-sm font-medium">
                        Select All Admin
                    </button>
                    <button type="button" onclick="selectAllPermissions('supervisor')" class="px-3 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 text-sm font-medium">
                        Select All Supervisor
                    </button>
                    <button type="button" onclick="selectAllPermissions('student')" class="px-3 py-1 bg-green-100 text-green-700 rounded-md hover:bg-green-200 text-sm font-medium">
                        Select All Student
                    </button>
                    <button type="button" onclick="clearAllPermissions()" class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm font-medium">
                        Clear All
                    </button>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Save Settings</span>
            </button>
        </div>
    </form>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif
</div>

<script>
function selectAllPermissions(role) {
    const checkboxes = document.querySelectorAll(`input[name="permissions[${role}][\\w+]"]`);
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
}

function clearAllPermissions() {
    const checkboxes = document.querySelectorAll('input[name^="permissions["]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
}
</script>
@endsection

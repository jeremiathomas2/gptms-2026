<!-- Sidebar -->
<aside id="sidebar" class="fixed left-0 top-0 h-full bg-gray-900 text-white z-50 {{ request()->cookie('sidebar_open') == 'false' ? 'w-16' : 'w-64' }} sidebar-transition">
    <!-- Logo Section -->
    <div class="p-6 border-b border-gray-800">
        <div class="flex items-center space-x-3 sidebar-logo">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="text-white font-bold text-lg">G</span>
            </div>
            <div class="sidebar-text">
                <h1 class="text-xl font-bold">GPTFMS</h1>
                <p class="text-xs text-gray-400">Management System</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="p-4 h-full flex flex-col">
        <ul class="space-y-2 overflow-y-auto scrollbar-thin flex-1 pr-2">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" 
                   class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }} flex items-center space-x-3 group relative"
                   title="Dashboard - Overview and statistics">
                    <div class="icon-wrapper">
                        <svg class="icon-md flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <span class="sidebar-text">Dashboard</span>
                    <span class="nav-badge badge-primary">2</span>
                </a>
            </li>
            
            <!-- Groups (Student and Supervisor only) -->
            @if(!in_array(session('user.role'), ['admin']))
            <li>
                <a href="{{ route('groups.my') }}" 
                   class="sidebar-link {{ request()->is('groups*') ? 'active' : '' }} flex items-center space-x-3 group relative"
                   title="Groups - Manage your groups">
                    <div class="icon-wrapper">
                        <svg class="icon-md flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="sidebar-text">Groups</span>
                    <span class="nav-badge badge-info">3</span>
                </a>
            </li>
            @endif
            
            <!-- Projects -->
            <li>
                <a href="{{ route('projects') }}" 
                   class="sidebar-link {{ request()->is('projects*') ? 'active' : '' }} flex items-center space-x-3 group relative"
                   title="Projects - Manage your projects and tasks">
                    <div class="icon-wrapper">
                        <svg class="icon-md flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                        </svg>
                    </div>
                    <span class="sidebar-text">Projects</span>
                    <span class="nav-badge badge-info">5</span>
                </a>
            </li>
            
            <!-- User Management (Admin/Supervisor only) -->
            @if(in_array(session('user.role'), ['admin', 'supervisor']))
            <li>
                <a href="{{ route('users') }}" 
                   class="sidebar-link {{ request()->is('users*') ? 'active' : '' }} flex items-center space-x-3 group relative"
                   title="User Management - Manage users and permissions">
                    <div class="icon-wrapper">
                        <svg class="icon-md flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <span class="sidebar-text">User Management</span>
                    <span class="nav-badge badge-warning">3</span>
                </a>
            </li>
            @endif
            
            <!-- Analytics (Admin and Supervisor only) -->
            @if(in_array(session('user.role'), ['admin', 'supervisor']))
            <li>
                <a href="{{ route('analytics') }}" 
                   class="sidebar-link {{ request()->is('analytics*') ? 'active' : '' }} flex items-center space-x-3 group relative"
                   title="Analytics - View insights and reports">
                    <div class="icon-wrapper">
                        <svg class="icon-md flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002 2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002 2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <span class="sidebar-text">Analytics</span>
                    <span class="nav-badge badge-success">New</span>
                </a>
            </li>
            @endif
            
            <!-- Reports (Admin and Supervisor only) -->
            @if(in_array(session('user.role'), ['admin', 'supervisor']))
            <li>
                <a href="{{ route('reports') }}" 
                   class="sidebar-link {{ request()->is('reports*') ? 'active' : '' }} flex items-center space-x-3 group relative"
                   title="Reports - Generate and view reports">
                    <div class="icon-wrapper">
                        <svg class="icon-md flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="sidebar-text">Reports</span>
                    <span class="nav-badge badge-danger">1</span>
                </a>
            </li>
            @endif
            
            <!-- Messages -->
            <li>
                <a href="{{ route('messages') }}" 
                   class="sidebar-link {{ request()->is('messages*') ? 'active' : '' }} flex items-center space-x-3 group relative"
                   title="Messages - View and manage communications">
                    <div class="icon-wrapper">
                        <svg class="icon-md flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <span class="sidebar-text">Messages</span>
                    <span class="nav-badge badge-primary">7</span>
                </a>
            </li>
            
            <!-- Profile -->
            <li>
                <a href="{{ route('profile') }}" 
                   class="sidebar-link {{ request()->is('profile*') ? 'active' : '' }} flex items-center space-x-3 group relative"
                   title="Profile - Manage your account settings">
                    <div class="icon-wrapper">
                        <svg class="icon-md flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <span class="sidebar-text">Profile</span>
                </a>
            </li>
            
            <!-- Admin Dashboard (Admin only) -->
            @if(session('user.role') === 'admin')
            <li>
                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-link {{ request()->is('admin*') ? 'active' : '' }} flex items-center space-x-3 group relative"
                   title="Admin Dashboard - System overview and statistics">
                    <div class="icon-wrapper">
                        <svg class="icon-md flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <span class="sidebar-text">Admin Dashboard</span>
                    <span class="nav-badge badge-danger">Admin</span>
                </a>
            </li>
            @endif
            
            <!-- Groups Management (Admin only) -->
            @if(session('user.role') === 'admin')
            <li>
                <a href="{{ route('admin.groups') }}" 
                   class="sidebar-link {{ request()->is('admin/groups*') ? 'active' : '' }} flex items-center space-x-3 group relative"
                   title="Groups Management - View all groups and members">
                    <div class="icon-wrapper">
                        <svg class="icon-md flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="sidebar-text">Groups Management</span>
                    <span class="nav-badge badge-info">All Groups</span>
                </a>
            </li>
            @endif
            
            <!-- Group Settings (Admin only) -->
            @if(session('user.role') === 'admin')
            <li>
                <a href="{{ route('admin.group-settings') }}" 
                   class="sidebar-link {{ request()->is('admin/group-settings*') ? 'active' : '' }} flex items-center space-x-3 group relative"
                   title="Group Settings - Configure group creation and countdown">
                    <div class="icon-wrapper">
                        <svg class="icon-md flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="sidebar-text">Group Settings</span>
                    <span class="nav-badge badge-warning">Config</span>
                </a>
            </li>
            @endif
            
            <!-- System Settings (Admin only) -->
            @if(session('user.role') === 'admin')
            <li>
                <a href="{{ route('admin.settings') }}" 
                   class="sidebar-link {{ request()->is('admin/settings*') ? 'active' : '' }} flex items-center space-x-3 group relative"
                   title="System Settings - Configure application settings">
                    <div class="icon-wrapper">
                        <svg class="icon-md flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="sidebar-text">System Settings</span>
                    <span class="nav-badge badge-primary">Control</span>
                </a>
            </li>
            @endif
        </ul>
    </nav>
    
    <!-- Sidebar Toggle Button -->
    @if(request()->cookie('sidebar_open') == 'false')
        <div class="absolute bottom-4 left-4">
            <button onclick="toggleSidebar()" 
                    class="p-2 rounded-lg hover:bg-gray-800 transition-colors hover-scale mx-auto block">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    @endif
</aside>

<style>
/* Sidebar Styles */
.sidebar-transition {
    transition: width 0.3s ease-in-out;
}

.sidebar-text {
    transition: opacity 0.3s ease-in-out;
}

.w-16 .sidebar-text {
    opacity: 0;
    visibility: hidden;
}

.sidebar-link {
    @apply px-3 py-2 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200 flex items-center space-x-3;
}

.sidebar-link.active {
    @apply bg-blue-600 text-white;
}

.sidebar-dropdown {
    @apply px-3 py-2 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200 flex items-center justify-between w-full;
}

.sidebar-dropdown.active {
    @apply bg-blue-600 text-white;
}

.sidebar-dropdown-item {
    @apply px-3 py-2 pl-10 text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200 block;
}

.icon-wrapper {
    @apply w-8 h-8 flex items-center justify-center rounded-lg bg-gray-800 group-hover:bg-blue-600 transition-colors duration-200;
}

.sidebar-link.active .icon-wrapper,
.sidebar-dropdown.active .icon-wrapper {
    @apply bg-blue-600;
}

.icon-sm {
    @apply w-4 h-4;
}

.icon-md {
    @apply w-5 h-5;
}

.icon-lg {
    @apply w-6 h-6;
}

.nav-badge {
    @apply px-2 py-1 text-xs rounded-full ml-auto;
}

.badge-primary {
    @apply bg-blue-600 text-white;
}

.badge-info {
    @apply bg-green-600 text-white;
}

.badge-warning {
    @apply bg-yellow-600 text-white;
}

.badge-danger {
    @apply bg-red-600 text-white;
}

.badge-success {
    @apply bg-purple-600 text-white;
}

/* Dropdown Styles */
.dropdown-menu {
    @apply absolute left-full top-0 ml-2 w-48 bg-gray-800 rounded-lg shadow-xl border border-gray-700 z-50;
}

.dropdown-menu.hidden {
    @apply hidden;
}

.dropdown-enter {
    @apply animate-pulse;
}

/* Hover Effects */
.hover-scale {
    transition: transform 0.2s ease;
}

.hover-scale:hover {
    transform: scale(1.05);
}

/* Scrollbar Styles */
.scrollbar-thin::-webkit-scrollbar {
    width: 4px;
}

.scrollbar-thin::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 2px;
}

.scrollbar-thin::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
}

.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}
</style>

<script>
// Toggle Sidebar
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const currentWidth = sidebar.classList.contains('w-64');
    
    if (currentWidth) {
        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-16');
        document.cookie = 'sidebar_open=false; path=/; max-age=31536000';
    } else {
        sidebar.classList.remove('w-16');
        sidebar.classList.add('w-64');
        document.cookie = 'sidebar_open=true; path=/; max-age=31536000';
    }
}

// Initialize sidebar state
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarOpen = getCookie('sidebar_open');
    
    if (sidebarOpen === 'false') {
        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-16');
    }
});

// Helper function to get cookie value
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
</script>

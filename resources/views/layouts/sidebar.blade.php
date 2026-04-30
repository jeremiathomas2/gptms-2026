<!-- Sidebar -->
<aside id="sidebar" class="fixed left-0 top-0 h-full bg-gray-900 text-white z-50 {{ request()->cookie('sidebar_open') == 'false' ? 'w-16' : 'w-64' }} sidebar-transition">
    <!-- Logo Section -->
    <div class="p-6 border-b border-gray-800">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-lg">G</span>
            </div>
            @if(request()->cookie('sidebar_open') != 'false')
                <div>
                    <h1 class="text-xl font-bold">GPTFMS</h1>
                    <p class="text-xs text-gray-400">Management System</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="p-4">
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" 
                   class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }} hover-fade">
                    <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1H2m0 0a1 1 0 011-1h3.5a1 1 0 01.707.293L9 9.586V11a1 1 0 001 1h3a1 1 0 001-1V9.586l1.793-1.793a1 1 0 01.707-.293H15a1 1 0 011 1v4a1 1 0 001 1z"/>
                    </svg>
                    @if(request()->cookie('sidebar_open') != 'false')
                        <span>Dashboard</span>
                    @endif
                </a>
            </li>
            
            <!-- Groups with Dropdown -->
            <li>
                <div class="relative dropdown">
                    <button onclick="toggleGroupsDropdown()" 
                            class="sidebar-dropdown {{ request()->is('groups*') ? 'active' : '' }}">
                        <div class="flex items-center space-x-3">
                            <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            @if(request()->cookie('sidebar_open') != 'false')
                                <span>Groups</span>
                            @endif
                        </div>
                        @if(request()->cookie('sidebar_open') != 'false')
                            <svg id="groups-chevron" class="icon-sm transform transition-transform {{ request()->is('groups*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        @endif
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="groups-dropdown" class="dropdown-menu absolute left-0 top-full mt-1 w-48 bg-gray-800 rounded-lg shadow-lg p-2 hidden z-50 slide-down">
                        <a href="{{ route('groups.all') }}" class="sidebar-dropdown-item hover-fade">
                            <svg class="icon-sm inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>All Groups
                        </a>
                        <a href="{{ route('groups.my') }}" class="sidebar-dropdown-item hover-fade">
                            <svg class="icon-sm inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>My Groups
                        </a>
                        <a href="{{ route('groups.create') }}" class="sidebar-dropdown-item hover-fade">
                            <svg class="icon-sm inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>Create Group
                        </a>
                        <a href="{{ route('groups.requests') }}" class="sidebar-dropdown-item hover-fade">
                            <svg class="icon-sm inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>Group Requests
                        </a>
                        <a href="{{ route('groups.analytics') }}" class="sidebar-dropdown-item hover-fade">
                            <svg class="icon-sm inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>Group Analytics
                        </a>
                    </div>
                </div>
            </li>
            
            <!-- Projects -->
            <li>
                <a href="{{ route('projects') }}" 
                   class="sidebar-link {{ request()->is('projects*') ? 'active' : '' }} hover-fade">
                    <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    @if(request()->cookie('sidebar_open') != 'false')
                        <span>Projects</span>
                    @endif
                </a>
            </li>
            
            <!-- Users -->
            <li>
                <a href="{{ route('users') }}" 
                   class="sidebar-link {{ request()->is('users*') ? 'active' : '' }} hover-fade">
                    <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    @if(request()->cookie('sidebar_open') != 'false')
                        <span>User Management</span>
                    @endif
                </a>
            </li>
            
            <!-- Analytics -->
            <li>
                <a href="{{ route('analytics') }}" 
                   class="sidebar-link {{ request()->is('analytics*') ? 'active' : '' }} hover-fade">
                    <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    @if(request()->cookie('sidebar_open') != 'false')
                        <span>Analytics</span>
                    @endif
                </a>
            </li>
            
            <!-- Reports -->
            <li>
                <a href="{{ route('reports') }}" 
                   class="sidebar-link {{ request()->is('reports*') ? 'active' : '' }} hover-fade">
                    <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    @if(request()->cookie('sidebar_open') != 'false')
                        <span>Reports</span>
                    @endif
                </a>
            </li>
            
            <!-- Messages -->
            <li>
                <a href="{{ route('messages') }}" 
                   class="sidebar-link {{ request()->is('messages*') ? 'active' : '' }} hover-fade">
                    <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    @if(request()->cookie('sidebar_open') != 'false')
                        <span>Messages</span>
                    @endif
                </a>
            </li>
            
            <!-- Profile -->
            <li>
                <a href="{{ route('profile') }}" 
                   class="sidebar-link {{ request()->is('profile*') ? 'active' : '' }} hover-fade">
                    <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    @if(request()->cookie('sidebar_open') != 'false')
                        <span>Profile</span>
                    @endif
                </a>
            </li>
        </ul>
    </nav>
    
    <!-- Sidebar Toggle Button -->
    <div class="absolute bottom-4 left-4">
        <button onclick="toggleSidebar()" 
                class="p-2 rounded-lg hover:bg-gray-800 transition-colors hover-fade hover-scale">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
</aside>

<script>
function toggleSidebar() {
    const sidebar = document.querySelector('aside');
    const mainContent = document.querySelector('.flex-1.flex-col');
    const chevron = document.getElementById('groups-chevron');
    const dropdown = document.getElementById('groups-dropdown');
    
    const isCollapsed = sidebar.classList.contains('w-16');
    
    if (isCollapsed) {
        sidebar.classList.remove('w-16');
        sidebar.classList.add('w-64');
        mainContent.classList.remove('ml-16');
        mainContent.classList.add('ml-64');
        document.cookie = 'sidebar_open=true; path=/';
    } else {
        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-16');
        mainContent.classList.remove('ml-64');
        mainContent.classList.add('ml-16');
        document.cookie = 'sidebar_open=false; path=/';
        // Hide dropdown when collapsing
        if (dropdown) {
            dropdown.classList.add('hidden');
        }
    }
}

function toggleGroupsDropdown() {
    const dropdown = document.getElementById('groups-dropdown');
    const chevron = document.getElementById('groups-chevron');
    
    if (!dropdown) {
        console.error('Groups dropdown not found');
        return;
    }
    
    if (!chevron) {
        console.error('Groups chevron not found');
        return;
    }
    
    console.log('Toggling dropdown, current state:', dropdown.classList.contains('hidden'));
    
    if (dropdown.classList.contains('hidden')) {
        dropdown.classList.remove('hidden');
        dropdown.classList.add('dropdown-enter');
        chevron.classList.add('rotate-180');
        console.log('Dropdown opened');
    } else {
        dropdown.classList.add('hidden');
        dropdown.classList.remove('dropdown-enter');
        chevron.classList.remove('rotate-180');
        console.log('Dropdown closed');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('groups-dropdown');
    const chevron = document.getElementById('groups-chevron');
    const button = event.target.closest('button[onclick="toggleGroupsDropdown()"]');
    
    if (dropdown && !dropdown.classList.contains('hidden') && 
        (!button || button.getAttribute('onclick') !== 'toggleGroupsDropdown()')) {
        dropdown.classList.add('hidden');
        if (chevron) {
            chevron.classList.remove('rotate-180');
        }
    }
});

// Prevent dropdown from closing when clicking inside
document.getElementById('groups-dropdown')?.addEventListener('click', function(event) {
    event.stopPropagation();
});

// Auto-show groups dropdown if on groups pages
document.addEventListener('DOMContentLoaded', function() {
    const groupsDropdown = document.getElementById('groups-dropdown');
    const groupsChevron = document.getElementById('groups-chevron');
    
    console.log('Dropdown elements found:', !!groupsDropdown, !!groupsChevron);
    
    // Ensure dropdown starts hidden
    if (groupsDropdown) {
        groupsDropdown.classList.add('hidden');
        console.log('Dropdown initialized as hidden');
    }
    
    @if(request()->is('groups*'))
        if (groupsDropdown && groupsChevron) {
            groupsDropdown.classList.remove('hidden');
            groupsDropdown.classList.add('dropdown-enter');
            groupsChevron.classList.add('rotate-180');
            console.log('Dropdown auto-opened for groups page');
        }
    @endif
});
</script>

<!-- Header -->
<header class="bg-white border-b border-gray-200 px-8 py-4 relative z-40">
    <div class="flex items-center justify-between">
        <!-- Left Section: Menu Icon + Page Title -->
        <div class="flex items-center space-x-4">
            <!-- Menu Toggle Button -->
            <button onclick="toggleSidebar()" 
                    class="p-2 rounded-lg hover:bg-gray-100 transition-colors hover-scale">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            
            <!-- Page Title -->
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $title ?? 'Dashboard' }}
                </h1>
                <p class="text-sm text-gray-500">
                    @if(session('user.name'))
                        Welcome back, {{ session('user.name') }}!
                    @else
                        Welcome back to your dashboard
                    @endif
                </p>
            </div>
        </div>
        
        <!-- Header Actions -->
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <div class="relative">
                <button onclick="toggleNotifications()" class="p-2 rounded-lg hover:bg-gray-100 transition-colors relative hover-scale group">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-blue-600 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118.14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span id="notification-badge" class="absolute -top-1 -right-1 min-w-[18px] h-[18px] bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center hidden animate-pulse">0</span>
                </button>
                
                <!-- Notifications Dropdown -->
                <div id="notifications-dropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 py-2 hidden z-[9999]">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Mark all as read</span>
                            <button onclick="markAllNotificationsRead()" class="text-sm text-blue-600 hover:text-blue-800">Mark as read</button>
                        </div>
                    </div>
                    <div class="max-h-60 overflow-y-auto">
                        @if(session('notifications'))
                            @foreach(session('notifications') as $notification)
                                <div class="p-3 hover:bg-gray-50 border-b border-gray-100 last:border-b-0">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-2 h-2 {{ $notification->read ? 'bg-gray-300' : 'bg-blue-500' }} rounded-full mt-1"></div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 {{ $notification->read ? 'opacity-60' : '' }}">
                                                {{ $notification->title }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $notification->message }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-2">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if(!$notification->read)
                                            <button onclick="markNotificationRead({{ $notification->id }})" class="text-xs text-blue-600 hover:text-blue-800">Mark as read</button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="p-6 text-center text-gray-500">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13v7a3 3 0 003 3h-2V8a3 3 0 003 3h-2m-3 7h3m-3 4h3m-6 4h3m-6 0a3 3 0 003 3h2a3 3 0 003 3z"/>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No notifications</h3>
                                <p class="text-gray-500">You're all caught up! No new notifications.</p>
                            </div>
                        @endif
                    </div>
                    <div class="p-3 border-t border-gray-200">
                        <button onclick="viewAllNotifications()" class="w-full text-sm text-blue-600 hover:text-blue-800">View all notifications</button>
                    </div>
                </div>
            </div>
            
            <!-- Messages -->
            <div class="relative">
                <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors relative hover-scale">
                    <svg class="icon-md text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-blue-500 rounded-full"></span>
                </button>
            </div>
            
            <!-- User Profile Dropdown -->
            <div class="relative z-50">
                <button id="profile-button" onclick="toggleProfileMenu()"
                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-colors hover-scale">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-medium">
                            {{ session('user.name') ? substr(session('user.name'), 0, 1) : 'U' }}
                        </span>
                    </div>
                    <div class="text-left">
                        <p class="text-sm font-medium text-gray-900">
                            {{ session('user.name') ?? 'User' }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ session('user.email') ?? 'user@example.com' }}
                        </p>
                    </div>
                    <svg id="profile-chevron" class="icon-sm text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                
                <!-- Profile Dropdown Menu -->
                <div id="profile-menu" 
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 py-2 hidden z-[9999]">
                    <a href="{{ route('profile') }}" 
                       class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>My Profile</span>
                    </a>
                    <a href="{{ route('settings') }}" 
                       class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Settings</span>
                    </a>
                    <hr class="my-2 border-gray-200">
                    <a href="{{ route('notifications') }}" 
                       class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span>Notifications</span>
                    </a>
                    <a href="{{ route('help') }}" 
                       class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Help</span>
                    </a>
                    <hr class="my-2 border-gray-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="flex items-center space-x-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left">
                            <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
function toggleProfileMenu() {
    const menu = document.getElementById('profile-menu');
    const chevron = document.getElementById('profile-chevron');
    
    console.log('Profile dropdown elements found:', {
        menu: menu,
        chevron: chevron,
        menuExists: !!menu,
        chevronExists: !!chevron
    });
    
    if (!menu || !chevron) {
        console.error('Profile dropdown elements not found - retrying...');
        return;
    }
    
    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        chevron.classList.add('rotate-180');
    } else {
        menu.classList.add('hidden');
        chevron.classList.remove('rotate-180');
    }
}

// Initialize profile dropdown when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Profile dropdown initialization:', {
        menu: document.getElementById('profile-menu'),
        chevron: document.getElementById('profile-chevron'),
        button: document.getElementById('profile-button')
    });
});

// Close profile menu when clicking outside
document.addEventListener('click', function(event) {
    const profileButton = document.getElementById('profile-button');
    const profileMenu = document.getElementById('profile-menu');
    
    if (!profileButton.contains(event.target) && !profileMenu.contains(event.target)) {
        profileMenu.classList.add('hidden');
        document.getElementById('profile-chevron').classList.remove('rotate-180');
    }
});

// Prevent dropdown from closing when clicking inside
document.getElementById('profile-menu')?.addEventListener('click', function(event) {
    event.stopPropagation();
});

// Notifications functionality
function toggleNotifications() {
    const dropdown = document.getElementById('notifications-dropdown');
    
    if (dropdown.classList.contains('hidden')) {
        dropdown.classList.remove('hidden');
    } else {
        dropdown.classList.add('hidden');
    }
}

// Close notifications when clicking outside
document.addEventListener('click', function(event) {
    const notificationsButton = document.querySelector('button[onclick="toggleNotifications()"]');
    const notificationsDropdown = document.getElementById('notifications-dropdown');
    
    if (!notificationsButton.contains(event.target) && !notificationsDropdown.contains(event.target)) {
        notificationsDropdown.classList.add('hidden');
    }
});

// Prevent notifications dropdown from closing when clicking inside
document.getElementById('notifications-dropdown')?.addEventListener('click', function(event) {
    event.stopPropagation();
});

// Mark all notifications as read
function markAllNotificationsRead() {
    console.log('Marking all notifications as read');
    
    // Here you would make an API call to mark all notifications as read
    // For demo purposes, we'll update the UI
    const notificationItems = document.querySelectorAll('[data-notification-id]');
    notificationItems.forEach(item => {
        const readIndicator = item.querySelector('.bg-blue-500');
        if (readIndicator) {
            readIndicator.classList.remove('bg-blue-500');
            readIndicator.classList.add('bg-gray-300');
        }
    });
    
    // Update notification badge
    updateNotificationBadge(0);
    
    showNotification('All notifications marked as read', 'success');
}

// Mark single notification as read
function markNotificationRead(notificationId) {
    console.log('Marking notification as read:', notificationId);
    
    // Here you would make an API call to mark notification as read
    // For demo purposes, we'll update the UI
    const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
    if (notificationItem) {
        const readIndicator = notificationItem.querySelector('.bg-blue-500');
        const markButton = notificationItem.querySelector('button[onclick*="markNotificationRead"]');
        
        if (readIndicator) {
            readIndicator.classList.remove('bg-blue-500');
            readIndicator.classList.add('bg-gray-300');
        }
        
        if (markButton) {
            markButton.style.display = 'none';
        }
    }
    
    // Update notification badge
    updateNotificationBadge();
    showNotification('Notification marked as read', 'success');
}

// View all notifications
function viewAllNotifications() {
    console.log('Viewing all notifications');
    
    // Here you would redirect to notifications page
    showNotification('Redirecting to notifications page...', 'info');
}

// Update notification badge
function updateNotificationBadge(count = null) {
    const badge = document.getElementById('notification-badge');
    if (badge) {
        if (count !== null) {
            badge.textContent = count > 99 ? '99+' : count.toString();
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }
}

// Background saving process when logout is clicked
document.addEventListener('DOMContentLoaded', function() {
    const logoutForm = document.querySelector('form[action*="logout"]');
    
    if (logoutForm) {
        logoutForm.addEventListener('submit', function() {
            // Start background saving process
            console.log('Background saving process started...');
            
            // Simulate background saving (in real app, this would save user data)
            setTimeout(() => {
                console.log('Background saving completed');
            }, 500);
        });
    }
});

// Initialize notification badge on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set initial notification count (this would come from server)
    updateNotificationBadge(3); // Example: 3 unread notifications
});
</script>

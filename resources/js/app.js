// GPTFMS - Local JavaScript functionality

// Import specific lucide icons
import { 
    Home, 
    Users, 
    Folder, 
    BarChart3, 
    FileText, 
    MessageSquare, 
    User, 
    Settings,
    Bell,
    Search,
    Menu,
    X,
    ChevronDown,
    ChevronRight,
    LogOut,
    Edit,
    Trash2,
    Plus,
    Eye,
    EyeOff,
    Check,
    XCircle,
    AlertCircle,
    TrendingUp,
    TrendingDown,
    Calendar,
    Clock,
    Filter,
    Download,
    Upload,
    RefreshCw,
    Save,
    Mail,
    Phone,
    MapPin,
    Briefcase,
    BookOpen,
    Award,
    Target,
    Zap,
    Shield,
    Lock,
    Unlock,
    Key,
    Database,
    Server,
    Cloud,
    Wifi,
    Battery,
    Signal,
    Volume2,
    VolumeX,
    Play,
    Pause,
    Square,
    SkipBack,
    SkipForward,
    Repeat,
    Shuffle,
    Heart,
    Star,
    ThumbsUp,
    ThumbsDown,
    Share2,
    Link,
    Copy,
    Clipboard,
    Scissors,
    Move,
    Maximize2,
    Minimize2,
    MoreVertical,
    MoreHorizontal,
    ChevronLeft,
    ChevronUp,
    ArrowUp,
    ArrowDown,
    ArrowLeft,
    ArrowRight,
    ArrowUpRight,
    ArrowDownRight,
    ArrowUpLeft,
    ArrowDownLeft,
    HelpCircle
} from 'lucide';

// Initialize lucide icons
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all lucide icons
    const icons = {
        home: Home,
        users: Users,
        folder: Folder,
        'bar-chart-3': BarChart3,
        'file-text': FileText,
        'message-square': MessageSquare,
        user: User,
        settings: Settings,
        bell: Bell,
        search: Search,
        menu: Menu,
        x: X,
        'chevron-down': ChevronDown,
        'chevron-right': ChevronRight,
        'log-out': LogOut,
        edit: Edit,
        'trash-2': Trash2,
        plus: Plus,
        eye: Eye,
        'eye-off': EyeOff,
        check: Check,
        'x-circle': XCircle,
        'alert-circle': AlertCircle,
        'trending-up': TrendingUp,
        'trending-down': TrendingDown,
        calendar: Calendar,
        clock: Clock,
        filter: Filter,
        download: Download,
        upload: Upload,
        'refresh-cw': RefreshCw,
        save: Save,
        mail: Mail,
        phone: Phone,
        'map-pin': MapPin,
        briefcase: Briefcase,
        'book-open': BookOpen,
        award: Award,
        target: Target,
        zap: Zap,
        shield: Shield,
        lock: Lock,
        unlock: Unlock,
        key: Key,
        database: Database,
        server: Server,
        cloud: Cloud,
        wifi: Wifi,
        battery: Battery,
        signal: Signal,
        'volume-2': Volume2,
        'volume-x': VolumeX,
        play: Play,
        pause: Pause,
        square: Square,
        'skip-back': SkipBack,
        'skip-forward': SkipForward,
        repeat: Repeat,
        shuffle: Shuffle,
        heart: Heart,
        star: Star,
        'thumbs-up': ThumbsUp,
        'thumbs-down': ThumbsDown,
        'share-2': Share2,
        link: Link,
        copy: Copy,
        clipboard: Clipboard,
        scissors: Scissors,
        move: Move,
        'maximize-2': Maximize2,
        'minimize-2': Minimize2,
        'more-vertical': MoreVertical,
        'more-horizontal': MoreHorizontal,
        'chevron-left': ChevronLeft,
        'chevron-up': ChevronUp,
        'arrow-up': ArrowUp,
        'arrow-down': ArrowDown,
        'arrow-left': ArrowLeft,
        'arrow-right': ArrowRight,
        'arrow-up-right': ArrowUpRight,
        'arrow-down-right': ArrowDownRight,
        'arrow-up-left': ArrowUpLeft,
        'arrow-down-left': ArrowDownLeft,
        'help-circle': HelpCircle
    };
    
    // Replace all data-lucide elements with SVG icons
    document.querySelectorAll('[data-lucide]').forEach(element => {
        const iconName = element.getAttribute('data-lucide');
        const iconClass = element.getAttribute('class') || '';
        
        if (icons[iconName]) {
            const icon = icons[iconName];
            const svg = icon({
                class: iconClass,
                width: 20,
                height: 20,
                'aria-hidden': true
            });
            element.parentNode.replaceChild(svg, element);
        }
    });
    
    // Initialize app functionality
    initializeApp();
});

// App initialization
function initializeApp() {
    // Initialize page transitions first
    initializePageTransitions();
    
    // Initialize all components
    initializeSidebar();
    initializeDropdowns();
    initializeModals();
    initializeForms();
    initializeNotifications();
    initializeTheme();
    initializeFadeAnimations();
}

// Sidebar functionality
function initializeSidebar() {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    
    if (sidebar && mainContent) {
        // Check if this is first page load (login)
        const isFirstLoad = !sessionStorage.getItem('sidebar-first-load');
        
        // Get saved state
        const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
        
        if (isFirstLoad) {
            // Apply initial state with animation on first load (login)
            if (isCollapsed) {
                sidebar.setAttribute('class', 'fixed left-0 top-0 h-full bg-gray-900 text-white z-50 w-16 sidebar-transition collapsed');
                mainContent.setAttribute('class', 'flex-1 flex flex-col ml-16 sidebar-transition main-content');
            } else {
                sidebar.setAttribute('class', 'fixed left-0 top-0 h-full bg-gray-900 text-white z-50 w-64 sidebar-transition');
                mainContent.setAttribute('class', 'flex-1 flex flex-col ml-64 sidebar-transition main-content');
            }
            
            // Mark first load as complete
            sessionStorage.setItem('sidebar-first-load', 'true');
        } else {
            // Apply state immediately without animation on navigation
            if (isCollapsed) {
                sidebar.setAttribute('class', 'fixed left-0 top-0 h-full bg-gray-900 text-white z-50 w-16 collapsed');
                mainContent.setAttribute('class', 'flex-1 flex flex-col ml-16 main-content');
            } else {
                sidebar.setAttribute('class', 'fixed left-0 top-0 h-full bg-gray-900 text-white z-50 w-64');
                mainContent.setAttribute('class', 'flex-1 flex flex-col ml-64 main-content');
            }
        }
        
        // Apply transitions after initial state is set (only on first load)
        if (isFirstLoad) {
            setTimeout(() => {
                sidebar.style.transition = 'all 0.3s ease-in-out';
                mainContent.style.transition = 'all 0.3s ease-in-out';
            }, 50);
        }
        
        // Setup toggle button if exists
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                window.toggleSidebar();
            });
        }
    }
}

// Global toggleSidebar function for menu buttons
window.toggleSidebar = function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    
    if (sidebar && mainContent) {
        const isCollapsed = sidebar.classList.contains('collapsed');
        
        // Toggle sidebar classes
        sidebar.classList.toggle('collapsed');
        
        // Update main content margin
        if (isCollapsed) {
            // Expanding sidebar
            sidebar.classList.remove('w-16');
            sidebar.classList.add('w-64');
            mainContent.classList.remove('ml-16');
            mainContent.classList.add('ml-64');
        } else {
            // Collapsing sidebar
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-16');
            mainContent.classList.remove('ml-64');
            mainContent.classList.add('ml-16');
        }
        
        // Save state to localStorage
        localStorage.setItem('sidebar-collapsed', !isCollapsed);
        
        // Add visual feedback
        sidebar.style.transition = 'all 0.3s ease-in-out';
        mainContent.style.transition = 'all 0.3s ease-in-out';
    }
};

// Dropdown functionality
function initializeDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(dropdown => {
        const trigger = dropdown.querySelector('.dropdown-trigger');
        const menu = dropdown.querySelector('.dropdown-menu');
        
        if (trigger && menu) {
            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function() {
                menu.classList.add('hidden');
            });
        }
    });
    
    // Specific Groups dropdown handling
    const groupsDropdown = document.getElementById('groups-dropdown');
    const groupsButton = document.querySelector('[onclick="toggleGroupsDropdown()"]');
    
    if (groupsDropdown && groupsButton) {
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!groupsButton.contains(e.target) && !groupsDropdown.contains(e.target)) {
                groupsDropdown.classList.add('hidden');
                document.getElementById('groups-chevron').classList.remove('rotate-180');
            }
        });
        
        // Prevent dropdown from closing when clicking inside
        groupsDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    
    // Add click listeners to other menu items to close dropdowns
    const menuLinks = document.querySelectorAll('.sidebar-link:not([onclick*="toggleGroupsDropdown"])');
    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            closeAllDropdowns();
        });
    });
    
    // Specific Profile dropdown handling
    const profileDropdown = document.getElementById('profile-dropdown');
    const profileButton = document.getElementById('profile-dropdown-trigger');
    
    // Only initialize profile dropdown if elements exist
    if (profileDropdown && profileButton) {
        console.log('Profile dropdown elements found, initializing...');
        
        profileButton.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.classList.add('hidden');
            }
        });
        
        // Prevent dropdown from closing when clicking inside
        profileDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        
        console.log('Profile dropdown initialized successfully');
    } else {
        // Silently handle missing profile dropdown elements - not all pages have them
        console.log('Profile dropdown elements not found on this page (this is normal)');
    }
}

// Modal functionality
function initializeModals() {
    const modals = document.querySelectorAll('.modal');
    
    modals.forEach(modal => {
        const triggers = document.querySelectorAll(`[data-modal="${modal.id}"]`);
        const close = modal.querySelector('.modal-close');
        
        triggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                modal.classList.remove('hidden');
                document.body.classList.add('modal-open');
            });
        });
        
        if (close) {
            close.addEventListener('click', function() {
                modal.classList.add('hidden');
                document.body.classList.remove('modal-open');
            });
        }
        
        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('modal-open');
            }
        });
    });
}

// Form functionality
function initializeForms() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        // Add form validation
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                showFormErrors(form);
            }
        });
        
        // Add real-time validation
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(input);
            });
        });
    });
}

// Field validation
function validateField(field) {
    const isValid = field.checkValidity();
    const errorElement = field.parentNode.querySelector('.field-error');
    
    if (!isValid) {
        field.classList.add('border-red-500');
        if (errorElement) {
            errorElement.textContent = field.validationMessage;
            errorElement.classList.remove('hidden');
        }
    } else {
        field.classList.remove('border-red-500');
        if (errorElement) {
            errorElement.classList.add('hidden');
        }
    }
    
    return isValid;
}

// Show form errors
function showFormErrors(form) {
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        validateField(input);
    });
}

// Notification system
function initializeNotifications() {
    // Only check for notification permission if user interacts with the page
    // Don't request permission automatically on page load
    if ('Notification' in window && Notification.permission === 'default') {
        // Add a small notification permission button to the page if needed
        const permissionButton = document.createElement('button');
        permissionButton.className = 'fixed bottom-4 right-4 px-3 py-2 bg-blue-600 text-white text-xs rounded-lg shadow-lg z-50';
        permissionButton.textContent = 'Enable Notifications';
        permissionButton.onclick = function() {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    showNotification('Notifications enabled!', 'success');
                }
                permissionButton.remove();
            });
        };
        // Only show the button after a delay to avoid being intrusive
        setTimeout(() => {
            if (Notification.permission === 'default') {
                document.body.appendChild(permissionButton);
            }
        }, 5000);
    }
}

// Theme functionality
function initializeTheme() {
    const themeToggle = document.getElementById('theme-toggle');
    const savedTheme = localStorage.getItem('theme') || 'light';
    
    // Apply saved theme
    document.documentElement.setAttribute('data-theme', savedTheme);
    
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    }
}

// Initialize fade animations for authenticated pages
function initializeFadeAnimations() {
    // Only apply to authenticated pages (not login/register)
    if (window.location.pathname === '/login' || window.location.pathname === '/register') {
        return;
    }
    
    // Completely disable all animations - no fading anywhere
    // Sidebar menu text and all other elements remain static
    return;
    
    /*
    // Apply fade animations to main content elements only
    const mainContent = document.getElementById('main-content-area');
    if (mainContent) {
        // Only fade in the main content area itself, not individual elements
        mainContent.classList.add('fade-in');
        
        // Commented out all individual element animations to prevent any fading
        // Apply staggered animations to content elements only
        const elementsToAnimate = [
            '.stats-card',
            '.card',
            '.table-container',
            '.form-section',
            '.button-group',
            '.notification-item',
            '.message-item',
            '.group-card',
            '.project-card',
            '.user-card'
        ];
        
        elementsToAnimate.forEach((selector, index) => {
            const elements = mainContent.querySelectorAll(selector);
            elements.forEach((element, elementIndex) => {
                element.classList.add('fade-in-up', `stagger-${(elementIndex % 5) + 1}`);
            });
        });
        
        // Apply animations to headers in content area only (exclude sidebar and header)
        const headers = mainContent.querySelectorAll('h1, h2, h3, h4, h5, h6');
        headers.forEach((header, index) => {
            header.classList.add('fade-in-down', `stagger-${(index % 3) + 1}`);
        });
        
        // Apply animations to buttons in content area only (exclude sidebar menu items)
        const buttons = mainContent.querySelectorAll('.btn, button');
        buttons.forEach((button, index) => {
            // Skip if button is in sidebar
            if (!button.closest('#sidebar')) {
                button.classList.add('fade-in', `stagger-${(index % 4) + 1}`);
            }
        });
        
        // Apply animations to tables in content area only
        const tables = mainContent.querySelectorAll('table');
        tables.forEach((table, index) => {
            table.classList.add('fade-in-up', `stagger-${(index % 2) + 1}`);
            
            // Animate table rows
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach((row, rowIndex) => {
                row.classList.add('fade-in', `stagger-${(rowIndex % 5) + 1}`);
            });
        });
        
        // Apply animations to forms in content area only
        const forms = mainContent.querySelectorAll('form');
        forms.forEach((form, index) => {
            form.classList.add('fade-in-right', `stagger-${(index % 2) + 1}`);
            
            // Animate form inputs
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach((input, inputIndex) => {
                input.classList.add('fade-in', `stagger-${(inputIndex % 4) + 1}`);
            });
        });
    }
    */
}

// Utility functions
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-message">${message}</span>
            <button class="notification-close" onclick="this.parentElement.parentElement.remove()">
                <X class="icon-sm" />
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

function formatDate(date) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function formatTime(date) {
    return new Date(date).toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit'
    });
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Initialize page transitions (removed to prevent header/sidebar fading)
function initializePageTransitions() {
    // Page transitions disabled - only content area should fade
    
    // Initialize user management specific functionality if on users page
    if (window.location.pathname.includes('/admin/users') || window.location.pathname.includes('/users')) {
        initializeUserManagement();
    }
}

// User Management specific initialization
function initializeUserManagement() {
    // Search functionality
    const searchInput = document.getElementById('userSearch');
    if (searchInput) {
        searchInput.addEventListener('input', window.filterUsers);
    }
    
    // Filter functionality
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    if (roleFilter) roleFilter.addEventListener('change', window.filterUsers);
    if (statusFilter) statusFilter.addEventListener('change', window.filterUsers);
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + N: Add new user
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            window.addUser();
        }
        // Ctrl/Cmd + E: Export users
        if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
            e.preventDefault();
            window.exportUsers();
        }
        // Ctrl/Cmd + I: Import users
        if ((e.ctrlKey || e.metaKey) && e.key === 'i') {
            e.preventDefault();
            window.showImportModal();
        }
        // Ctrl/Cmd + B: Bulk actions
        if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
            e.preventDefault();
            window.bulkActions();
        }
        // Ctrl/Cmd + F: Focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            searchInput?.focus();
        }
    });
}

// Groups dropdown toggle function
function toggleGroupsDropdown() {
    const dropdown = document.getElementById('groups-dropdown');
    const chevron = document.getElementById('groups-chevron');
    
    if (dropdown && chevron) {
        const isHidden = !dropdown.classList.contains('show');
        
        // Close all other dropdowns first
        closeAllDropdowns();
        
        // If it was hidden, open this one
        if (isHidden) {
            dropdown.classList.add('show');
            chevron.classList.add('rotate-180');
            console.log('Groups dropdown opened');
        } else {
            dropdown.classList.remove('show');
            chevron.classList.remove('rotate-180');
            console.log('Groups dropdown closed');
        }
    } else {
        console.error('Groups dropdown elements not found:', {
            dropdown: !!dropdown,
            chevron: !!chevron
        });
    }
}

// Close all dropdowns function
function closeAllDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown-menu');
    const chevrons = document.querySelectorAll('[id$="-chevron"]');
    
    dropdowns.forEach(dropdown => {
        dropdown.classList.remove('show');
    });
    
    chevrons.forEach(chevron => {
        chevron.classList.remove('rotate-180');
    });
}

// Auto-hide dropdown when clicking outside
document.addEventListener('click', function(event) {
    const groupsDropdown = document.getElementById('groups-dropdown');
    const groupsButton = event.target.closest('.nav-item');
    
    if (groupsDropdown && !groupsButton) {
        closeAllDropdowns();
    }
});

// Auto-hide dropdown when clicking other menu items
document.addEventListener('click', function(event) {
    const clickedLink = event.target.closest('a');
    const groupsDropdown = document.getElementById('groups-dropdown');
    
    if (clickedLink && groupsDropdown && !clickedLink.closest('#groups-dropdown')) {
        // Don't hide if clicking within the dropdown
        if (!clickedLink.closest('.dropdown-menu')) {
            closeAllDropdowns();
        }
    }
});


// Fallback profile dropdown function
function toggleProfileDropdown() {
    const dropdown = document.getElementById('profile-dropdown');
    const button = document.getElementById('profile-dropdown-trigger');
    
    console.log('Fallback toggleProfileDropdown called:', {
        dropdown: !!dropdown,
        button: !!button
    });
    
    if (dropdown && button) {
        // If no event listeners are attached, add them
        if (!button.hasAttribute('data-dropdown-initialized')) {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
                console.log('Fallback dropdown toggled');
            });
            
            document.addEventListener('click', function(e) {
                if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
            
            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
            
            button.setAttribute('data-dropdown-initialized', 'true');
            console.log('Fallback dropdown event listeners attached');
        }
        
        dropdown.classList.toggle('hidden');
        console.log('Fallback dropdown state:', dropdown.classList.contains('hidden'));
    } else {
        console.error('Fallback: Profile dropdown elements not found');
    }
}

// Navigate to page with fade transition
function navigateToPage(url) {
    if (!url) return;
    
    // Add fade out effect
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.3s ease-in-out';
    
    // Navigate after transition
    setTimeout(() => {
        window.location.href = url;
    }, 300);
}

// Export functions for global use
window.GPTFMS = {
    showNotification,
    confirmAction,
    formatDate,
    formatTime,
    debounce,
    throttle,
    // Initialize all components
    initializeApp,
    initializeSidebar,
    initializeDropdowns,
    initializeModals,
    initializeForms,
    initializeNotifications,
    initializeTheme,
    initializeFadeAnimations,
    navigateToPage,
    initializePageTransitions,
    toggleGroupsDropdown,
    closeAllDropdowns
};

// User Management Functions (make them globally available)
window.downloadTemplate = function() {
    // Create CSV template for user import
    const csvContent = "Name,Email,Role,Status,Phone\nJohn Doe,john.doe@example.com,student,active,+1234567890\nJane Smith,jane.smith@example.com,supervisor,active,+1234567891\n";
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'user_import_template.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    showNotification('Template downloaded successfully', 'success');
};

window.showImportModal = function() {
    // Enhanced import modal with file upload and template download
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-xl font-semibold mb-4">Import Users</h3>
            
            <div class="mb-6">
                <h4 class="font-medium mb-2">Instructions:</h4>
                <ol class="text-sm text-gray-600 space-y-1 list-decimal list-inside">
                    <li>Download the CSV template below</li>
                    <li>Fill in user data (name, email, role, status, phone)</li>
                    <li>Upload the completed CSV file</li>
                    <li>Click Import to process the file</li>
                </ol>
            </div>
            
            <div class="mb-4">
                <button onclick="downloadTemplate()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 mb-4">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download CSV Template
                </button>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload CSV File:</label>
                <input type="file" accept=".csv" class="w-full p-2 border rounded mb-2" id="importFile">
                <p class="text-xs text-gray-500">Supported format: CSV (Comma Separated Values)</p>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</button>
                <button onclick="processImport()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Import Users</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
};

window.exportUsers = function() {
    // Enhanced export with options
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Export Options</h3>
            
            <div class="space-y-3 mb-4">
                <label class="flex items-center">
                    <input type="checkbox" id="exportActive" checked class="mr-2">
                    <span>Active Users</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" id="exportInactive" checked class="mr-2">
                    <span>Inactive Users</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" id="exportAdmin" checked class="mr-2">
                    <span>Admin Users</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" id="exportSupervisor" checked class="mr-2">
                    <span>Supervisor Users</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" id="exportStudent" checked class="mr-2">
                    <span>Student Users</span>
                </label>
            </div>
            
            <div class="flex justify-end space-x-2">
                <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</button>
                <button onclick="processExport()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Export</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
};

window.processExport = function() {
    // Build export parameters based on selected options
    const params = new URLSearchParams();
    
    if (document.getElementById('exportActive').checked) params.append('status', 'active');
    if (document.getElementById('exportInactive').checked) params.append('status', 'inactive');
    if (document.getElementById('exportAdmin').checked) params.append('role', 'admin');
    if (document.getElementById('exportSupervisor').checked) params.append('role', 'supervisor');
    if (document.getElementById('exportStudent').checked) params.append('role', 'student');
    
    // Close modal and start export
    document.querySelector('.fixed').remove();
    
    // Redirect to export endpoint with parameters
    window.location.href = `/admin/users/export?${params.toString()}`;
    
    showNotification('Export started...', 'success');
};

window.processImport = function() {
    const fileInput = document.getElementById('importFile');
    if (fileInput.files.length > 0) {
        showNotification('Import feature coming soon', 'info');
        document.querySelector('.fixed').remove();
    } else {
        alert('Please select a file to import');
    }
};

// Additional user management helper functions
window.viewUserDetails = function(userId) {
    window.location.href = `/users/${userId}`;
};

window.editUser = function(userId) {
    window.location.href = `/users/${userId}/edit`;
};

window.toggleUserStatus = function(userId, currentStatus) {
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    const action = newStatus === 'active' ? 'activate' : 'deactivate';
    
    if (confirm(`Are you sure you want to ${action} this user?`)) {
        fetch(`/admin/users/${userId}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                window.location.reload();
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to update user status', 'error');
        });
    }
};

window.editUserRole = function(userId, currentRole) {
    const roles = ['admin', 'supervisor', 'student'];
    const currentRoleIndex = roles.indexOf(currentRole);
    const nextRole = roles[(currentRoleIndex + 1) % roles.length];
    
    if (confirm(`Change user role from "${currentRole}" to "${nextRole}"?`)) {
        fetch(`/admin/users/${userId}/role`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            },
            body: JSON.stringify({ role: nextRole })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                window.location.reload();
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to update user role', 'error');
        });
    }
};

window.resetPassword = function(userId, userName) {
    if (confirm(`Reset password for "${userName}"?\n\nA new temporary password will be generated and sent to their email.`)) {
        fetch(`/admin/users/${userId}/reset-password`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to reset password', 'error');
        });
    }
};

window.addUser = function() {
    window.location.href = '/register';
};

window.confirmDelete = function(userName) {
    return confirm(`Are you sure you want to delete the user "${userName}"? This action cannot be undone.`);
};

window.filterUsers = function() {
    const searchTerm = document.getElementById('userSearch')?.value.toLowerCase() || '';
    const roleFilter = document.getElementById('roleFilter')?.value.toLowerCase() || '';
    const statusFilter = document.getElementById('statusFilter')?.value.toLowerCase() || '';
    const userCards = document.querySelectorAll('.grid > div');
    
    userCards.forEach(card => {
        const userName = card.querySelector('h3')?.textContent.toLowerCase() || '';
        const userEmail = card.querySelector('p')?.textContent.toLowerCase() || '';
        const userRole = card.querySelector('span[class*="bg-"]')?.textContent.toLowerCase() || '';
        const userStatus = card.querySelector('.space-y-2 > div:first-child span span')?.textContent.toLowerCase() || '';
        
        const matchesSearch = userName.includes(searchTerm) || userEmail.includes(searchTerm);
        const matchesRole = !roleFilter || userRole === roleFilter;
        const matchesStatus = !statusFilter || userStatus === statusFilter;
        
        const shouldShow = matchesSearch && matchesRole && matchesStatus;
        card.style.display = shouldShow ? '' : 'none';
    });
};

window.clearFilters = function() {
    const searchInput = document.getElementById('userSearch');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    
    if (searchInput) searchInput.value = '';
    if (roleFilter) roleFilter.value = '';
    if (statusFilter) statusFilter.value = '';
    
    filterUsers();
};

window.bulkActions = function() {
    // Show bulk actions modal
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Bulk Actions</h3>
            <div class="space-y-2">
                <button onclick="bulkActivate()" class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Bulk Activate</button>
                <button onclick="bulkDeactivate()" class="w-full px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Bulk Deactivate</button>
                <button onclick="bulkDelete()" class="w-full px-4 py-2 bg-red-700 text-white rounded hover:bg-red-800">Bulk Delete</button>
                <button onclick="bulkRoleChange()" class="w-full px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Bulk Role Change</button>
            </div>
            <div class="mt-4">
                <button onclick="this.closest('.fixed').remove()" class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded">Cancel</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
};

window.bulkActivate = function() {
    if (confirm('Activate all filtered users?')) {
        showNotification('Bulk activation feature coming soon', 'info');
    }
};

window.bulkDeactivate = function() {
    if (confirm('Deactivate all filtered users?')) {
        showNotification('Bulk deactivation feature coming soon', 'info');
    }
};

window.bulkDelete = function() {
    if (confirm('Delete all filtered users? This action cannot be undone!')) {
        showNotification('Bulk deletion feature coming soon', 'info');
    }
};

window.bulkRoleChange = function() {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Change Role for All Filtered Users</h3>
            <select class="w-full p-2 border rounded mb-4" id="bulkRoleSelect">
                <option value="admin">Admin</option>
                <option value="supervisor">Supervisor</option>
                <option value="student">Student</option>
            </select>
            <div class="flex justify-end space-x-2">
                <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Cancel</button>
                <button onclick="processBulkRoleChange()" class="px-4 py-2 bg-purple-600 text-white rounded">Change Role</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
};

window.processBulkRoleChange = function() {
    const role = document.getElementById('bulkRoleSelect').value;
    showNotification(`Bulk role change to "${role}" feature coming soon`, 'info');
    document.querySelector('.fixed').remove();
};

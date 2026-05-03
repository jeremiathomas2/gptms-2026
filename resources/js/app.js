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
    
    // Initialize sidebar
    initializeSidebar();
    
    // Initialize dropdowns
    initializeDropdowns();
    
    // Initialize modals
    initializeModals();
    
    // Initialize forms
    initializeForms();
    
    // Initialize notifications
    initializeNotifications();
    
    // Initialize theme
    initializeTheme();
}

// Sidebar functionality
function initializeSidebar() {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
        });
        
        // Restore sidebar state
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            sidebar.classList.add('collapsed');
        }
    }
}

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
    
    console.log('Profile dropdown elements:', {
        dropdown: profileDropdown,
        button: profileButton
    });
    
    if (profileDropdown && profileButton) {
        console.log('Initializing profile dropdown...');
        
        profileButton.addEventListener('click', function(e) {
            e.stopPropagation();
            console.log('Profile dropdown clicked, current state:', profileDropdown.classList.contains('hidden'));
            profileDropdown.classList.toggle('hidden');
            console.log('New state:', profileDropdown.classList.contains('hidden'));
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
        console.error('Profile dropdown elements not found:', {
            dropdown: !!profileDropdown,
            button: !!profileButton
        });
        
        // Try to initialize after a delay in case DOM is not ready
        setTimeout(function() {
            const delayedDropdown = document.getElementById('profile-dropdown');
            const delayedButton = document.getElementById('profile-dropdown-trigger');
            
            console.log('Retrying profile dropdown initialization:', {
                dropdown: !!delayedDropdown,
                button: !!delayedButton
            });
            
            if (delayedDropdown && delayedButton) {
                delayedButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    delayedDropdown.classList.toggle('hidden');
                });
                
                document.addEventListener('click', function(e) {
                    if (!delayedButton.contains(e.target) && !delayedDropdown.contains(e.target)) {
                        delayedDropdown.classList.add('hidden');
                    }
                });
                
                delayedDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
                
                console.log('Profile dropdown initialized on retry');
            }
        }, 1000);
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
    // Check for notification permission
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
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
}

// Close all dropdowns function
function closeAllDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown-menu');
    const chevrons = document.querySelectorAll('[id$="-chevron"]');
    
    dropdowns.forEach(dropdown => {
        dropdown.classList.add('hidden');
        dropdown.classList.remove('dropdown-enter');
    });
    
    chevrons.forEach(chevron => {
        chevron.classList.remove('rotate-180');
    });
}

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

// Export functions for global use
window.GPTFMS = {
    showNotification,
    confirmAction,
    formatDate,
    formatTime,
    debounce,
    throttle,
    initializeApp,
    initializeSidebar,
    initializeDropdowns,
    initializeModals,
    initializeForms,
    initializeNotifications,
    initializeTheme,
    navigateToPage,
    initializePageTransitions
};

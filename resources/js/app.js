// GPTFMS - Local JavaScript functionality

// Custom icon implementations to avoid Lucide SVG decimal coordinate issues
const createIcon = (name, svgContent) => ({
    name,
    icon: ({ class: className = '', width = 20, height = 20, ...props }) => {
        const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svg.setAttribute('class', className);
        svg.setAttribute('width', width);
        svg.setAttribute('height', height);
        svg.setAttribute('viewBox', '0 0 24 24');
        svg.setAttribute('fill', 'none');
        svg.setAttribute('stroke', 'currentColor');
        svg.setAttribute('stroke-width', '2');
        svg.setAttribute('stroke-linecap', 'round');
        svg.setAttribute('stroke-linejoin', 'round');
        svg.innerHTML = svgContent;
        return svg;
    }
});

// Define custom icons without decimal coordinates
const Home = createIcon('home', '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/>');
const Users = createIcon('users', '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3"/><path d="M16 3a4 4 0 010 8"/>');
const Folder = createIcon('folder', '<path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>');
const BarChart3 = createIcon('bar-chart-3', '<path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/>');
const FileText = createIcon('file-text', '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10,9 9,9 8,9"/>');
const MessageSquare = createIcon('message-square', '<path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>');
const User = createIcon('user', '<path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>');
const Settings = createIcon('settings', '<circle cx="12" cy="12" r="3"/><path d="M12 1v6m0 6v6m4.22-13.22l4.24 4.24M1.54 9.96l4.24 4.24M20.46 14.04l-4.24 4.24M7.76 7.76L3.52 3.52"/>');
const Bell = createIcon('bell', '<path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>');
const Search = createIcon('search', '<circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>');
const Menu = createIcon('menu', '<line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="20" y2="18"/>');
const X = createIcon('x', '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>');
const ChevronDown = createIcon('chevron-down', '<polyline points="6,9 12,15 18,9"/>');
const ChevronRight = createIcon('chevron-right', '<polyline points="9,18 15,12 9,6"/>');
const LogOut = createIcon('log-out', '<path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16,17 21,12 16,7"/><line x1="21" y1="12" x2="9" y2="12"/>');
const Edit = createIcon('edit', '<path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>');
const Trash2 = createIcon('trash-2', '<polyline points="3,6 5,6 21,6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>');
const Plus = createIcon('plus', '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>');
const Eye = createIcon('eye', '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>');
const EyeOff = createIcon('eye-off', '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>');
const Check = createIcon('check', '<polyline points="20,6 9,17 4,12"/>');
const XCircle = createIcon('x-circle', '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>');
const AlertCircle = createIcon('alert-circle', '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>');
const TrendingUp = createIcon('trending-up', '<polyline points="23,6 13.5,15.5 8.5,10.5 2,17"/><polyline points="16,7 22,7 22,13"/>');
const TrendingDown = createIcon('trending-down', '<polyline points="23,18 13.5,8.5 8.5,13.5 2,6"/><polyline points="16,13 22,13 22,7"/>');
const Calendar = createIcon('calendar', '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>');
const Clock = createIcon('clock', '<circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/>');
const Filter = createIcon('filter', '<polygon points="22,3 2,3 10,12.46 10,19 14,21 14,12.46 22,3"/>');
const Download = createIcon('download', '<path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/>');
const Upload = createIcon('upload', '<path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17,8 12,3 7,8"/><line x1="12" y1="3" x2="12" y2="15"/>');
const RefreshCw = createIcon('refresh-cw', '<polyline points="23,4 23,10 17,10"/><polyline points="1,20 1,14 7,14"/><path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/>');
const Save = createIcon('save', '<path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17,21 17,13 7,13 7,21"/><polyline points="7,3 7,8 15,8"/>');
const Mail = createIcon('mail', '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>');
const Phone = createIcon('phone', '<path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>');
const MapPin = createIcon('map-pin', '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>');
const Briefcase = createIcon('briefcase', '<rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/>');
const BookOpen = createIcon('book-open', '<path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 003-3h7z"/>');
const Award = createIcon('award', '<circle cx="12" cy="8" r="7"/><polyline points="8.21,13.89 7,23 12,20 17,23 15.79,13.88"/><path d="M12 2l2.39 4.84L20 7.5l-4 3.9L18.5 17 12 13.5 5.5 17 7 11.4 3 7.5l5.61-.66z"/>');
const Target = createIcon('target', '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>');
const Zap = createIcon('zap', '<polygon points="13,2 3,14 12,14 11,22 21,10 12,10 13,2"/>');
const Shield = createIcon('shield', '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>');
const Lock = createIcon('lock', '<rect x="3" y="11" width="18" height="10" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>');
const Unlock = createIcon('unlock', '<rect x="3" y="11" width="18" height="10" rx="2" ry="2"/><path d="M7 11V7a5 5 0 019.9-1"/>');
const Key = createIcon('key', '<path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 11-7.778 7.778 5.5 5.5 0 017.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/>');
const Database = createIcon('database', '<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>');
const Server = createIcon('server', '<rect x="2" y="3" width="20" height="4" rx="2"/><rect x="2" y="9" width="20" height="4" rx="2"/><rect x="2" y="15" width="20" height="4" rx="2"/><line x1="6" y1="5" x2="6.01" y2="5"/><line x1="6" y1="11" x2="6.01" y2="11"/><line x1="6" y1="17" x2="6.01" y2="17"/>');
const Cloud = createIcon('cloud', '<path d="M18 10h-1.26A8 8 0 109 20h9a5 5 0 000-10z"/>');
const Wifi = createIcon('wifi', '<path d="M5 12.55a11 11 0 0114.08 0M1.42 9a16 16 0 0121.16 0m-6.54 8a4 4 0 015.16 0M9.5 16a2 2 0 015 0"/>');
const Battery = createIcon('battery', '<rect x="1" y="6" width="18" height="12" rx="2" ry="2"/><path d="M23 13v-2a1 1 0 00-1-1h-1"/>');
const Signal = createIcon('signal', '<path d="M2 20h2.5a2.5 2.5 0 002.5-2.5V17a2.5 2.5 0 00-2.5-2.5H2z"/><path d="M2 14h6.5a2.5 2.5 0 002.5-2.5V11a2.5 2.5 0 00-2.5-2.5H2z"/><path d="M2 8h10.5a2.5 2.5 0 002.5-2.5V5a2.5 2.5 0 00-2.5-2.5H2z"/>');
const Volume2 = createIcon('volume-2', '<polygon points="11,5 6,9 2,9 2,15 6,15 11,19 11,5"/><path d="M19.07 4.93a10 10 0 010 14.14M15.54 8.46a5 5 0 010 7.07"/>');
const VolumeX = createIcon('volume-x', '<polygon points="11,5 6,9 2,9 2,15 6,15 11,19 11,5"/><line x1="23" y1="9" x2="17" y2="15"/><line x1="17" y1="9" x2="23" y2="15"/>');
const Play = createIcon('play', '<polygon points="5,3 19,12 5,21 5,3"/>');
const Pause = createIcon('pause', '<rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/>');
const Square = createIcon('square', '<rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>');
const SkipBack = createIcon('skip-back', '<polygon points="19,20 9,12 19,4 19,20"/><polygon points="5,20 5,4 13,12 5,20"/>');
const SkipForward = createIcon('skip-forward', '<polygon points="5,4 15,12 5,20 5,4"/><polygon points="19,4 19,20 11,12 19,4"/>');
const Repeat = createIcon('repeat', '<polyline points="17,1 21,5 17,9"/><polyline points="7,23 3,19 7,15"/><rect x="1" y="9" width="22" height="6" rx="2" ry="2"/>');
const Shuffle = createIcon('shuffle', '<polyline points="16,3 21,3 21,8"/><path d="M4 20l4-4 4 4M21 15l-4-4-4 4M3 3h9l9 9M3 3l4 4 4-4"/>');
const Heart = createIcon('heart', '<path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>');
const Star = createIcon('star', '<polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26 12,2"/>');
const ThumbsUp = createIcon('thumbs-up', '<path d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 002-2l1.72-8.64A2 2 0 0018.72 9H14z"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h2"/>');
const ThumbsDown = createIcon('thumbs-down', '<path d="M10 15v4a3 3 0 003 3l4-9V2H5.72A2 2 0 003.72 4L2 12.64A2 2 0 004 15h6z"/><path d="M18 6h2a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>');
const Share2 = createIcon('share-2', '<circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.41" x2="15.42" y2="6.58"/><line x1="15.41" y1="17.59" x2="8.59" y2="10.41"/>');
const Link = createIcon('link', '<path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/>');
const Copy = createIcon('copy', '<rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>');
const Clipboard = createIcon('clipboard', '<rect x="9" y="2" width="6" height="4" rx="1" ry="1"/><path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"/>');
const Scissors = createIcon('scissors', '<circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><line x1="20" y1="4" x2="8.12" y2="15.88"/><line x1="14.47" y1="14.48" x2="20" y2="20"/><line x1="8.12" y1="8.12" x2="12" y2="12"/>');
const Move = createIcon('move', '<polyline points="5,9 2,12 5,15"/><polyline points="9,5 12,2 15,5"/><polyline points="15,19 12,22 9,19"/><polyline points="19,9 22,12 19,15"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="12" y1="2" x2="12" y2="22"/>');
const Maximize2 = createIcon('maximize-2', '<polyline points="15,3 21,3 21,9"/><polyline points="9,21 3,21 3,15"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/>');
const Minimize2 = createIcon('minimize-2', '<polyline points="4,14 10,14 10,20"/><polyline points="14,4 20,4 20,10"/><line x1="14" y1="10" x2="21" y2="3"/><line x1="3" y1="21" x2="10" y2="14"/>');
const MoreVertical = createIcon('more-vertical', '<circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/>');
const MoreHorizontal = createIcon('more-horizontal', '<circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/>');
const ChevronLeft = createIcon('chevron-left', '<polyline points="15,18 9,12 15,6"/>');
const ChevronUp = createIcon('chevron-up', '<polyline points="18,15 12,9 6,15"/>');
const ArrowUp = createIcon('arrow-up', '<line x1="12" y1="19" x2="12" y2="5"/><polyline points="5,12 12,5 19,12"/>');
const ArrowDown = createIcon('arrow-down', '<line x1="12" y1="5" x2="12" y2="19"/><polyline points="19,12 12,19 5,12"/>');
const ArrowLeft = createIcon('arrow-left', '<line x1="19" y1="12" x2="5" y2="12"/><polyline points="12,19 5,12 12,5"/>');
const ArrowRight = createIcon('arrow-right', '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12,5 19,12 12,19"/>');
const ArrowUpRight = createIcon('arrow-up-right', '<line x1="7" y1="17" x2="17" y2="7"/><polyline points="7,7 17,7 17,17"/>');
const ArrowDownRight = createIcon('arrow-down-right', '<line x1="7" y1="7" x2="17" y2="17"/><polyline points="7,17 17,17 17,7"/>');
const ArrowUpLeft = createIcon('arrow-up-left', '<line x1="17" y1="17" x2="7" y2="7"/><polyline points="17,7 7,7 7,17"/>');
const ArrowDownLeft = createIcon('arrow-down-left', '<line x1="17" y1="7" x2="7" y2="17"/><polyline points="17,17 7,17 7,7"/>');
const HelpCircle = createIcon('help-circle', '<circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/>');

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

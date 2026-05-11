// Responsive Design JavaScript for GPTFMS
class ResponsiveManager {
    constructor() {
        this.isMobile = window.innerWidth < 1024;
        this.isTablet = window.innerWidth >= 1024 && window.innerWidth < 1280;
        this.isDesktop = window.innerWidth >= 1280;
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.applyResponsiveClasses();
        this.setupTouchInteractions();
        this.optimizeForDevice();
    }
    
    setupEventListeners() {
        // Handle window resize
        window.addEventListener('resize', this.debounce(() => {
            this.updateDeviceType();
            this.applyResponsiveClasses();
            this.optimizeForDevice();
        }, 250));
        
        // Handle orientation change
        window.addEventListener('orientationchange', () => {
            setTimeout(() => {
                this.updateDeviceType();
                this.applyResponsiveClasses();
            }, 100);
        });
        
        // Handle sidebar toggle on mobile
        const sidebarToggle = document.getElementById('mobile-sidebar-toggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', this.toggleMobileSidebar.bind(this));
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (this.isMobile) {
                const sidebar = document.getElementById('sidebar');
                const toggle = document.getElementById('mobile-sidebar-toggle');
                
                if (sidebar && !sidebar.contains(e.target) && !toggle.contains(e.target)) {
                    this.closeMobileSidebar();
                }
            }
        });
    }
    
    updateDeviceType() {
        const width = window.innerWidth;
        this.isMobile = width < 1024;
        this.isTablet = width >= 1024 && width < 1280;
        this.isDesktop = width >= 1280;
    }
    
    applyResponsiveClasses() {
        const body = document.body;
        const mainContent = document.getElementById('main-content');
        
        // Remove existing device classes
        body.classList.remove('device-mobile', 'device-tablet', 'device-desktop');
        
        // Add current device class
        if (this.isMobile) {
            body.classList.add('device-mobile');
            this.applyMobileLayout(mainContent);
        } else if (this.isTablet) {
            body.classList.add('device-tablet');
            this.applyTabletLayout(mainContent);
        } else {
            body.classList.add('device-desktop');
            this.applyDesktopLayout(mainContent);
        }
    }
    
    applyMobileLayout(mainContent) {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            // Ensure sidebar is collapsed on mobile
            sidebar.classList.add('mobile-collapsed');
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-16');
        }
        
        if (mainContent) {
            mainContent.classList.add('mobile-full', 'sidebar-collapsed');
            mainContent.classList.remove('ml-64');
            mainContent.classList.add('ml-16');
        }
        
        // Optimize tables for mobile
        this.optimizeTablesForMobile();
        
        // Optimize forms for mobile
        this.optimizeFormsForMobile();
        
        // Optimize cards for mobile
        this.optimizeCardsForMobile();
    }
    
    applyTabletLayout(mainContent) {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            // Show sidebar text on tablet
            sidebar.classList.remove('mobile-collapsed');
            sidebar.classList.add('w-64');
            sidebar.classList.remove('w-16');
        }
        
        if (mainContent) {
            mainContent.classList.remove('mobile-full', 'sidebar-collapsed');
            mainContent.classList.add('ml-64');
            mainContent.classList.remove('ml-16');
        }
        
        // Optimize grid layouts for tablet
        this.optimizeGridsForTablet();
    }
    
    applyDesktopLayout(mainContent) {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            // Full sidebar on desktop
            sidebar.classList.remove('mobile-collapsed');
            sidebar.classList.add('w-64');
            sidebar.classList.remove('w-16');
        }
        
        if (mainContent) {
            mainContent.classList.remove('mobile-full', 'sidebar-collapsed');
            mainContent.classList.add('ml-64');
            mainContent.classList.remove('ml-16');
        }
    }
    
    optimizeTablesForMobile() {
        const tables = document.querySelectorAll('table');
        tables.forEach(table => {
            if (!table.closest('.no-mobile-optimize')) {
                table.classList.add('mobile-table');
                
                // Add horizontal scroll wrapper if needed
                if (!table.closest('.table-wrapper')) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'table-wrapper overflow-x-auto';
                    table.parentNode.insertBefore(wrapper, table);
                    wrapper.appendChild(table);
                }
            }
        });
    }
    
    optimizeFormsForMobile() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            if (!form.closest('.no-mobile-optimize')) {
                // Make inputs full width on mobile
                const inputs = form.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    input.classList.add('mobile-full');
                });
                
                // Stack buttons vertically on mobile
                const buttonGroups = form.querySelectorAll('.button-group');
                buttonGroups.forEach(group => {
                    group.classList.add('mobile-stacked');
                });
            }
        });
    }
    
    optimizeCardsForMobile() {
        const cardGrids = document.querySelectorAll('.stats-grid, .card-grid');
        cardGrids.forEach(grid => {
            if (!grid.closest('.no-mobile-optimize')) {
                grid.classList.add('mobile-single-column');
            }
        });
    }
    
    optimizeGridsForTablet() {
        const grids = document.querySelectorAll('.stats-grid, .card-grid');
        grids.forEach(grid => {
            if (!grid.closest('.no-tablet-optimize')) {
                grid.classList.add('tablet-two-column');
            }
        });
    }
    
    setupTouchInteractions() {
        if ('ontouchstart' in window) {
            // Add touch-friendly classes
            document.body.classList.add('touch-device');
            
            // Optimize buttons for touch
            const buttons = document.querySelectorAll('button, .btn');
            buttons.forEach(button => {
                button.classList.add('touch-friendly');
            });
            
            // Optimize links for touch
            const links = document.querySelectorAll('a');
            links.forEach(link => {
                link.classList.add('touch-friendly');
            });
        }
    }
    
    optimizeForDevice() {
        // Performance optimizations based on device
        if (this.isMobile) {
            this.enableMobileOptimizations();
        } else if (this.isDesktop) {
            this.enableDesktopOptimizations();
        }
    }
    
    enableMobileOptimizations() {
        // Reduce animations on mobile for better performance
        document.body.style.setProperty('--animation-duration', '0.1s');
        
        // Lazy load images
        this.lazyLoadImages();
        
        // Optimize scroll performance
        this.optimizeScrollPerformance();
    }
    
    enableDesktopOptimizations() {
        // Enable full animations on desktop
        document.body.style.setProperty('--animation-duration', '0.3s');
        
        // Enable hover effects
        document.body.classList.add('hover-enabled');
    }
    
    lazyLoadImages() {
        const images = document.querySelectorAll('img[data-src]');
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    }
    
    optimizeScrollPerformance() {
        let ticking = false;
        
        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(() => {
                    // Handle scroll-based animations
                    ticking = false;
                });
                ticking = true;
            }
        });
    }
    
    toggleMobileSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        
        if (sidebar && mainContent) {
            const isOpen = !sidebar.classList.contains('mobile-hidden');
            
            if (isOpen) {
                this.closeMobileSidebar();
            } else {
                this.openMobileSidebar();
            }
        }
    }
    
    openMobileSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        
        if (sidebar && mainContent) {
            sidebar.classList.remove('mobile-hidden');
            sidebar.classList.add('mobile-open');
            mainContent.classList.add('sidebar-open');
            
            // Add overlay
            this.addMobileOverlay();
        }
    }
    
    closeMobileSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        
        if (sidebar && mainContent) {
            sidebar.classList.add('mobile-hidden');
            sidebar.classList.remove('mobile-open');
            mainContent.classList.remove('sidebar-open');
            
            // Remove overlay
            this.removeMobileOverlay();
        }
    }
    
    addMobileOverlay() {
        if (!document.getElementById('mobile-overlay')) {
            const overlay = document.createElement('div');
            overlay.id = 'mobile-overlay';
            overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden';
            overlay.addEventListener('click', this.closeMobileSidebar.bind(this));
            document.body.appendChild(overlay);
        }
    }
    
    removeMobileOverlay() {
        const overlay = document.getElementById('mobile-overlay');
        if (overlay) {
            overlay.remove();
        }
    }
    
    debounce(func, wait) {
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
    
    // Public API
    refresh() {
        this.updateDeviceType();
        this.applyResponsiveClasses();
        this.optimizeForDevice();
    }
    
    isDevice(type) {
        switch (type) {
            case 'mobile':
                return this.isMobile;
            case 'tablet':
                return this.isTablet;
            case 'desktop':
                return this.isDesktop;
            default:
                return false;
        }
    }
}

// Initialize responsive manager when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.responsiveManager = new ResponsiveManager();
    
    // Make it globally available
    window.toggleSidebar = () => {
        window.responsiveManager.toggleMobileSidebar();
    };
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ResponsiveManager;
}

import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';

// Import dashboard components
import { AllGroups, MyGroups, CreateGroup, GroupRequests, GroupAnalytics } from './components/dashboard/groups/index.js';
import Projects from './components/dashboard/projects/Projects.jsx';
import Users from './components/dashboard/users/Users.jsx';
import Analytics from './components/dashboard/analytics/Analytics.jsx';
import Reports from './components/dashboard/reports/Reports.jsx';
import Messages from './components/dashboard/messages/Messages.jsx';
import Profile from './components/dashboard/profile/Profile.jsx';
import Settings from './components/dashboard/settings/Settings.jsx';
import { 
    BarChart3, 
    FolderOpen, 
    UserCog, 
    TrendingUp, 
    FileText, 
    Menu, 
    LogOut,
    Home,
    Plus,
    Send,
    Download,
    Activity,
    Target,
    Award,
    Clock,
    ChevronRight,
    ChevronDown,
    UserCircle,
    LogOut as SignOut,
    Settings as Cog,
    HelpCircle,
    Bell,
    Mail,
    Lock,
    LogIn as SignIn,
    Shield,
    UserPlus,
    User as UserIcon,
    Eye,
    EyeOff,
    ArrowLeft,
    Users as UsersIcon,
    UserCheck,
    Users2,
    GitBranch,
    Search,
    Filter,
    Calendar,
    MoreVertical,
    Edit,
    Trash2,
    UserX,
    CheckCircle,
    XCircle,
    AlertCircle,
    RefreshCw,
    DownloadCloud,
    Upload,
    Star,
    MessageSquare as MessageIcon,
    Zap,
    TrendingUp as TrendingUpIcon
} from 'lucide-react';

const Dashboard = () => {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);
    const [activeSection, setActiveSection] = useState('overview');
    const [sidebarOpen, setSidebarOpen] = useState(true);
    const [isTransitioning, setIsTransitioning] = useState(false);
    const [profileDropdownOpen, setProfileDropdownOpen] = useState(false);
    const [groupsDropdownOpen, setGroupsDropdownOpen] = useState(false);
    
    // Groups functionality state
    const [groups, setGroups] = useState([]);
    const [searchTerm, setSearchTerm] = useState('');
    const [filterStatus, setFilterStatus] = useState('all');
    const [sortBy, setSortBy] = useState('name');
    const [selectedGroups, setSelectedGroups] = useState([]);
    const [showCreateModal, setShowCreateModal] = useState(false);
    const [showEditModal, setShowEditModal] = useState(false);
    const [editingGroup, setEditingGroup] = useState(null);

    // Mock data for groups
    useEffect(() => {
        const mockGroups = [
            {
                id: 1,
                name: 'Computer Science Project Team',
                description: 'Advanced algorithms and data structures project',
                members: 5,
                maxMembers: 6,
                status: 'active',
                createdAt: '2024-01-15',
                leader: 'John Smith',
                project: 'Advanced Algorithms',
                rating: 4.5,
                tags: ['Computer Science', 'Algorithms', 'Research']
            },
            {
                id: 2,
                name: 'Web Development Squad',
                description: 'Full-stack web application development team',
                members: 4,
                maxMembers: 5,
                status: 'active',
                createdAt: '2024-01-20',
                leader: 'Alice Johnson',
                project: 'E-commerce Platform',
                rating: 4.8,
                tags: ['Web Development', 'React', 'Node.js']
            },
            {
                id: 3,
                name: 'Data Science Research Group',
                description: 'Machine learning and data analysis research',
                members: 3,
                maxMembers: 4,
                status: 'pending',
                createdAt: '2024-02-01',
                leader: 'Bob Wilson',
                project: 'Predictive Analytics',
                rating: 4.2,
                tags: ['Data Science', 'Machine Learning', 'Python']
            },
            {
                id: 4,
                name: 'Mobile App Development Team',
                description: 'iOS and Android application development',
                members: 6,
                maxMembers: 6,
                status: 'active',
                createdAt: '2024-01-10',
                leader: 'Carol Davis',
                project: 'Fitness Tracker App',
                rating: 4.6,
                tags: ['Mobile Development', 'iOS', 'Android']
            },
            {
                id: 5,
                name: 'AI Research Lab',
                description: 'Artificial intelligence and neural networks research',
                members: 2,
                maxMembers: 5,
                status: 'recruiting',
                createdAt: '2024-02-05',
                leader: 'David Brown',
                project: 'Neural Network Optimization',
                rating: 4.9,
                tags: ['AI', 'Neural Networks', 'Research']
            }
        ];
        setGroups(mockGroups);
    }, []);

    // Utility functions for groups
    const filteredGroups = groups.filter(group => {
        const matchesSearch = group.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                            group.description.toLowerCase().includes(searchTerm.toLowerCase()) ||
                            group.leader.toLowerCase().includes(searchTerm.toLowerCase());
        const matchesFilter = filterStatus === 'all' || group.status === filterStatus;
        return matchesSearch && matchesFilter;
    });

    const sortedGroups = [...filteredGroups].sort((a, b) => {
        switch (sortBy) {
            case 'name':
                return a.name.localeCompare(b.name);
            case 'members':
                return b.members - a.members;
            case 'rating':
                return b.rating - a.rating;
            case 'created':
                return new Date(b.createdAt) - new Date(a.createdAt);
            default:
                return 0;
        }
    });

    const handleGroupAction = (action, groupId) => {
        switch (action) {
            case 'edit':
                const group = groups.find(g => g.id === groupId);
                setEditingGroup(group);
                setShowEditModal(true);
                break;
            case 'delete':
                if (window.confirm('Are you sure you want to delete this group?')) {
                    setGroups(groups.filter(g => g.id !== groupId));
                }
                break;
            case 'view':
                // Navigate to group details
                console.log('View group:', groupId);
                break;
        }
    };

    const handleBulkAction = (action) => {
        switch (action) {
            case 'delete':
                if (window.confirm(`Are you sure you want to delete ${selectedGroups.length} groups?`)) {
                    setGroups(groups.filter(g => !selectedGroups.includes(g.id)));
                    setSelectedGroups([]);
                }
                break;
            case 'export':
                console.log('Export groups:', selectedGroups);
                break;
        }
    };

    useEffect(() => {
        // Authentication check
        const checkAuthentication = () => {
            const storedUser = localStorage.getItem('user');
            const token = localStorage.getItem('token');
            
            if (!storedUser || !token) {
                // Clear any partial auth data and redirect
                localStorage.removeItem('user');
                localStorage.removeItem('token');
                window.location.href = '/';
                return false;
            }
            
            try {
                const userData = JSON.parse(storedUser);
                // Validate user data structure
                if (!userData || !userData.email || !userData.role) {
                    throw new Error('Invalid user data');
                }
                setUser(userData);
                return true;
            } catch (error) {
                console.error('Error parsing or validating user data:', error);
                // Clear invalid data and redirect
                localStorage.removeItem('user');
                localStorage.removeItem('token');
                window.location.href = '/';
                return false;
            }
        };

        const isAuthenticated = checkAuthentication();
        if (isAuthenticated) {
            setLoading(false);
        }

        // Set up periodic authentication check
        const authCheckInterval = setInterval(() => {
            const token = localStorage.getItem('token');
            const storedUser = localStorage.getItem('user');
            if (!token || !storedUser) {
                clearInterval(authCheckInterval);
                window.location.href = '/';
            }
        }, 30000); // Check every 30 seconds

        return () => {
            clearInterval(authCheckInterval);
        };
    }, []);

    // Reset active section when user changes
    useEffect(() => {
        if (user) {
            setActiveSection('overview');
        }
    }, [user]);

    const handleLogout = () => {
        // Clear all authentication data
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        
        // Clear any additional sensitive data that might exist
        localStorage.removeItem('userPermissions');
        localStorage.removeItem('lastActivity');
        sessionStorage.clear(); // Clear session storage as well
        
        // Redirect to login page
        window.location.href = '/';
    };

    const getSectionTitle = (sectionId) => {
        const titles = {
            overview: 'Dashboard',
            groups: 'Groups',
            'all-groups': 'All Groups',
            'my-groups': 'My Groups',
            'create-group': 'Create Group',
            'group-requests': 'Group Requests',
            'group-analytics': 'Group Analytics',
            projects: 'Projects',
            users: 'User Management',
            analytics: 'Analytics',
            reports: 'Reports',
            messages: 'Messages',
            profile: 'Profile',
            settings: 'Settings'
        };
        return titles[sectionId] || 'Dashboard';
    };

    const hasPermission = (permission) => {
        if (!user) return false;
        const userRole = user.role;
        
        const permissions = {
            admin: ['users', 'groups', 'projects', 'analytics', 'settings', 'reports'],
            supervisor: ['groups', 'projects', 'analytics', 'reports'],
            student: ['projects', 'profile', 'messages']
        };
        
        return permissions[userRole]?.includes(permission) || false;
    };

    const renderSidebar = () => {
        const menuItems = [
            { id: 'overview', label: 'Dashboard', icon: BarChart3, permission: null },
            { 
                id: 'groups', 
                label: 'Groups', 
                icon: Users, 
                permission: 'groups',
                hasDropdown: true,
                submenu: [
                    { id: 'all-groups', label: 'All Groups', icon: UsersIcon },
                    { id: 'my-groups', label: 'My Groups', icon: UserCheck },
                    { id: 'create-group', label: 'Create Group', icon: Plus },
                    { id: 'group-requests', label: 'Group Requests', icon: Users2 },
                    { id: 'group-analytics', label: 'Group Analytics', icon: GitBranch }
                ]
            },
            { id: 'projects', label: 'Projects', icon: FolderOpen, permission: 'projects' },
            { id: 'users', label: 'User Management', icon: UserCog, permission: 'users' },
            { id: 'analytics', label: 'Analytics', icon: TrendingUp, permission: 'analytics' },
            { id: 'reports', label: 'Reports', icon: FileText, permission: 'reports' },
            { id: 'messages', label: 'Messages', icon: MessageSquare, permission: 'messages' },
            { id: 'profile', label: 'Profile', icon: User, permission: 'profile' },
            { id: 'settings', label: 'Settings', icon: Settings, permission: 'settings' }
        ];

        return React.createElement('div', {
            style: {
                width: sidebarOpen ? '256px' : '64px',
                backgroundColor: '#1f2937',
                height: '100vh',
                position: 'fixed',
                left: 0,
                top: 0,
                transition: 'width 0.3s ease',
                zIndex: 1000
            }
        },
            React.createElement('div', {
                style: {
                    padding: '1.5rem',
                    borderBottom: '1px solid #374151'
                }
            },
                React.createElement('h2', {
                    style: {
                        color: 'white',
                        fontSize: sidebarOpen ? '1.25rem' : '1rem',
                        fontWeight: 'bold',
                        textAlign: 'center'
                    }
                }, sidebarOpen ? 'GPTFMS' : 'GP')
            ),
            React.createElement('nav', {
                style: {
                    padding: '1rem 0'
                }
            },
                menuItems.map(item => {
                    if (item.permission && !hasPermission(item.permission)) {
                        return null;
                    }
                    
                    // Handle Groups menu with enhanced dropdown
                    if (item.id === 'groups' && item.hasDropdown) {
                        const isGroupsActive = activeSection === 'groups' || item.submenu.some(sub => activeSection === sub.id);
                        
                        return React.createElement('div', {
                            key: item.id,
                            style: {
                                width: '100%',
                                position: 'relative'
                            }
                        },
                            // Groups main menu item
                            React.createElement('button', {
                                onClick: () => {
                                    setGroupsDropdownOpen(!groupsDropdownOpen);
                                    // Close other dropdowns when opening groups
                                    if (profileDropdownOpen) {
                                        setProfileDropdownOpen(false);
                                    }
                                    if (item.id !== activeSection && !groupsDropdownOpen) {
                                        setIsTransitioning(true);
                                        setTimeout(() => {
                                            setActiveSection(item.id);
                                            setIsTransitioning(false);
                                        }, 50);
                                    }
                                },
                                style: {
                                    width: '100%',
                                    padding: '0.75rem 1.5rem',
                                    backgroundColor: isGroupsActive ? '#374151' : 'transparent',
                                    color: 'white',
                                    border: 'none',
                                    cursor: 'pointer',
                                    display: 'flex',
                                    alignItems: 'center',
                                    gap: sidebarOpen ? '0.75rem' : '0',
                                    justifyContent: sidebarOpen ? 'space-between' : 'center',
                                    fontSize: '0.875rem',
                                    transition: 'all 0.2s ease',
                                    borderRadius: '0.375rem',
                                    position: 'relative'
                                },
                                onMouseEnter: (e) => {
                                    if (!isGroupsActive) {
                                        e.target.style.backgroundColor = '#374151';
                                        e.target.style.transform = 'translateX(2px)';
                                    }
                                },
                                onMouseLeave: (e) => {
                                    if (!isGroupsActive) {
                                        e.target.style.backgroundColor = 'transparent';
                                        e.target.style.transform = 'translateX(0)';
                                    }
                                }
                            },
                                React.createElement('div', {
                                    style: {
                                        display: 'flex',
                                        alignItems: 'center',
                                        gap: sidebarOpen ? '0.75rem' : '0'
                                    }
                                },
                                    React.createElement(item.icon, {
                                        size: 20,
                                        color: 'white',
                                        style: {
                                            opacity: isGroupsActive ? 1 : 0.8
                                        }
                                    }),
                                    sidebarOpen && React.createElement('span', {
                                        style: {
                                            fontWeight: isGroupsActive ? '600' : '400'
                                        }
                                    }, item.label),
                                    // Active indicator for submenu items
                                    sidebarOpen && item.submenu.some(sub => activeSection === sub.id) && React.createElement('div', {
                                        style: {
                                            width: '3px',
                                            height: '3px',
                                            backgroundColor: '#10b981',
                                            borderRadius: '50%',
                                            marginLeft: '0.5rem'
                                        }
                                    })
                                ),
                                sidebarOpen && React.createElement(ChevronDown, {
                                    size: 16,
                                    color: 'white',
                                    style: {
                                        transform: groupsDropdownOpen ? 'rotate(180deg)' : 'rotate(0deg)',
                                        transition: 'transform 0.3s ease',
                                        opacity: 0.8
                                    }
                                })
                            ),
                            // Enhanced dropdown submenu
                            sidebarOpen && groupsDropdownOpen && React.createElement('div', {
                                style: {
                                    backgroundColor: '#111827',
                                    marginLeft: '0.5rem',
                                    marginRight: '0.5rem',
                                    borderRadius: '0.5rem',
                                    overflow: 'hidden',
                                    border: '1px solid #374151',
                                    boxShadow: '0 4px 6px rgba(0, 0, 0, 0.3)',
                                    animation: 'slideDown 0.2s ease-out',
                                    maxHeight: '300px',
                                    overflowY: 'auto'
                                }
                            },
                                item.submenu.map((subItem, index) => {
                                    const isSubActive = activeSection === subItem.id;
                                    
                                    return React.createElement('button', {
                                        key: subItem.id,
                                        onClick: () => {
                                            setIsTransitioning(true);
                                            setTimeout(() => {
                                                setActiveSection(subItem.id);
                                                setIsTransitioning(false);
                                                // Optionally close dropdown after selection
                                                setGroupsDropdownOpen(false);
                                            }, 50);
                                        },
                                        style: {
                                            width: '100%',
                                            padding: '0.625rem 1rem',
                                            backgroundColor: isSubActive ? '#374151' : 'transparent',
                                            color: 'white',
                                            border: 'none',
                                            cursor: 'pointer',
                                            display: 'flex',
                                            alignItems: 'center',
                                            gap: '0.75rem',
                                            justifyContent: 'flex-start',
                                            fontSize: '0.8rem',
                                            transition: 'all 0.2s ease',
                                            position: 'relative',
                                            borderBottom: index < item.submenu.length - 1 ? '1px solid #37415120' : 'none'
                                        },
                                        onMouseEnter: (e) => {
                                            if (!isSubActive) {
                                                e.target.style.backgroundColor = '#374151';
                                                e.target.style.paddingLeft = '1.25rem';
                                            }
                                        },
                                        onMouseLeave: (e) => {
                                            if (!isSubActive) {
                                                e.target.style.backgroundColor = 'transparent';
                                                e.target.style.paddingLeft = '1rem';
                                            }
                                        }
                                    },
                                        React.createElement(subItem.icon, {
                                            size: 16,
                                            color: isSubActive ? '#10b981' : 'white',
                                            style: {
                                                opacity: isSubActive ? 1 : 0.7
                                            }
                                        }),
                                        React.createElement('span', {
                                            style: {
                                                fontWeight: isSubActive ? '500' : '400',
                                                color: isSubActive ? '#10b981' : 'white'
                                            }
                                        }, subItem.label),
                                        // Active indicator
                                        isSubActive && React.createElement('div', {
                                            style: {
                                                position: 'absolute',
                                                right: '1rem',
                                                width: '6px',
                                                height: '6px',
                                                backgroundColor: '#10b981',
                                                borderRadius: '50%'
                                            }
                                        })
                                    );
                                })
                            )
                        );
                    }
                    
                    // Regular menu items
                    return React.createElement('button', {
                        key: item.id,
                        onClick: () => {
                            if (item.id !== activeSection) {
                                setIsTransitioning(true);
                                setTimeout(() => {
                                    setActiveSection(item.id);
                                    setIsTransitioning(false);
                                }, 50);
                            }
                        },
                        style: {
                            width: '100%',
                            padding: '0.75rem 1.5rem',
                            backgroundColor: activeSection === item.id ? '#374151' : 'transparent',
                            color: 'white',
                            border: 'none',
                            cursor: 'pointer',
                            display: 'flex',
                            alignItems: 'center',
                            gap: sidebarOpen ? '0.75rem' : '0',
                            justifyContent: sidebarOpen ? 'flex-start' : 'center',
                            fontSize: '0.875rem',
                            transition: 'background-color 0.2s ease'
                        },
                        onMouseEnter: (e) => {
                            if (activeSection !== item.id) {
                                e.target.style.backgroundColor = '#374151';
                            }
                        },
                        onMouseLeave: (e) => {
                            if (activeSection !== item.id) {
                                e.target.style.backgroundColor = 'transparent';
                            }
                        }
                    },
                        React.createElement(item.icon, {
                            size: 20,
                            color: 'white'
                        }),
                        sidebarOpen && React.createElement('span', null, item.label)
                    );
                })
            )
        );
    };

    const renderHeader = () => {
        return React.createElement('header', {
            style: {
                backgroundColor: 'white',
                borderBottom: '1px solid #e5e7eb',
                padding: '1rem 2rem',
                position: 'fixed',
                top: 0,
                left: sidebarOpen ? '256px' : '64px',
                right: 0,
                height: '64px',
                zIndex: 999,
                transition: 'left 0.3s ease',
                display: 'flex',
                justifyContent: 'space-between',
                alignItems: 'center'
            }
        },
            React.createElement('div', {
                style: {
                    display: 'flex',
                    alignItems: 'center',
                    gap: '1rem'
                }
            },
                React.createElement('button', {
                    onClick: () => setSidebarOpen(!sidebarOpen),
                    style: {
                        padding: '0.5rem',
                        backgroundColor: '#f3f4f6',
                        border: 'none',
                        borderRadius: '0.375rem',
                        cursor: 'pointer',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center'
                    }
                }, React.createElement(Menu, { size: 20 })),
                React.createElement('div', {
                    style: {
                        display: 'flex',
                        flexDirection: 'column',
                        gap: '0.25rem'
                    }
                },
                    React.createElement('h1', {
                        style: {
                            fontSize: '1.5rem',
                            fontWeight: 'bold',
                            color: '#1f2937',
                            margin: 0
                        }
                    }, 'Dashboard'),
                    React.createElement('div', {
                        style: {
                            display: 'flex',
                            alignItems: 'center',
                            gap: '0.5rem',
                            fontSize: '0.875rem',
                            color: '#6b7280'
                        }
                    },
                        React.createElement('button', {
                            onClick: () => {
                                setActiveSection('overview');
                            },
                            style: {
                                display: 'flex',
                                alignItems: 'center',
                                gap: '0.25rem',
                                padding: '0.25rem 0.5rem',
                                backgroundColor: 'transparent',
                                border: 'none',
                                borderRadius: '0.25rem',
                                cursor: 'pointer',
                                color: '#6b7280',
                                transition: 'background-color 0.2s ease',
                                fontSize: '0.875rem'
                            },
                            onMouseEnter: (e) => {
                                e.target.style.backgroundColor = '#f3f4f6';
                                e.target.style.color = '#374151';
                            },
                            onMouseLeave: (e) => {
                                e.target.style.backgroundColor = 'transparent';
                                e.target.style.color = '#6b7280';
                            }
                        },
                            React.createElement(Home, { size: 14 }),
                            React.createElement('span', null, 'Home')
                        ),
                        React.createElement('span', null, '/'),
                        React.createElement('span', {
                            style: {
                                color: '#374151',
                                fontWeight: '500',
                                padding: '0.25rem 0.5rem'
                            }
                        }, getSectionTitle(activeSection))
                    )
                )
            ),
            React.createElement('div', {
                style: {
                    position: 'relative'
                }
            },
                React.createElement('div', {
                    style: {
                        display: 'flex',
                        alignItems: 'center',
                        gap: '1rem'
                    },
                    onMouseEnter: () => setProfileDropdownOpen(true),
                    onMouseLeave: () => setProfileDropdownOpen(false)
                },
                    React.createElement('div', {
                        style: {
                            display: 'flex',
                            alignItems: 'center',
                            gap: '0.75rem',
                            padding: '0.5rem 1rem',
                            backgroundColor: '#f3f4f6',
                            borderRadius: '0.5rem',
                            cursor: 'pointer',
                            transition: 'background-color 0.2s ease'
                        }
                    },
                        React.createElement(UserCircle, { 
                            size: 32, 
                            color: '#6b7280' 
                        }),
                        React.createElement('div', {
                            style: {
                                textAlign: 'right'
                            }
                        },
                            React.createElement('div', {
                                style: {
                                    fontSize: '0.875rem',
                                    fontWeight: '500',
                                    color: '#1f2937'
                                }
                            }, `${user?.first_name || 'User'} ${user?.last_name || ''}`),
                            React.createElement('div', {
                                style: {
                                    fontSize: '0.75rem',
                                    color: '#6b7280',
                                    textTransform: 'capitalize'
                                }
                            }, user?.role || 'User')
                        ),
                        React.createElement(ChevronDown, { 
                            size: 16, 
                            color: '#6b7280' 
                        })
                    )
                ),
                profileDropdownOpen && React.createElement('div', {
                    style: {
                        position: 'absolute',
                        top: '100%',
                        right: 0,
                        marginTop: '0.5rem',
                        backgroundColor: 'white',
                        borderRadius: '0.5rem',
                        boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                        border: '1px solid #e5e7eb',
                        minWidth: '200px',
                        zIndex: 1000
                    },
                    onMouseEnter: () => setProfileDropdownOpen(true),
                    onMouseLeave: () => setProfileDropdownOpen(false)
                },
                    React.createElement('div', {
                        style: {
                            padding: '0.75rem 1rem',
                            borderBottom: '1px solid #e5e7eb'
                        }
                    },
                        React.createElement('div', {
                            style: {
                                fontSize: '0.875rem',
                                fontWeight: '500',
                                color: '#1f2937'
                            }
                        }, `${user?.first_name || 'User'} ${user?.last_name || ''}`),
                        React.createElement('div', {
                            style: {
                                fontSize: '0.75rem',
                                color: '#6b7280'
                            }
                        }, user?.email || 'user@example.com')
                    ),
                    React.createElement('div', null,
                        React.createElement('button', {
                            onClick: () => {
                                setActiveSection('profile');
                                setProfileDropdownOpen(false);
                            },
                            style: {
                                width: '100%',
                                padding: '0.75rem 1rem',
                                backgroundColor: 'transparent',
                                border: 'none',
                                cursor: 'pointer',
                                display: 'flex',
                                alignItems: 'center',
                                gap: '0.75rem',
                                fontSize: '0.875rem',
                                color: '#374151',
                                textAlign: 'left',
                                transition: 'backgroundColor 0.2s ease'
                            },
                            onMouseEnter: (e) => {
                                e.target.style.backgroundColor = '#f3f4f6';
                            },
                            onMouseLeave: (e) => {
                                e.target.style.backgroundColor = 'transparent';
                            }
                        },
                            React.createElement(User, { size: 16 }),
                            'My Profile'
                        ),
                        React.createElement('button', {
                            onClick: () => {
                                setActiveSection('settings');
                                setProfileDropdownOpen(false);
                            },
                            style: {
                                width: '100%',
                                padding: '0.75rem 1rem',
                                backgroundColor: 'transparent',
                                border: 'none',
                                cursor: 'pointer',
                                display: 'flex',
                                alignItems: 'center',
                                gap: '0.75rem',
                                fontSize: '0.875rem',
                                color: '#374151',
                                textAlign: 'left',
                                transition: 'backgroundColor 0.2s ease'
                            },
                            onMouseEnter: (e) => {
                                e.target.style.backgroundColor = '#f3f4f6';
                            },
                            onMouseLeave: (e) => {
                                e.target.style.backgroundColor = 'transparent';
                            }
                        },
                            React.createElement(Cog, { size: 16 }),
                            'Settings'
                        ),
                        React.createElement('button', {
                            style: {
                                width: '100%',
                                padding: '0.75rem 1rem',
                                backgroundColor: 'transparent',
                                border: 'none',
                                cursor: 'pointer',
                                display: 'flex',
                                alignItems: 'center',
                                gap: '0.75rem',
                                fontSize: '0.875rem',
                                color: '#374151',
                                textAlign: 'left',
                                transition: 'backgroundColor 0.2s ease'
                            },
                            onMouseEnter: (e) => {
                                e.target.style.backgroundColor = '#f3f4f6';
                            },
                            onMouseLeave: (e) => {
                                e.target.style.backgroundColor = 'transparent';
                            }
                        },
                            React.createElement(Bell, { size: 16 }),
                            'Notifications'
                        ),
                        React.createElement('button', {
                            style: {
                                width: '100%',
                                padding: '0.75rem 1rem',
                                backgroundColor: 'transparent',
                                border: 'none',
                                cursor: 'pointer',
                                display: 'flex',
                                alignItems: 'center',
                                gap: '0.75rem',
                                fontSize: '0.875rem',
                                color: '#374151',
                                textAlign: 'left',
                                transition: 'backgroundColor 0.2s ease'
                            },
                            onMouseEnter: (e) => {
                                e.target.style.backgroundColor = '#f3f4f6';
                            },
                            onMouseLeave: (e) => {
                                e.target.style.backgroundColor = 'transparent';
                            }
                        },
                            React.createElement(HelpCircle, { size: 16 }),
                            'Help & Support'
                        )
                    ),
                    React.createElement('div', {
                        style: {
                            borderTop: '1px solid #e5e7eb',
                            padding: '0.5rem'
                        }
                    },
                        React.createElement('button', {
                            onClick: handleLogout,
                            style: {
                                width: '100%',
                                padding: '0.75rem 1rem',
                                backgroundColor: 'transparent',
                                border: 'none',
                                cursor: 'pointer',
                                display: 'flex',
                                alignItems: 'center',
                                gap: '0.75rem',
                                fontSize: '0.875rem',
                                color: '#dc2626',
                                textAlign: 'left',
                                fontWeight: '500',
                                transition: 'backgroundColor 0.2s ease'
                            },
                            onMouseEnter: (e) => {
                                e.target.style.backgroundColor = '#fef2f2';
                            },
                            onMouseLeave: (e) => {
                                e.target.style.backgroundColor = 'transparent';
                            }
                        },
                            React.createElement(SignOut, { size: 16 }),
                            'Logout'
                        )
                    )
                )
            )
        );
    };

    const renderOverview = () => {
        // Enhanced statistics with more detailed data
        const stats = [
            { 
                title: 'Total Groups', 
                value: '12', 
                change: '+2', 
                changePercent: '+20%',
                color: '#3b82f6', 
                icon: Users,
                trend: 'up',
                details: '3 active, 2 pending, 7 completed'
            },
            { 
                title: 'Active Projects', 
                value: '8', 
                change: '+3', 
                changePercent: '+37.5%',
                color: '#10b981', 
                icon: FolderOpen,
                trend: 'up',
                details: '5 on track, 2 at risk, 1 delayed'
            },
            { 
                title: 'Total Students', 
                value: '45', 
                change: '+8', 
                changePercent: '+21.6%',
                color: '#f59e0b', 
                icon: Award,
                trend: 'up',
                details: '32 active, 8 inactive, 5 new'
            },
            { 
                title: 'Completion Rate', 
                value: '87%', 
                change: '+5%', 
                changePercent: '+6.1%',
                color: '#8b5cf6', 
                icon: Target,
                trend: 'up',
                details: '39 completed, 6 in progress'
            }
        ];

        // Advanced chart data
        const chartData = {
            weeklyActivity: [
                { day: 'Mon', groups: 4, projects: 2, students: 12 },
                { day: 'Tue', groups: 6, projects: 3, students: 18 },
                { day: 'Wed', groups: 5, projects: 4, students: 15 },
                { day: 'Thu', groups: 8, projects: 5, students: 22 },
                { day: 'Fri', groups: 7, projects: 4, students: 20 },
                { day: 'Sat', groups: 3, projects: 2, students: 8 },
                { day: 'Sun', groups: 2, projects: 1, students: 5 }
            ],
            projectProgress: [
                { name: 'E-commerce Platform', progress: 85, status: 'on-track' },
                { name: 'AI Research Project', progress: 62, status: 'at-risk' },
                { name: 'Mobile App Development', progress: 94, status: 'on-track' },
                { name: 'Data Analytics Dashboard', progress: 45, status: 'delayed' },
                { name: 'Machine Learning Model', progress: 78, status: 'on-track' }
            ],
            recentActivities: [
                { 
                    type: 'group_created', 
                    message: 'New group "AI Research Lab" created by David Brown',
                    time: '2 hours ago',
                    icon: UsersPlus,
                    color: '#10b981'
                },
                { 
                    type: 'project_milestone', 
                    message: 'E-commerce Platform reached beta testing phase',
                    time: '5 hours ago',
                    icon: Award,
                    color: '#f59e0b'
                },
                { 
                    type: 'member_joined', 
                    message: 'Sarah Johnson joined Web Development Squad',
                    time: '8 hours ago',
                    icon: UserCheck,
                    color: '#3b82f6'
                },
                { 
                    type: 'assignment_completed', 
                    message: 'Data Science Group submitted research paper',
                    time: '1 day ago',
                    icon: CheckCircle,
                    color: '#8b5cf6'
                }
            ]
        };

        return React.createElement('div', null,
            // Header with date range selector
            React.createElement('div', {
                style: {
                    display: 'flex',
                    justifyContent: 'space-between',
                    alignItems: 'center',
                    marginBottom: '2rem'
                }
            },
                React.createElement('div', null,
                    React.createElement('h2', {
                        style: {
                            fontSize: '1.875rem',
                            fontWeight: 'bold',
                            color: '#1f2937',
                            margin: '0 0 0.5rem 0'
                        }
                    }, 'Dashboard Overview'),
                    React.createElement('p', {
                        style: {
                            color: '#6b7280',
                            margin: 0
                        }
                    }, 'Real-time insights and analytics')
                ),
                React.createElement('div', {
                    style: {
                        display: 'flex',
                        gap: '0.5rem',
                        alignItems: 'center'
                    }
                },
                    React.createElement('select', {
                        style: {
                            padding: '0.5rem 1rem',
                            border: '1px solid #d1d5db',
                            borderRadius: '0.375rem',
                            backgroundColor: 'white',
                            color: '#374151'
                        }
                    },
                        React.createElement('option', null, 'Last 7 days'),
                        React.createElement('option', null, 'Last 30 days'),
                        React.createElement('option', null, 'Last 3 months'),
                        React.createElement('option', null, 'Last year')
                    ),
                    React.createElement('button', {
                        style: {
                            padding: '0.5rem 1rem',
                            backgroundColor: '#3b82f6',
                            color: 'white',
                            border: 'none',
                            borderRadius: '0.375rem',
                            cursor: 'pointer',
                            display: 'flex',
                            alignItems: 'center',
                            gap: '0.5rem'
                        }
                    },
                        React.createElement(Download, { size: 16 }),
                        'Export Report'
                    )
                )
            ),

            // Enhanced Statistics Cards
            React.createElement('div', {
                style: {
                    display: 'grid',
                    gridTemplateColumns: 'repeat(auto-fit, minmax(280px, 1fr))',
                    gap: '1.5rem',
                    marginBottom: '2rem'
                }
            },
                stats.map(stat => React.createElement('div', {
                    key: stat.title,
                    style: {
                        backgroundColor: 'white',
                        padding: '1.5rem',
                        borderRadius: '1rem',
                        boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
                        borderLeft: `4px solid ${stat.color}`,
                        position: 'relative',
                        overflow: 'hidden',
                        transition: 'transform 0.2s ease, box-shadow 0.2s ease'
                    }
                },
                    // Background decoration
                    React.createElement('div', {
                        style: {
                            position: 'absolute',
                            top: '-20px',
                            right: '-20px',
                            width: '100px',
                            height: '100px',
                            borderRadius: '50%',
                            backgroundColor: `${stat.color}10`,
                            zIndex: 0
                        }
                    }),
                    React.createElement('div', {
                        style: {
                            position: 'relative',
                            zIndex: 1
                        }
                    },
                        React.createElement('div', {
                            style: {
                                display: 'flex',
                                justifyContent: 'space-between',
                                alignItems: 'flex-start',
                                marginBottom: '1rem'
                            }
                        },
                            React.createElement('div', null,
                                React.createElement('h3', {
                                    style: {
                                        fontSize: '0.875rem',
                                        color: '#6b7280',
                                        fontWeight: '500',
                                        margin: '0 0 0.5rem 0',
                                        textTransform: 'uppercase',
                                        letterSpacing: '0.05em'
                                    }
                                }, stat.title),
                                React.createElement('div', {
                                    style: {
                                        fontSize: '2.5rem',
                                        fontWeight: 'bold',
                                        color: '#1f2937',
                                        lineHeight: 1
                                    }
                                }, stat.value),
                                React.createElement('div', {
                                    style: {
                                        fontSize: '0.75rem',
                                        color: '#6b7280',
                                        marginTop: '0.25rem'
                                    }
                                }, stat.details)
                            ),
                            React.createElement('div', {
                                style: {
                                    display: 'flex',
                                    flexDirection: 'column',
                                    alignItems: 'flex-end',
                                    gap: '0.5rem'
                                }
                            },
                                React.createElement(stat.icon, {
                                    size: 32,
                                    color: stat.color
                                }),
                                React.createElement('div', {
                                    style: {
                                        display: 'flex',
                                        alignItems: 'center',
                                        gap: '0.25rem',
                                        fontSize: '0.75rem',
                                        fontWeight: '500',
                                        color: stat.trend === 'up' ? '#10b981' : '#ef4444'
                                    }
                                },
                                    stat.trend === 'up' ? 
                                        React.createElement(TrendingUp, { size: 12 }) : 
                                        React.createElement(TrendingUp, { size: 12, style: { transform: 'rotate(180deg)' } }),
                                    stat.changePercent
                                )
                            )
                        ),
                        React.createElement('div', {
                            style: {
                                display: 'flex',
                                alignItems: 'center',
                                justifyContent: 'space-between',
                                paddingTop: '0.75rem',
                                borderTop: '1px solid #f3f4f6'
                            }
                        },
                            React.createElement('span', {
                                style: {
                                    fontSize: '0.75rem',
                                    color: stat.trend === 'up' ? '#10b981' : '#ef4444',
                                    fontWeight: '500'
                                }
                            }, `${stat.trend === 'up' ? '+' : ''}${stat.change} this month`),
                            React.createElement('button', {
                                style: {
                                    fontSize: '0.75rem',
                                    color: '#3b82f6',
                                    background: 'none',
                                    border: 'none',
                                    cursor: 'pointer',
                                    textDecoration: 'underline'
                                }
                            }, 'View details')
                        )
                    )
                ))
            ),

            // Charts and Analytics Section
            React.createElement('div', {
                style: {
                    display: 'grid',
                    gridTemplateColumns: '2fr 1fr',
                    gap: '1.5rem',
                    marginBottom: '2rem'
                }
            },
                React.createElement('div', {
                    style: {
                        backgroundColor: 'white',
                        padding: '1.5rem',
                        borderRadius: '0.75rem',
                        boxShadow: '0 1px 3px 0 rgba(0, 0, 0, 0.1)'
                    }
                },
                    React.createElement('h3', {
                        style: {
                            fontSize: '1.125rem',
                            fontWeight: '600',
                            color: '#1f2937',
                            marginBottom: '1rem'
                        }
                    }, 'Recent Activity'),
                    React.createElement('div', {
                        style: {
                            space: '1rem'
                        }
                    },
                        React.createElement('div', {
                            style: {
                                padding: '1rem',
                                borderLeft: '4px solid #3b82f6',
                                backgroundColor: '#f8fafc',
                                marginBottom: '1rem'
                            }
                        },
                            React.createElement('div', {
                                style: {
                                    display: 'flex',
                                    justifyContent: 'space-between',
                                    alignItems: 'flex-start'
                                }
                            },
                                React.createElement('div', null,
                                    React.createElement('p', {
                                        style: {
                                            color: '#1f2937',
                                            fontWeight: '500',
                                            margin: '0 0 0.25rem 0'
                                        }
                                    }, 'Group Alpha Team completed project setup'),
                                    React.createElement('p', {
                                        style: {
                                            color: '#6b7280',
                                            fontSize: '0.875rem',
                                            margin: 0
                                        }
                                    }, 'Team members: 4')
                                ),
                                React.createElement('span', {
                                    style: {
                                        fontSize: '0.75rem',
                                        color: '#6b7280'
                                    }
                                }, '2 hours ago')
                            )
                        ),
                        React.createElement('div', {
                            style: {
                                padding: '1rem',
                                borderLeft: '4px solid #10b981',
                                backgroundColor: '#f8fafc',
                                marginBottom: '1rem'
                            }
                        },
                            React.createElement('div', {
                                style: {
                                    display: 'flex',
                                    justifyContent: 'space-between',
                                    alignItems: 'flex-start'
                                }
                            },
                                React.createElement('div', null,
                                    React.createElement('p', {
                                        style: {
                                            color: '#1f2937',
                                            fontWeight: '500',
                                            margin: '0 0 0.25rem 0'
                                        }
                                    }, 'New student registration: Bob Taylor'),
                                    React.createElement('p', {
                                        style: {
                                            color: '#6b7280',
                                            fontSize: '0.875rem',
                                            margin: 0
                                        }
                                    }, 'Computer Science, Semester 3')
                                ),
                                React.createElement('span', {
                                    style: {
                                        fontSize: '0.75rem',
                                        color: '#6b7280'
                                    }
                                }, '5 hours ago')
                            )
                        )
                    )
                ),
                React.createElement('div', {
                    style: {
                        backgroundColor: 'white',
                        padding: '1.5rem',
                        borderRadius: '0.75rem',
                        boxShadow: '0 1px 3px 0 rgba(0, 0, 0, 0.1)'
                    }
                },
                    React.createElement('h3', {
                        style: {
                            fontSize: '1.125rem',
                            fontWeight: '600',
                            color: '#1f2937',
                            marginBottom: '1rem'
                        }
                    }, 'Quick Actions'),
                    React.createElement('div', {
                        style: {
                            display: 'flex',
                            flexDirection: 'column',
                            gap: '0.75rem'
                        }
                    },
                        React.createElement('button', {
                            style: {
                                padding: '0.75rem',
                                backgroundColor: '#3b82f6',
                                color: 'white',
                                border: 'none',
                                borderRadius: '0.5rem',
                                cursor: 'pointer',
                                fontSize: '0.875rem',
                                fontWeight: '500',
                                display: 'flex',
                                alignItems: 'center',
                                gap: '0.5rem'
                            }
                        }, 
                            React.createElement(Plus, { size: 16 }),
                            'Create New Group'
                        ),
                        React.createElement('button', {
                            style: {
                                padding: '0.75rem',
                                backgroundColor: '#10b981',
                                color: 'white',
                                border: 'none',
                                borderRadius: '0.5rem',
                                cursor: 'pointer',
                                fontSize: '0.875rem',
                                fontWeight: '500',
                                display: 'flex',
                                alignItems: 'center',
                                gap: '0.5rem'
                            }
                        }, 
                            React.createElement(Send, { size: 16 }),
                            'Assign Project'
                        ),
                        React.createElement('button', {
                            style: {
                                padding: '0.75rem',
                                backgroundColor: '#f59e0b',
                                color: 'white',
                                border: 'none',
                                borderRadius: '0.5rem',
                                cursor: 'pointer',
                                fontSize: '0.875rem',
                                fontWeight: '500',
                                display: 'flex',
                                alignItems: 'center',
                                gap: '0.5rem'
                            }
                        }, 
                            React.createElement(Download, { size: 16 }),
                            'Generate Report'
                        )
                    )
                )
            )
        );
    };

    const renderContent = () => {
        const sections = {
            overview: renderOverview(),
            groups: React.createElement('div', {
                style: {
                    padding: '2rem',
                    backgroundColor: 'white',
                    borderRadius: '0.75rem',
                    boxShadow: '0 1px 3px 0 rgba(0, 0, 0, 0.1)'
                }
            },
                React.createElement('h2', {
                    style: {
                        fontSize: '1.5rem',
                        fontWeight: 'bold',
                        color: '#1f2937',
                        marginBottom: '1rem'
                    }
                }, 'Groups Management'),
                React.createElement('p', {
                    style: {
                        color: '#6b7280'
                    }
                }, 'Groups management interface coming soon...')
            ),
            'all-groups': React.createElement(AllGroups),
            'my-groups': React.createElement(MyGroups),
            'create-group': React.createElement(CreateGroup),
            'group-requests': React.createElement(GroupRequests),
            'group-analytics': React.createElement(GroupAnalytics),
            projects: React.createElement(Projects),
            users: React.createElement(Users),
            analytics: React.createElement(Analytics),
            reports: React.createElement(Reports),
            messages: React.createElement(Messages),
            profile: React.createElement(Profile),
            settings: React.createElement(Settings)
        };

        return sections[activeSection] || sections.overview;
    };

    if (loading) {
        return React.createElement('div', {
            style: {
                minHeight: '100vh',
                backgroundColor: '#f9fafb',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center'
            }
        },
            React.createElement('div', {
                style: {
                    textAlign: 'center'
                }
            },
                React.createElement('div', {
                    style: {
                        width: '40px',
                        height: '40px',
                        border: '4px solid #e5e7eb',
                        borderTop: '4px solid #3b82f6',
                        borderRadius: '50%',
                        animation: 'spin 1s linear infinite'
                    }
                }),
                React.createElement('p', {
                    style: {
                        marginTop: '1rem',
                        color: '#6b7280'
                    }
                }, 'Loading...')
            )
        );
    }

    return React.createElement('div', {
        style: {
            minHeight: '100vh',
            backgroundColor: '#f9fafb'
        }
    },
        // Sidebar
        React.createElement('div', {
            style: {
                width: sidebarOpen ? '250px' : '60px',
                backgroundColor: 'white',
                borderRight: '1px solid #e5e7eb',
                transition: 'width 0.3s ease',
                position: 'relative'
            }
        },
            // Sidebar content would go here
            React.createElement('div', {
                style: {
                    padding: '1rem'
                }
            },
                React.createElement('h3', {
                    style: {
                        fontSize: '1.125rem',
                        fontWeight: '600',
                        color: '#1f2937',
                        marginBottom: '1rem'
                    }
                }, 'Dashboard Sidebar')
            )
        ),
        // Main content
        React.createElement('div', {
            style: {
                flex: 1,
                padding: '1rem'
            }
        },
            renderContent()
        )
    );
};

const Login = () => {
    const [formData, setFormData] = useState({
        email: '',
        password: ''
    });
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');
    const [fadeIn, setFadeIn] = useState(false);
    const [showRegister, setShowRegister] = useState(false);

    useEffect(() => {
        setFadeIn(true);
    }, []);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError('');

        try {
            // Simple direct login check against our seeded users
            const testUsers = [
                { email: 'admin@gptfms.com', password: 'password', name: 'System Administrator', role: 'admin' },
                { email: 'john.smith@university.edu', password: 'password', name: 'John Smith', role: 'supervisor' },
                { email: 'alice.wilson@student.edu', password: 'password', name: 'Alice Wilson', role: 'student' }
            ];

            const user = testUsers.find(u => 
                u.email === formData.email && u.password === formData.password
            );

            if (user) {
                // Simulate successful login with enhanced security
                const token = 'mock-jwt-token-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
                const userData = {
                    first_name: user.name.split(' ')[0],
                    last_name: user.name.split(' ')[1],
                    email: user.email,
                    role: user.role,
                    loginTime: new Date().toISOString(),
                    sessionId: Math.random().toString(36).substr(2, 9)
                };
                
                // Store authentication data with security measures
                localStorage.setItem('user', JSON.stringify(userData));
                localStorage.setItem('token', token);
                localStorage.setItem('lastActivity', new Date().toISOString());
                
                // Store session info for additional security
                sessionStorage.setItem('authSession', token);
                sessionStorage.setItem('loginTime', userData.loginTime);
                sessionStorage.setItem('sessionId', userData.sessionId);
                
                // Redirect to dashboard
                window.location.href = '/dashboard';
            } else {
                setError('Invalid email or password');
            }
        } catch (err) {
            setError('Login error. Please try again.');
        } finally {
            setLoading(false);
        }
    };

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const Register = () => {
        const [registerData, setRegisterData] = useState({
            name: '',
            email: '',
            password: '',
            confirmPassword: '',
            role: 'student'
        });
        const [registerLoading, setRegisterLoading] = useState(false);
        const [registerError, setRegisterError] = useState('');
        const [showPassword, setShowPassword] = useState(false);
        const [showConfirmPassword, setShowConfirmPassword] = useState(false);

        const handleRegisterChange = (e) => {
            setRegisterData({
                ...registerData,
                [e.target.name]: e.target.value
            });
        };

        const handleRegisterSubmit = async (e) => {
            e.preventDefault();
            setRegisterLoading(true);
            setRegisterError('');

            // Basic validation
            if (!registerData.name || !registerData.email || !registerData.password || !registerData.confirmPassword) {
                setRegisterError('All fields are required');
                setRegisterLoading(false);
                return;
            }

            if (registerData.password !== registerData.confirmPassword) {
                setRegisterError('Passwords do not match');
                setRegisterLoading(false);
                return;
            }

            if (registerData.password.length < 6) {
                setRegisterError('Password must be at least 6 characters');
                setRegisterLoading(false);
                return;
            }

            try {
                // Simulate registration (in real app, this would call API)
                await new Promise(resolve => setTimeout(resolve, 1500));
                
                // Show success message and redirect to login
                alert('Registration successful! Please login with your credentials.');
                setShowRegister(false);
                setRegisterLoading(false);
            } catch (error) {
                setRegisterError('Registration failed. Please try again.');
                setRegisterLoading(false);
            }
        };

        return React.createElement('div', {
            style: {
                width: '100%',
                maxWidth: '448px',
                backgroundColor: 'white',
                padding: '2rem',
                borderRadius: '0.5rem',
                boxShadow: '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)',
                opacity: fadeIn ? 1 : 0,
                transform: fadeIn ? 'translateY(0)' : 'translateY(20px)',
                transition: 'opacity 0.6s ease-in-out, transform 0.6s ease-in-out'
            }
        },
            React.createElement('div', {
                style: {
                    display: 'flex',
                    alignItems: 'center',
                    gap: '0.75rem',
                    marginBottom: '2rem'
                }
            },
                React.createElement('button', {
                    onClick: () => setShowRegister(false),
                    style: {
                        display: 'flex',
                        alignItems: 'center',
                        gap: '0.5rem',
                        padding: '0.5rem',
                        backgroundColor: 'transparent',
                        border: 'none',
                        cursor: 'pointer',
                        color: '#6b7280',
                        transition: 'color 0.2s ease'
                    },
                    onMouseEnter: (e) => {
                        e.target.style.color = '#374151';
                    },
                    onMouseLeave: (e) => {
                        e.target.style.color = '#6b7280';
                    }
                },
                    React.createElement(ArrowLeft, { size: 20 }),
                    'Back to Login'
                ),
                React.createElement('div', {
                    style: {
                        flex: 1,
                        textAlign: 'center'
                    }
                },
                    React.createElement('h2', {
                        style: {
                            fontSize: '1.5rem',
                            fontWeight: 'bold',
                            color: '#1f2937',
                            margin: 0
                        }
                    }, 'Create Account')
                )
            ),
            React.createElement('form', { 
                onSubmit: handleRegisterSubmit,
                style: { gap: '1.5rem' } 
            },
                React.createElement('div', { style: { marginBottom: '1rem' } },
                    React.createElement('label', {
                        style: {
                            display: 'block',
                            fontSize: '0.875rem',
                            fontWeight: '500',
                            color: '#374151',
                            marginBottom: '0.25rem'
                        }
                    }, 'Full Name'),
                    React.createElement('div', {
                        style: {
                            position: 'relative'
                        }
                    },
                        React.createElement(UserIcon, {
                            size: 18,
                            color: '#9ca3af',
                            style: {
                                position: 'absolute',
                                left: '0.75rem',
                                top: '50%',
                                transform: 'translateY(-50%)',
                                pointerEvents: 'none'
                            }
                        }),
                        React.createElement('input', {
                            type: 'text',
                            name: 'name',
                            placeholder: 'Full Name',
                            value: registerData.name,
                            onChange: handleRegisterChange,
                            required: true,
                            style: {
                                display: 'block',
                                width: '100%',
                                padding: '0.5rem 0.75rem 0.5rem 2.5rem',
                                border: '1px solid #d1d5db',
                                borderRadius: '0.375rem',
                                fontSize: '0.875rem',
                                paddingLeft: '2.5rem'
                            }
                        })
                    )
                ),
                React.createElement('div', { style: { marginBottom: '1rem' } },
                    React.createElement('label', {
                        style: {
                            display: 'block',
                            fontSize: '0.875rem',
                            fontWeight: '500',
                            color: '#374151',
                            marginBottom: '0.25rem'
                        }
                    }, 'Email Address'),
                    React.createElement('div', {
                        style: {
                            position: 'relative'
                        }
                    },
                        React.createElement(Mail, {
                            size: 18,
                            color: '#9ca3af',
                            style: {
                                position: 'absolute',
                                left: '0.75rem',
                                top: '50%',
                                transform: 'translateY(-50%)',
                                pointerEvents: 'none'
                            }
                        }),
                        React.createElement('input', {
                            type: 'email',
                            name: 'email',
                            placeholder: 'Email Address',
                            value: registerData.email,
                            onChange: handleRegisterChange,
                            required: true,
                            style: {
                                display: 'block',
                                width: '100%',
                                padding: '0.5rem 0.75rem 0.5rem 2.5rem',
                                border: '1px solid #d1d5db',
                                borderRadius: '0.375rem',
                                fontSize: '0.875rem',
                                paddingLeft: '2.5rem'
                            }
                        })
                    )
                ),
                React.createElement('div', { style: { marginBottom: '1rem' } },
                    React.createElement('label', {
                        style: {
                            display: 'block',
                            fontSize: '0.875rem',
                            fontWeight: '500',
                            color: '#374151',
                            marginBottom: '0.25rem'
                        }
                    }, 'Password'),
                    React.createElement('div', {
                        style: {
                            position: 'relative'
                        }
                    },
                        React.createElement(Lock, {
                            size: 18,
                            color: '#9ca3af',
                            style: {
                                position: 'absolute',
                                left: '0.75rem',
                                top: '50%',
                                transform: 'translateY(-50%)',
                                pointerEvents: 'none'
                            }
                        }),
                        React.createElement('input', {
                            type: showPassword ? 'text' : 'password',
                            name: 'password',
                            placeholder: 'Password',
                            value: registerData.password,
                            onChange: handleRegisterChange,
                            required: true,
                            style: {
                                display: 'block',
                                width: '100%',
                                padding: '0.5rem 0.75rem 0.5rem 2.5rem',
                                border: '1px solid #d1d5db',
                                borderRadius: '0.375rem',
                                fontSize: '0.875rem',
                                paddingLeft: '2.5rem',
                                paddingRight: '2.5rem'
                            }
                        }),
                        React.createElement('button', {
                            type: 'button',
                            onClick: () => setShowPassword(!showPassword),
                            style: {
                                position: 'absolute',
                                right: '0.75rem',
                                top: '50%',
                                transform: 'translateY(-50%)',
                                backgroundColor: 'transparent',
                                border: 'none',
                                cursor: 'pointer',
                                padding: '0.25rem',
                                color: '#9ca3af'
                            }
                        },
                            showPassword ? React.createElement(EyeOff, { size: 18 }) : React.createElement(Eye, { size: 18 })
                        )
                    )
                ),
                React.createElement('div', { style: { marginBottom: '1rem' } },
                    React.createElement('label', {
                        style: {
                            display: 'block',
                            fontSize: '0.875rem',
                            fontWeight: '500',
                            color: '#374151',
                            marginBottom: '0.25rem'
                        }
                    }, 'Confirm Password'),
                    React.createElement('div', {
                        style: {
                            position: 'relative'
                        }
                    },
                        React.createElement(Lock, {
                            size: 18,
                            color: '#9ca3af',
                            style: {
                                position: 'absolute',
                                left: '0.75rem',
                                top: '50%',
                                transform: 'translateY(-50%)',
                                pointerEvents: 'none'
                            }
                        }),
                        React.createElement('input', {
                            type: showConfirmPassword ? 'text' : 'password',
                            name: 'confirmPassword',
                            placeholder: 'Confirm Password',
                            value: registerData.confirmPassword,
                            onChange: handleRegisterChange,
                            required: true,
                            style: {
                                display: 'block',
                                width: '100%',
                                padding: '0.5rem 0.75rem 0.5rem 2.5rem',
                                border: '1px solid #d1d5db',
                                borderRadius: '0.375rem',
                                fontSize: '0.875rem',
                                paddingLeft: '2.5rem',
                                paddingRight: '2.5rem'
                            }
                        }),
                        React.createElement('button', {
                            type: 'button',
                            onClick: () => setShowConfirmPassword(!showConfirmPassword),
                            style: {
                                position: 'absolute',
                                right: '0.75rem',
                                top: '50%',
                                transform: 'translateY(-50%)',
                                backgroundColor: 'transparent',
                                border: 'none',
                                cursor: 'pointer',
                                padding: '0.25rem',
                                color: '#9ca3af'
                            }
                        },
                            showConfirmPassword ? React.createElement(EyeOff, { size: 18 }) : React.createElement(Eye, { size: 18 })
                        )
                    )
                ),
                React.createElement('div', { style: { marginBottom: '1rem' } },
                    React.createElement('label', {
                        style: {
                            display: 'block',
                            fontSize: '0.875rem',
                            fontWeight: '500',
                            color: '#374151',
                            marginBottom: '0.25rem'
                        }
                    }, 'Role'),
                    React.createElement('select', {
                        name: 'role',
                        value: registerData.role,
                        onChange: handleRegisterChange,
                        style: {
                            display: 'block',
                            width: '100%',
                            padding: '0.5rem 0.75rem',
                            border: '1px solid #d1d5db',
                            borderRadius: '0.375rem',
                            fontSize: '0.875rem',
                            backgroundColor: 'white'
                        }
                    },
                        React.createElement('option', { value: 'student' }, 'Student'),
                        React.createElement('option', { value: 'supervisor' }, 'Supervisor')
                    )
                ),
                registerError && React.createElement('div', {
                    style: {
                        marginBottom: '1rem',
                        padding: '0.5rem',
                        backgroundColor: '#fef2f2',
                        border: '1px solid #fecaca',
                        borderRadius: '0.375rem',
                        color: '#dc2626',
                        fontSize: '0.875rem',
                        opacity: fadeIn ? 1 : 0,
                        transform: fadeIn ? 'translateY(0)' : 'translateY(-10px)',
                        transition: 'opacity 0.3s ease-in-out, transform 0.3s ease-in-out'
                    }
                }, registerError),
                React.createElement('button', {
                    type: 'submit',
                    disabled: registerLoading,
                    style: {
                        width: '100%',
                        padding: '0.5rem 1rem',
                        backgroundColor: registerLoading ? '#9ca3af' : '#2563eb',
                        color: 'white',
                        fontSize: '0.875rem',
                        fontWeight: '500',
                        borderRadius: '0.375rem',
                        border: 'none',
                        cursor: registerLoading ? 'not-allowed' : 'pointer',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                        gap: '0.5rem'
                    }
                }, 
                    React.createElement(UserPlus, { size: 16 }),
                    registerLoading ? 'Creating Account...' : 'Create Account'
                )
            )
        );
    };

    return React.createElement('div', {
        style: {
            minHeight: '100vh',
            backgroundColor: '#f9fafb'
        }
    },
        // Liquid Glass Header
        React.createElement('header', {
            style: {
                position: 'fixed',
                top: 0,
                left: 0,
                right: 0,
                zIndex: 1000,
                backgroundColor: 'rgba(255, 255, 255, 0.8)',
                backdropFilter: 'blur(20px)',
                WebkitBackdropFilter: 'blur(20px)',
                borderBottom: '1px solid rgba(255, 255, 255, 0.2)',
                boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                opacity: fadeIn ? 1 : 0,
                transform: fadeIn ? 'translateY(0)' : 'translateY(-100%)',
                transition: 'opacity 0.6s ease-in-out, transform 0.6s ease-in-out'
            }
        },
            React.createElement('div', {
                style: {
                    display: 'flex',
                    justifyContent: 'space-between',
                    alignItems: 'center',
                    padding: '1rem 2rem',
                    maxWidth: '1400px',
                    margin: '0 auto'
                }
            },
                // System Title on Left
                React.createElement('div', {
                    style: {
                        display: 'flex',
                        alignItems: 'center',
                        gap: '0.75rem'
                    }
                },
                    React.createElement(Shield, {
                        size: 28,
                        color: '#2563eb'
                    }),
                    React.createElement('div', {
                        style: {
                            display: 'flex',
                            flexDirection: 'column'
                        }
                    },
                        React.createElement('h1', {
                            style: {
                                fontSize: '1.5rem',
                                fontWeight: 'bold',
                                color: '#1f2937',
                                margin: 0,
                                lineHeight: 1.2
                            }
                        }, 'GPTFMS'),
                        React.createElement('p', {
                            style: {
                                fontSize: '0.75rem',
                                color: '#6b7280',
                                margin: 0,
                                lineHeight: 1.2
                            }
                        }, 'Group Project Team Formation and Management System')
                    )
                ),
                // Register/Login Button on Right
                React.createElement('button', {
                    onClick: () => {
                        if (showRegister) {
                            setShowRegister(false);
                        } else {
                            setShowRegister(true);
                        }
                    },
                    style: {
                        display: 'flex',
                        alignItems: 'center',
                        gap: '0.5rem',
                        padding: '0.5rem 1rem',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        color: '#2563eb',
                        border: '1px solid rgba(37, 99, 235, 0.2)',
                        borderRadius: '0.5rem',
                        fontSize: '0.875rem',
                        fontWeight: '500',
                        cursor: 'pointer',
                        transition: 'all 0.2s ease',
                        backdropFilter: 'blur(10px)',
                        WebkitBackdropFilter: 'blur(10px)'
                    },
                    onMouseEnter: (e) => {
                        e.target.style.backgroundColor = 'rgba(37, 99, 235, 0.15)';
                        e.target.style.borderColor = 'rgba(37, 99, 235, 0.3)';
                        e.target.style.transform = 'translateY(-1px)';
                    },
                    onMouseLeave: (e) => {
                        e.target.style.backgroundColor = 'rgba(37, 99, 235, 0.1)';
                        e.target.style.borderColor = 'rgba(37, 99, 235, 0.2)';
                        e.target.style.transform = 'translateY(0)';
                    }
                },
                    showRegister ? React.createElement(SignIn, { size: 16 }) : React.createElement(UserPlus, { size: 16 }),
                    showRegister ? 'Login' : 'Register'
                )
            )
        ),
        // Form Container - Centered on page (Login or Register)
        React.createElement('div', {
            style: {
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                minHeight: '100vh',
                padding: '20px',
                paddingTop: '120px' // Account for fixed header
            }
        },
            showRegister ? React.createElement(Register) : 
            React.createElement('div', {
                style: {
                    width: '100%',
                    maxWidth: '448px',
                    backgroundColor: 'white',
                    padding: '2rem',
                    borderRadius: '0.5rem',
                    boxShadow: '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)',
                    opacity: fadeIn ? 1 : 0,
                    transform: fadeIn ? 'translateY(0)' : 'translateY(20px)',
                    transition: 'opacity 0.6s ease-in-out, transform 0.6s ease-in-out'
                }
            },
                React.createElement('div', {
                    style: {
                        textAlign: 'center',
                        marginBottom: '2rem'
                    }
                },
                    React.createElement('div', {
                        style: {
                            display: 'flex',
                            justifyContent: 'center',
                            alignItems: 'center',
                            gap: '0.75rem',
                            marginBottom: '0.5rem'
                        }
                    },
                        React.createElement(Shield, {
                            size: 32,
                            color: '#2563eb'
                        }),
                        React.createElement('h2', {
                            style: {
                                fontSize: '1.5rem',
                                fontWeight: 'bold',
                                color: '#1f2937',
                                margin: 0
                            }
                        }, 'Sign in to GPTFMS')
                    ),
                    React.createElement('p', {
                        style: {
                            fontSize: '0.875rem',
                            color: '#6b7280',
                            margin: 0
                        }
                    }, 'Group Project Team Formation and Management System')
                ),
                React.createElement('form', { 
                    onSubmit: handleSubmit,
                    style: { gap: '1.5rem' } 
                },
                React.createElement('div', { style: { marginBottom: '1rem' } },
                    React.createElement('label', {
                        style: {
                            display: 'block',
                            fontSize: '0.875rem',
                            fontWeight: '500',
                            color: '#374151',
                            marginBottom: '0.25rem'
                        }
                    }, 'Email Address'),
                    React.createElement('div', {
                        style: {
                            position: 'relative'
                        }
                    },
                        React.createElement(Mail, {
                            size: 18,
                            color: '#9ca3af',
                            style: {
                                position: 'absolute',
                                left: '0.75rem',
                                top: '50%',
                                transform: 'translateY(-50%)',
                                pointerEvents: 'none'
                            }
                        }),
                        React.createElement('input', {
                            type: 'email',
                            name: 'email',
                            placeholder: 'Email Address',
                            value: formData.email,
                            onChange: handleChange,
                            required: true,
                            style: {
                                display: 'block',
                                width: '100%',
                                padding: '0.5rem 0.75rem 0.5rem 2.5rem',
                                border: '1px solid #d1d5db',
                                borderRadius: '0.375rem',
                                fontSize: '0.875rem',
                                paddingLeft: '2.5rem'
                            }
                        })
                    )
                ),
                React.createElement('div', { style: { marginBottom: '1.5rem' } },
                    React.createElement('label', {
                        style: {
                            display: 'block',
                            fontSize: '0.875rem',
                            fontWeight: '500',
                            color: '#374151',
                            marginBottom: '0.25rem'
                        }
                    }, 'Password'),
                    React.createElement('div', {
                        style: {
                            position: 'relative'
                        }
                    },
                        React.createElement(Lock, {
                            size: 18,
                            color: '#9ca3af',
                            style: {
                                position: 'absolute',
                                left: '0.75rem',
                                top: '50%',
                                transform: 'translateY(-50%)',
                                pointerEvents: 'none'
                            }
                        }),
                        React.createElement('input', {
                            type: 'password',
                            name: 'password',
                            placeholder: 'Password',
                            value: formData.password,
                            onChange: handleChange,
                            required: true,
                            style: {
                                display: 'block',
                                width: '100%',
                                padding: '0.5rem 0.75rem 0.5rem 2.5rem',
                                border: '1px solid #d1d5db',
                                borderRadius: '0.375rem',
                                fontSize: '0.875rem',
                                paddingLeft: '2.5rem'
                            }
                        })
                    )
                ),
                error && React.createElement('div', {
                    style: {
                        marginBottom: '1rem',
                        padding: '0.5rem',
                        backgroundColor: '#fef2f2',
                        border: '1px solid #fecaca',
                        borderRadius: '0.375rem',
                        color: '#dc2626',
                        fontSize: '0.875rem',
                        opacity: fadeIn ? 1 : 0,
                        transform: fadeIn ? 'translateY(0)' : 'translateY(-10px)',
                        transition: 'opacity 0.3s ease-in-out, transform 0.3s ease-in-out'
                    }
                }, error),
                React.createElement('button', {
                    type: 'submit',
                    disabled: loading,
                    style: {
                        width: '100%',
                        padding: '0.5rem 1rem',
                        backgroundColor: loading ? '#9ca3af' : '#2563eb',
                        color: 'white',
                        fontSize: '0.875rem',
                        fontWeight: '500',
                        borderRadius: '0.375rem',
                        border: 'none',
                        cursor: loading ? 'not-allowed' : 'pointer',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                        gap: '0.5rem'
                    }
                }, 
                    React.createElement(SignIn, { size: 16 }),
                    loading ? 'Signing in...' : 'Sign in'
                )
            )
        )
        )
    );
};

const App = () => {
    const [currentPage, setCurrentPage] = useState(window.location.pathname);
    const [isAuthenticated, setIsAuthenticated] = useState(false);
    const [authChecked, setAuthChecked] = useState(false);

    // Check authentication status on mount and route changes
    useEffect(() => {
        const checkAuth = () => {
            const token = localStorage.getItem('token');
            const user = localStorage.getItem('user');
            const sessionToken = sessionStorage.getItem('authSession');
            
            // Multiple layers of authentication check
            const authenticated = !!(token && user && sessionToken);
            setIsAuthenticated(authenticated);
            setAuthChecked(true);
            
            // Additional validation: check if session token matches stored token
            if (token && sessionToken && token !== sessionToken) {
                // Session mismatch - clear all auth data and redirect
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                localStorage.removeItem('lastActivity');
                sessionStorage.clear();
                window.location.href = '/';
                return;
            }
            
            // Redirect to login if not authenticated and trying to access protected routes
            if (!authenticated && (window.location.pathname.startsWith('/dashboard') || 
                window.location.pathname.startsWith('/groups') ||
                window.location.pathname.startsWith('/projects') ||
                window.location.pathname.startsWith('/users') ||
                window.location.pathname.startsWith('/analytics') ||
                window.location.pathname.startsWith('/reports') ||
                window.location.pathname.startsWith('/profile') ||
                window.location.pathname.startsWith('/settings'))) {
                window.location.href = '/';
            }
        };

        checkAuth();

        // Listen for storage changes (for logout in other tabs)
        const handleStorageChange = (e) => {
            if (e.key === 'token' || e.key === 'user' || e.key === 'authSession') {
                checkAuth();
            }
        };

        // Prevent back button access to protected routes when logged out
        const handleBeforeUnload = (e) => {
            const token = localStorage.getItem('token');
            const user = localStorage.getItem('user');
            if (!token || !user) {
                // Clear any potential back navigation history
                window.history.pushState({}, '', '/');
            }
        };

        window.addEventListener('storage', handleStorageChange);
        window.addEventListener('beforeunload', handleBeforeUnload);

        // Check for direct URL manipulation attempts
        const checkDirectAccess = () => {
            const token = localStorage.getItem('token');
            const user = localStorage.getItem('user');
            if (!token || !user) {
                // Replace history to prevent back navigation
                window.history.replaceState({}, '', '/');
            }
        };

        checkDirectAccess();

        return () => {
            window.removeEventListener('storage', handleStorageChange);
            window.removeEventListener('beforeunload', handleBeforeUnload);
        };
    }, []);

    useEffect(() => {
        const handlePopState = () => {
            setCurrentPage(window.location.pathname);
            // Re-check auth on route change
            const token = localStorage.getItem('token');
            const user = localStorage.getItem('user');
            const authenticated = !!(token && user);
            setIsAuthenticated(authenticated);
            
            // Redirect if not authenticated
            if (!authenticated && (window.location.pathname.startsWith('/dashboard') || 
                window.location.pathname.startsWith('/groups') ||
                window.location.pathname.startsWith('/projects') ||
                window.location.pathname.startsWith('/users') ||
                window.location.pathname.startsWith('/analytics') ||
                window.location.pathname.startsWith('/reports') ||
                window.location.pathname.startsWith('/profile') ||
                window.location.pathname.startsWith('/settings'))) {
                window.location.href = '/';
            }
        };
        
        window.addEventListener('popstate', handlePopState);
        return () => window.removeEventListener('popstate', handlePopState);
    }, []);

    // Temporarily bypass authentication check to ensure React mounts
    // if (!authChecked) {
    //     return React.createElement('div', {
    //         style: {
    //             display: 'flex',
    //             justifyContent: 'center',
    //             alignItems: 'center',
    //             minHeight: '100vh',
    //             backgroundColor: '#f9fafb',
    //             fontSize: '1.125rem',
    //             color: '#6b7280'
    //         }
    //     }, 'Loading...');
    // }

    
    // Route protection logic
    const isProtectedRoute = (path) => {
        return path.startsWith('/dashboard') || 
               path.startsWith('/groups') ||
               path.startsWith('/projects') ||
               path.startsWith('/users') ||
               path.startsWith('/analytics') ||
               path.startsWith('/reports') ||
               path.startsWith('/profile') ||
               path.startsWith('/settings');
    };

    if (isProtectedRoute(currentPage) && !isAuthenticated) {
        // Redirect to login if trying to access protected route without auth
        window.location.href = '/';
        return React.createElement('div', {
            style: {
                display: 'flex',
                justifyContent: 'center',
                alignItems: 'center',
                minHeight: '100vh',
                backgroundColor: '#f9fafb',
                fontSize: '1.125rem',
                color: '#6b7280'
            }
        }, 'Redirecting to login...');
    }

    // Route based rendering
    if (currentPage === '/' || currentPage === '/login') {
        return React.createElement(Login);
    } else if (currentPage === '/dashboard') {
        return React.createElement(Dashboard);
    } else {
        // Default to login for any unhandled routes
        return React.createElement(Login);
    }
};

// Ensure auth check completes within reasonable time
setTimeout(() => {
    setAuthChecked(true);
}, 500);

const root = ReactDOM.createRoot(document.getElementById('app'));
root.render(React.createElement(App));

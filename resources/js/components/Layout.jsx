import React, { useState } from 'react';
import { Outlet, Link, useLocation, useNavigate } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';
import { useNotifications } from '../contexts/NotificationContext';
import { 
    HomeIcon, 
    UserGroupIcon, 
    FolderIcon, 
    CheckIcon,
    ChatBubbleLeftRightIcon,
    ChartBarIcon,
    Cog6ToothIcon,
    BellIcon,
    UserCircleIcon,
    ArrowRightOnRectangleIcon,
    AcademicCapIcon,
    ShieldCheckIcon
} from '@heroicons/react/24/outline';

const Layout = () => {
    const { user, logout, isAdmin, isSupervisor, isStudent } = useAuth();
    const { unreadCount } = useNotifications();
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [notificationsOpen, setNotificationsOpen] = useState(false);
    const location = useLocation();
    const navigate = useNavigate();

    const handleLogout = async () => {
        await logout();
        navigate('/login');
    };

    const navigation = [
        { name: 'Dashboard', href: '/dashboard', icon: HomeIcon, current: location.pathname === '/dashboard' },
        { name: 'Groups', href: '/groups', icon: UserGroupIcon, current: location.pathname.startsWith('/groups') },
        { name: 'Projects', href: '/projects', icon: FolderIcon, current: location.pathname.startsWith('/projects') },
        { name: 'Tasks', href: '/tasks', icon: CheckIcon, current: location.pathname.startsWith('/tasks') },
        { name: 'Messages', href: '/messages', icon: ChatBubbleLeftRightIcon, current: location.pathname.startsWith('/messages') },
        { name: 'Reports', href: '/reports', icon: ChartBarIcon, current: location.pathname === '/reports' },
    ];

    const adminNavigation = [
        { name: 'Admin Panel', href: '/admin', icon: ShieldCheckIcon, current: location.pathname.startsWith('/admin') },
    ];

    const supervisorNavigation = [
        { name: 'Supervisor Dashboard', href: '/supervisor', icon: AcademicCapIcon, current: location.pathname.startsWith('/supervisor') },
    ];

    const getSidebarClasses = () => {
        const base = "fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0";
        return sidebarOpen ? `${base} translate-x-0` : `${base} -translate-x-full`;
    };

    const getNavItemClasses = (current) => {
        return current 
            ? "group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 bg-blue-50 text-blue-700 border-r-2 border-blue-700"
            : "group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900";
    };

    const getIconClasses = (current) => {
        return current 
            ? "mr-3 h-5 w-5 flex-shrink-0 text-blue-700"
            : "mr-3 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500";
    };

    return (
        <div className="min-h-screen bg-gray-50">
            {/* Mobile sidebar backdrop */}
            {sidebarOpen && (
                <div 
                    className="fixed inset-0 z-40 lg:hidden bg-gray-600 bg-opacity-75"
                    onClick={() => setSidebarOpen(false)}
                />
            )}

            {/* Sidebar */}
            <div className={getSidebarClasses()}>
                <div className="flex items-center justify-between h-16 px-6 border-b border-gray-200">
                    <h1 className="text-xl font-bold text-gray-900">GPTFMS</h1>
                    <button
                        onClick={() => setSidebarOpen(false)}
                        className="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500"
                    >
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav className="mt-6 px-3">
                    <div className="space-y-1">
                        {navigation.map((item) => {
                            const Icon = item.icon;
                            return (
                                <Link
                                    key={item.name}
                                    to={item.href}
                                    className={getNavItemClasses(item.current)}
                                >
                                    <Icon className={getIconClasses(item.current)} />
                                    {item.name}
                                </Link>
                            );
                        })}
                    </div>

                    {/* Admin Navigation */}
                    {isAdmin && (
                        <div className="mt-8">
                            <h3 className="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Administration
                            </h3>
                            <div className="mt-2 space-y-1">
                                {adminNavigation.map((item) => {
                                    const Icon = item.icon;
                                    const current = item.current 
                                        ? "bg-red-50 text-red-700 border-r-2 border-red-700"
                                        : "text-gray-700 hover:bg-gray-50 hover:text-gray-900";
                                    const iconCurrent = item.current 
                                        ? "text-red-700"
                                        : "text-gray-400 group-hover:text-gray-500";
                                    return (
                                        <Link
                                            key={item.name}
                                            to={item.href}
                                            className={`group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 ${current}`}
                                        >
                                            <Icon className={`mr-3 h-5 w-5 flex-shrink-0 ${iconCurrent}`} />
                                            {item.name}
                                        </Link>
                                    );
                                })}
                            </div>
                        </div>
                    )}

                    {/* Supervisor Navigation */}
                    {isSupervisor && (
                        <div className="mt-8">
                            <h3 className="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Supervision
                            </h3>
                            <div className="mt-2 space-y-1">
                                {supervisorNavigation.map((item) => {
                                    const Icon = item.icon;
                                    const current = item.current 
                                        ? "bg-green-50 text-green-700 border-r-2 border-green-700"
                                        : "text-gray-700 hover:bg-gray-50 hover:text-gray-900";
                                    const iconCurrent = item.current 
                                        ? "text-green-700"
                                        : "text-gray-400 group-hover:text-gray-500";
                                    return (
                                        <Link
                                            key={item.name}
                                            to={item.href}
                                            className={`group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200 ${current}`}
                                        >
                                            <Icon className={`mr-3 h-5 w-5 flex-shrink-0 ${iconCurrent}`} />
                                            {item.name}
                                        </Link>
                                    );
                                })}
                            </div>
                        </div>
                    )}
                </nav>
            </div>

            {/* Main content */}
            <div className="lg:pl-64">
                {/* Top navbar */}
                <div className="sticky top-0 z-10 bg-white shadow-sm border-b border-gray-200">
                    <div className="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                        <button
                            onClick={() => setSidebarOpen(true)}
                            className="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500"
                        >
                            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div className="flex items-center space-x-4">
                            {/* Notifications */}
                            <div className="relative">
                                <button
                                    onClick={() => setNotificationsOpen(!notificationsOpen)}
                                    className="p-2 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    <BellIcon className="h-6 w-6" />
                                    {unreadCount > 0 && (
                                        <span className="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white" />
                                    )}
                                </button>

                                {/* Notifications dropdown */}
                                {notificationsOpen && (
                                    <div className="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                                        <div className="p-4 border-b border-gray-200">
                                            <h3 className="text-sm font-medium text-gray-900">Notifications</h3>
                                            {unreadCount > 0 && (
                                                <span className="ml-2 text-xs text-blue-600">
                                                    {unreadCount} unread
                                                </span>
                                            )}
                                        </div>
                                        <div className="max-h-96 overflow-y-auto">
                                            <div className="p-4 text-sm text-gray-500 text-center">
                                                No new notifications
                                            </div>
                                        </div>
                                    </div>
                                )}
                            </div>

                            {/* User menu */}
                            <div className="relative">
                                <button className="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100">
                                    <div className="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                        <UserCircleIcon className="h-6 w-6 text-gray-600" />
                                    </div>
                                    <span className="hidden md:block text-sm font-medium text-gray-900">
                                        {user?.full_name || user?.email}
                                    </span>
                                </button>
                            </div>

                            <button
                                onClick={handleLogout}
                                className="p-2 rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-100"
                                title="Logout"
                            >
                                <ArrowRightOnRectangleIcon className="h-5 w-5" />
                            </button>
                        </div>
                    </div>
                </div>

                {/* Page content */}
                <main className="flex-1">
                    <Outlet />
                </main>
            </div>
        </div>
    );
};

export default Layout;

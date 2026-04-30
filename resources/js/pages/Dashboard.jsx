import React, { useState, useEffect } from 'react';
import { useAuth } from '../contexts/AuthContext';
import { analyticsAPI } from '../services/api';
import { 
    UserGroupIcon, 
    FolderIcon, 
    CheckIcon,
    ChatBubbleLeftRightIcon,
    BellIcon,
    ArrowTrendingUpIcon,
    ClockIcon,
    ExclamationTriangleIcon
} from '@heroicons/react/24/outline';

const Dashboard = () => {
    const { user, isStudent, isSupervisor, isAdmin } = useAuth();
    const [dashboardData, setDashboardData] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchDashboardData();
    }, []);

    const fetchDashboardData = async () => {
        try {
            const response = await analyticsAPI.dashboard();
            setDashboardData(response.data);
        } catch (error) {
            console.error('Failed to fetch dashboard data:', error);
        } finally {
            setLoading(false);
        }
    };

    if (loading) {
        return (
            <div className="flex items-center justify-center h-64">
                <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            </div>
        );
    }

    const renderStudentDashboard = () => (
        <div className="space-y-6">
            {/* Stats Cards */}
            <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <UserGroupIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">My Groups</dt>
                                    <dd className="text-lg font-medium text-gray-900">{dashboardData?.my_groups || 0}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <CheckSquareIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">Pending Tasks</dt>
                                    <dd className="text-lg font-medium text-gray-900">{dashboardData?.pending_tasks || 0}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <TrendingUpIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">Progress %</dt>
                                    <dd className="text-lg font-medium text-gray-900">{dashboardData?.profile_completion || 0}%</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <BellIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">Messages</dt>
                                    <dd className="text-lg font-medium text-gray-900">{dashboardData?.unread_messages || 0}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* Recent Activity */}
            <div className="bg-white shadow rounded-lg">
                <div className="px-4 py-5 sm:p-6">
                    <h3 className="text-lg leading-6 font-medium text-gray-900">Recent Activity</h3>
                    <div className="mt-5">
                        <div className="flow-root">
                            <ul className="-mb-8">
                                {dashboardData?.recent_activity?.map((activity, index) => (
                                    <li key={index}>
                                        <div className="relative pb-8">
                                            {index !== dashboardData.recent_activity.length - 1 && (
                                                <div className="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" />
                                            )}
                                            <div className="relative flex items-start space-x-3">
                                                <div>
                                                    <div className="relative">
                                                        <div className="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                            <ClockIcon className="h-4 w-4 text-white" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className="min-w-0 flex-1 py-0.5">
                                                    <p className="text-sm text-gray-500">{activity.description}</p>
                                                    <p className="mt-0.5 text-xs text-gray-400">
                                                        {new Date(activity.created_at).toLocaleDateString()}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {/* Upcoming Deadlines */}
            <div className="bg-white shadow rounded-lg">
                <div className="px-4 py-5 sm:p-6">
                    <h3 className="text-lg leading-6 font-medium text-gray-900">Upcoming Deadlines</h3>
                    <div className="mt-5">
                        {dashboardData?.upcoming_deadlines?.length > 0 ? (
                            <div className="space-y-3">
                                {dashboardData.upcoming_deadlines.map((task, index) => (
                                    <div key={index} className="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                        <div>
                                            <p className="text-sm font-medium text-gray-900">{task.title}</p>
                                            <p className="text-xs text-gray-500">{task.project?.title}</p>
                                        </div>
                                        <div className="text-sm text-gray-500">
                                            Due: {new Date(task.due_date).toLocaleDateString()}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <p className="text-sm text-gray-500">No upcoming deadlines</p>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );

    const renderSupervisorDashboard = () => (
        <div className="space-y-6">
            <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <FolderIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">Total Projects</dt>
                                    <dd className="text-lg font-medium text-gray-900">{dashboardData?.total_projects || 0}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <TrendingUpIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">Active Projects</dt>
                                    <dd className="text-lg font-medium text-gray-900">{dashboardData?.active_projects || 0}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <UserGroupIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">Total Groups</dt>
                                    <dd className="text-lg font-medium text-gray-900">{dashboardData?.total_groups || 0}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-red-500 rounded-md p-3">
                                <ExclamationTriangleIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">At Risk Projects</dt>
                                    <dd className="text-lg font-medium text-gray-900">{dashboardData?.at_risk_projects || 0}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );

    const renderAdminDashboard = () => (
        <div className="space-y-6">
            <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <UserGroupIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                                    <dd className="text-lg font-medium text-gray-900">{dashboardData?.users?.total || 0}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <FolderIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">Total Projects</dt>
                                    <dd className="text-lg font-medium text-gray-900">{dashboardData?.projects?.total || 0}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <CheckSquareIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">Completed Tasks</dt>
                                    <dd className="text-lg font-medium text-gray-900">{dashboardData?.tasks?.completed || 0}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <TrendingUpIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">Active Groups</dt>
                                    <dd className="text-lg font-medium text-gray-900">{dashboardData?.groups?.active || 0}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );

    return (
        <div className="px-4 sm:px-6 lg:px-8 py-8">
            <div className="mb-8">
                <h1 className="text-2xl font-bold text-gray-900">
                    Welcome back, {user?.first_name || user?.email}!
                </h1>
                <p className="mt-2 text-gray-600">
                    Here's what's happening with your projects and groups today.
                </p>
            </div>

            {isStudent && renderStudentDashboard()}
            {isSupervisor && renderSupervisorDashboard()}
            {isAdmin && renderAdminDashboard()}
        </div>
    );
};

export default Dashboard;

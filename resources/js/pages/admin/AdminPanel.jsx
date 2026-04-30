import React, { useState, useEffect } from 'react';
import { Routes, Route, Link } from 'react-router-dom';
import { useAuth } from '../../contexts/AuthContext';
import { analyticsAPI } from '../../services/api';
import { 
    ShieldCheckIcon, 
    UserGroupIcon, 
    FolderIcon, 
    ChartBarIcon,
    UserIcon,
    DocumentArrowDownIcon,
    Cog6ToothIcon,
    ExclamationTriangleIcon
} from '@heroicons/react/24/outline';

const AdminPanel = () => {
    const { user } = useAuth();
    const [stats, setStats] = useState(null);
    const [users, setUsers] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchStats();
        fetchUsers();
    }, []);

    const fetchStats = async () => {
        try {
            const response = await analyticsAPI.systemStats();
            setStats(response.data);
        } catch (error) {
            console.error('Failed to fetch stats:', error);
        }
    };

    const fetchUsers = async () => {
        try {
            const response = await analyticsAPI.getAllUsers();
            setUsers(response.data.data || response.data);
        } catch (error) {
            console.error('Failed to fetch users:', error);
        } finally {
            setLoading(false);
        }
    };

    const handleToggleUserStatus = async (userId) => {
        try {
            await analyticsAPI.toggleUserStatus(userId);
            fetchUsers(); // Refresh users list
        } catch (error) {
            console.error('Failed to toggle user status:', error);
        }
    };

    if (loading) {
        return (
            <div className="flex items-center justify-center h-64">
                <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            </div>
        );
    }

    return (
        <div className="px-4 sm:px-6 lg:px-8 py-8">
            <div className="mb-8">
                <h1 className="text-2xl font-bold text-gray-900">Admin Panel</h1>
                <p className="mt-2 text-gray-600">
                    System administration and user management
                </p>
            </div>

            {/* Stats Overview */}
            {stats && (
                <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div className="card">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <UserGroupIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                                    <dd className="text-lg font-medium text-gray-900">{stats.users.total}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div className="card">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <FolderIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">Active Projects</dt>
                                    <dd className="text-lg font-medium text-gray-900">{stats.projects.total}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div className="card">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <ChartBarIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">Completed Tasks</dt>
                                    <dd className="text-lg font-medium text-gray-900">{stats.tasks.completed}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div className="card">
                        <div className="flex items-center">
                            <div className="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <UserIcon className="h-6 w-6 text-white" />
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">Active Groups</dt>
                                    <dd className="text-lg font-medium text-gray-900">{stats.groups.active}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            )}

            {/* User Management */}
            <div className="bg-white shadow rounded-lg">
                <div className="px-4 py-5 sm:p-6">
                    <div className="flex items-center justify-between">
                        <h3 className="text-lg leading-6 font-medium text-gray-900">User Management</h3>
                        <Link
                            to="/admin/users/create"
                            className="btn-primary"
                        >
                            Add User
                        </Link>
                    </div>
                    
                    <div className="mt-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table className="min-w-full divide-y divide-gray-300">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {users.map((user) => (
                                    <tr key={user.id}>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            <div className="flex items-center">
                                                <div className="h-10 w-10 flex-shrink-0 rounded-full bg-gray-300">
                                                    <span className="h-full w-full rounded-full bg-gray-400 flex items-center justify-center text-sm font-medium text-gray-600">
                                                        {user.first_name?.[0] || 'U'}
                                                    </span>
                                                </div>
                                                <div className="ml-4">
                                                    <div className="text-sm font-medium text-gray-900">{user.first_name} {user.last_name}</div>
                                                    <div className="text-sm text-gray-500">{user.email}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                                                user.roles?.[0]?.name === 'admin' ? 'bg-red-100 text-red-800' :
                                                user.roles?.[0]?.name === 'supervisor' ? 'bg-blue-100 text-blue-800' :
                                                'bg-green-100 text-green-800'
                                            }`}>
                                                {user.roles?.[0]?.name}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                                                user.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                            }`}>
                                                {user.status}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div className="flex space-x-2">
                                                <button
                                                    onClick={() => handleToggleUserStatus(user.id)}
                                                    className={`text-blue-600 hover:text-blue-900 ${
                                                        user.status === 'active' ? 'text-red-600 hover:text-red-900' : ''
                                                    }`}
                                                >
                                                    {user.status === 'active' ? 'Deactivate' : 'Activate'}
                                                </button>
                                                <Link
                                                    to={`/admin/users/${user.id}/edit`}
                                                    className="text-blue-600 hover:text-blue-900"
                                                >
                                                    Edit
                                                </Link>
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default AdminPanel;

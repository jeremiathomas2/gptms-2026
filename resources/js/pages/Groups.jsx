import React, { useState, useEffect } from 'react';
import { Routes, Route, Link } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';
import { groupAPI } from '../services/api';
import { 
    UserGroupIcon, 
    PlusIcon, 
    MagnifyingGlassIcon,
    UserPlusIcon,
    ChartBarIcon,
    ClockIcon,
    CheckCircleIcon
} from '@heroicons/react/24/outline';

const Groups = () => {
    const { user, isStudent, isSupervisor, isAdmin } = useAuth();
    const [groups, setGroups] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState('');
    const [filter, setFilter] = useState('all');

    useEffect(() => {
        fetchGroups();
    }, []);

    const fetchGroups = async () => {
        try {
            let response;
            if (isSupervisor) {
                response = await groupAPI.supervisorGroups();
            } else {
                response = await groupAPI.myGroups();
            }
            setGroups(response.data.data || response.data);
        } catch (error) {
            console.error('Failed to fetch groups:', error);
        } finally {
            setLoading(false);
        }
    };

    const handleJoinGroup = async (groupId) => {
        try {
            await groupAPI.joinGroup(groupId);
            fetchGroups(); // Refresh groups list
        } catch (error) {
            console.error('Failed to join group:', error);
        }
    };

    const handleLeaveGroup = async (groupId) => {
        try {
            await groupAPI.leaveGroup(groupId);
            fetchGroups(); // Refresh groups list
        } catch (error) {
            console.error('Failed to leave group:', error);
        }
    };

    const filteredGroups = groups.filter(group => {
        const matchesSearch = group.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                             group.description?.toLowerCase().includes(searchTerm.toLowerCase());
        
        if (filter === 'all') return matchesSearch;
        if (filter === 'active') return matchesSearch && group.status === 'active';
        if (filter === 'completed') return matchesSearch && group.status === 'completed';
        
        return matchesSearch;
    });

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
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold text-gray-900">Groups</h1>
                    {isStudent && (
                        <Link
                            to="/groups/create"
                            className="btn-primary flex items-center"
                        >
                            <PlusIcon className="h-4 w-4 mr-2" />
                            Create Group
                        </Link>
                    )}
                </div>

                {/* Search and Filter */}
                <div className="mt-4 flex flex-col sm:flex-row gap-4">
                    <div className="flex-1">
                        <div className="relative">
                            <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <MagnifyingGlassIcon className="h-5 w-5 text-gray-400" />
                            </div>
                            <input
                                type="text"
                                placeholder="Search groups..."
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                className="input-field pl-10"
                            />
                        </div>
                    </div>
                    <div className="flex gap-2">
                        <select
                            value={filter}
                            onChange={(e) => setFilter(e.target.value)}
                            className="input-field"
                        >
                            <option value="all">All Groups</option>
                            <option value="active">Active</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
            </div>

            {/* Groups Grid */}
            <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {filteredGroups.map((group) => (
                    <div key={group.id} className="card">
                        <div className="flex items-start justify-between">
                            <div className="flex items-center">
                                <div className="p-2 bg-blue-100 rounded-lg">
                                    <UserGroupIcon className="h-6 w-6 text-blue-600" />
                                </div>
                                <div className="ml-3">
                                    <h3 className="text-lg font-medium text-gray-900">{group.name}</h3>
                                    <p className="text-sm text-gray-500 mt-1">
                                        {group.members?.length || 0} / {group.max_members} members
                                    </p>
                                </div>
                            </div>
                            <span className={`px-2 py-1 text-xs font-medium rounded-full ${
                                group.status === 'active' ? 'bg-green-100 text-green-800' :
                                group.status === 'completed' ? 'bg-gray-100 text-gray-800' :
                                'bg-yellow-100 text-yellow-800'
                            }`}>
                                {group.status}
                            </span>
                        </div>

                        <p className="mt-3 text-gray-600 text-sm">
                            {group.description}
                        </p>

                        <div className="mt-4 flex items-center justify-between">
                            <div className="flex items-center space-x-4 text-sm text-gray-500">
                                {group.formation_score && (
                                    <div className="flex items-center">
                                        <ChartBarIcon className="h-4 w-4 mr-1" />
                                        Score: {group.formation_score}
                                    </div>
                                )}
                                {group.formed_at && (
                                    <div className="flex items-center">
                                        <ClockIcon className="h-4 w-4 mr-1" />
                                        Formed: {new Date(group.formed_at).toLocaleDateString()}
                                    </div>
                                )}
                            </div>

                            <div className="flex gap-2">
                                {isStudent && group.status === 'forming' && (
                                    <button
                                        onClick={() => handleJoinGroup(group.id)}
                                        className="btn-primary text-sm"
                                    >
                                        Join Group
                                    </button>
                                )}
                                
                                {isStudent && group.status === 'active' && (
                                    <button
                                        onClick={() => handleLeaveGroup(group.id)}
                                        className="btn-secondary text-sm"
                                    >
                                        Leave Group
                                    </button>
                                )}

                                <Link
                                    to={`/groups/${group.id}`}
                                    className="btn-secondary text-sm"
                                >
                                    View Details
                                </Link>
                            </div>
                        </div>

                        {/* Members Preview */}
                        {group.members && group.members.length > 0 && (
                            <div className="mt-4 pt-4 border-t border-gray-200">
                                <h4 className="text-sm font-medium text-gray-900 mb-2">Members</h4>
                                <div className="flex -space-x-2">
                                    {group.members.slice(0, 4).map((member) => (
                                        <div key={member.id} className="flex flex-col items-center">
                                            <div className="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span className="text-xs font-medium text-gray-600">
                                                    {member.user?.first_name?.[0] || 'U'}
                                                </span>
                                            </div>
                                            <span className="text-xs text-gray-500 mt-1">
                                                {member.user?.first_name}
                                            </span>
                                        </div>
                                    ))}
                                    {group.members.length > 4 && (
                                        <div className="flex flex-col items-center">
                                            <div className="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span className="text-xs font-medium text-gray-600">+</span>
                                            </div>
                                            <span className="text-xs text-gray-500 mt-1">
                                                {group.members.length - 4} more
                                            </span>
                                        </div>
                                    )}
                                </div>
                            </div>
                        )}
                    </div>
                ))}
            </div>

            {filteredGroups.length === 0 && (
                <div className="text-center py-12">
                    <UserGroupIcon className="h-12 w-12 text-gray-400 mx-auto mb-4" />
                    <h3 className="text-lg font-medium text-gray-900 mb-2">No groups found</h3>
                    <p className="text-gray-500">
                        {searchTerm ? 'Try adjusting your search terms' : 'No groups match your current filters'}
                    </p>
                </div>
            )}
        </div>
    );
};

export default Groups;

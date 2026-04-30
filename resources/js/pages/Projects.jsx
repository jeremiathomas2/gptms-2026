import React, { useState, useEffect } from 'react';
import { Routes, Route, Link } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';
import { projectAPI } from '../services/api';
import { 
    FolderIcon, 
    PlusIcon, 
    MagnifyingGlassIcon,
    UserGroupIcon,
    CalendarIcon,
    CheckCircleIcon,
    ClockIcon,
    ExclamationTriangleIcon
} from '@heroicons/react/24/outline';

const Projects = () => {
    const { user, isStudent, isSupervisor, isAdmin } = useAuth();
    const [projects, setProjects] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState('');
    const [filter, setFilter] = useState('all');

    useEffect(() => {
        fetchProjects();
    }, []);

    const fetchProjects = async () => {
        try {
            let response;
            if (isSupervisor) {
                response = await projectAPI.supervisedProjects();
            } else if (isStudent) {
                response = await projectAPI.myProjects();
            } else {
                response = await projectAPI.getAll();
            }
            setProjects(response.data.data || response.data);
        } catch (error) {
            console.error('Failed to fetch projects:', error);
        } finally {
            setLoading(false);
        }
    };

    const filteredProjects = projects.filter(project => {
        const matchesSearch = project.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
                             project.description?.toLowerCase().includes(searchTerm.toLowerCase()) ||
                             project.course_code?.toLowerCase().includes(searchTerm.toLowerCase());
        
        if (filter === 'all') return matchesSearch;
        if (filter === 'active') return matchesSearch && project.status === 'in_progress';
        if (filter === 'completed') return matchesSearch && project.status === 'completed';
        if (filter === 'overdue') return matchesSearch && new Date(project.end_date) < new Date();
        
        return matchesSearch;
    });

    const getStatusColor = (status) => {
        switch (status) {
            case 'in_progress': return 'text-blue-600 bg-blue-100';
            case 'completed': return 'text-green-600 bg-green-100';
            case 'overdue': return 'text-red-600 bg-red-100';
            default: return 'text-gray-600 bg-gray-100';
        }
    };

    const getPriorityColor = (priority) => {
        switch (priority) {
            case 'high': return 'text-red-600 bg-red-100';
            case 'medium': return 'text-yellow-600 bg-yellow-100';
            case 'low': return 'text-green-600 bg-green-100';
            default: return 'text-gray-600 bg-gray-100';
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
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold text-gray-900">Projects</h1>
                    {(isSupervisor || isAdmin) && (
                        <Link
                            to="/projects/create"
                            className="btn-primary flex items-center"
                        >
                            <PlusIcon className="h-4 w-4 mr-2" />
                            Create Project
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
                                placeholder="Search projects..."
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
                            <option value="all">All Projects</option>
                            <option value="active">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="overdue">Overdue</option>
                        </select>
                    </div>
                </div>
            </div>

            {/* Projects Grid */}
            <div className="grid grid-cols-1 gap-6 lg:grid-cols-2">
                {filteredProjects.map((project) => (
                    <div key={project.id} className="card">
                        <div className="flex items-start justify-between mb-4">
                            <div className="flex items-center space-x-2">
                                <span className={`px-2 py-1 text-xs font-medium rounded-full ${getStatusColor(project.status)}`}>
                                    {project.status}
                                </span>
                                <span className={`px-2 py-1 text-xs font-medium rounded-full ${getPriorityColor(project.priority)}`}>
                                    {project.priority}
                                </span>
                            </div>
                            <div className="flex items-center space-x-2 text-sm text-gray-500">
                                {project.group && (
                                    <div className="flex items-center">
                                        <UserGroupIcon className="h-4 w-4 mr-1" />
                                        {project.group.name}
                                    </div>
                                )}
                                <div className="flex items-center">
                                    <CalendarIcon className="h-4 w-4 mr-1" />
                                    {new Date(project.end_date).toLocaleDateString()}
                                </div>
                            </div>
                        </div>

                        <div className="space-y-4">
                            <div>
                                <h3 className="text-lg font-medium text-gray-900">{project.title}</h3>
                                <p className="text-sm text-gray-600 mt-1">{project.course_code}</p>
                            </div>

                            <p className="text-gray-600 text-sm line-clamp-3">
                                {project.description}
                            </p>

                            {/* Progress Bar */}
                            <div className="mt-4">
                                <div className="flex items-center justify-between text-sm text-gray-600 mb-2">
                                    <span>Progress</span>
                                    <span>{project.progress_percentage || 0}%</span>
                                </div>
                                <div className="w-full bg-gray-200 rounded-full h-2">
                                    <div 
                                        className="bg-blue-600 h-2 rounded-full transition-all duration-300"
                                        style={{ width: `${project.progress_percentage || 0}%` }}
                                    ></div>
                                </div>
                            </div>

                            {/* Team Members */}
                            {project.group && (
                                <div className="mt-4">
                                    <h4 className="text-sm font-medium text-gray-900 mb-2">Team</h4>
                                    <div className="flex -space-x-2">
                                        {project.group.active_members?.slice(0, 4).map((member) => (
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
                                        {project.group.active_members?.length > 4 && (
                                            <div className="flex flex-col items-center">
                                                <div className="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <span className="text-xs font-medium text-gray-600">+</span>
                                                </div>
                                                <span className="text-xs text-gray-500 mt-1">
                                                    {project.group.active_members.length - 4} more
                                                </span>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            )}

                            {/* Action Buttons */}
                            <div className="mt-6 flex gap-2">
                                <Link
                                    to={`/projects/${project.id}`}
                                    className="btn-secondary text-sm flex-1"
                                >
                                    View Details
                                </Link>
                                {(isSupervisor || isAdmin) && (
                                    <Link
                                        to={`/projects/${project.id}/edit`}
                                        className="btn-secondary text-sm"
                                    >
                                        Edit
                                    </Link>
                                )}
                            </div>
                        </div>
                    </div>
                ))}
            </div>

            {filteredProjects.length === 0 && (
                <div className="text-center py-12">
                    <FolderIcon className="h-12 w-12 text-gray-400 mx-auto mb-4" />
                    <h3 className="text-lg font-medium text-gray-900 mb-2">No projects found</h3>
                    <p className="text-gray-500">
                        {searchTerm ? 'Try adjusting your search terms' : 'No projects match your current filters'}
                    </p>
                </div>
            )}
        </div>
    );
};

export default Projects;

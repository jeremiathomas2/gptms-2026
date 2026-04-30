import React, { useState, useEffect } from 'react';
import { Routes, Route, Link } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';
import { taskAPI } from '../services/api';
import { 
    CheckIcon, 
    PlusIcon, 
    MagnifyingGlassIcon,
    UserIcon,
    CalendarIcon,
    ClockIcon,
    CheckCircleIcon,
    ExclamationTriangleIcon
} from '@heroicons/react/24/outline';

const Tasks = () => {
    const { user, isStudent, isSupervisor, isAdmin } = useAuth();
    const [tasks, setTasks] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState('');
    const [filter, setFilter] = useState('all');

    useEffect(() => {
        fetchTasks();
    }, []);

    const fetchTasks = async () => {
        try {
            let response;
            if (isStudent) {
                response = await taskAPI.myTasks();
            } else {
                response = await taskAPI.getAll();
            }
            setTasks(response.data.data || response.data);
        } catch (error) {
            console.error('Failed to fetch tasks:', error);
        } finally {
            setLoading(false);
        }
    };

    const handleStatusUpdate = async (taskId, newStatus) => {
        try {
            await taskAPI.updateStatus(taskId, { status: newStatus });
            fetchTasks(); // Refresh tasks list
        } catch (error) {
            console.error('Failed to update task status:', error);
        }
    };

    const filteredTasks = tasks.filter(task => {
        const matchesSearch = task.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
                             task.description?.toLowerCase().includes(searchTerm.toLowerCase()) ||
                             task.tags?.some(tag => tag.toLowerCase().includes(searchTerm.toLowerCase()));
        
        if (filter === 'all') return matchesSearch;
        if (filter === 'todo') return matchesSearch && task.status === 'todo';
        if (filter === 'in_progress') return matchesSearch && task.status === 'in_progress';
        if (filter === 'completed') return matchesSearch && task.status === 'completed';
        if (filter === 'overdue') return matchesSearch && new Date(task.due_date) < new Date();
        
        return matchesSearch;
    });

    const getStatusColor = (status) => {
        switch (status) {
            case 'todo': return 'text-gray-600 bg-gray-100';
            case 'in_progress': return 'text-blue-600 bg-blue-100';
            case 'completed': return 'text-green-600 bg-green-100';
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

    const isOverdue = (dueDate) => {
        return new Date(dueDate) < new Date();
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
                    <h1 className="text-2xl font-bold text-gray-900">Tasks</h1>
                    {(isSupervisor || isAdmin) && (
                        <Link
                            to="/tasks/create"
                            className="btn-primary flex items-center"
                        >
                            <PlusIcon className="h-4 w-4 mr-2" />
                            Create Task
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
                                placeholder="Search tasks..."
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
                            <option value="all">All Tasks</option>
                            <option value="todo">To Do</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="overdue">Overdue</option>
                        </select>
                    </div>
                </div>
            </div>

            {/* Tasks List */}
            <div className="space-y-4">
                {filteredTasks.map((task) => (
                    <div key={task.id} className="card">
                        <div className="flex items-start justify-between mb-4">
                            <div className="flex items-center space-x-2">
                                <span className={`px-2 py-1 text-xs font-medium rounded-full ${getStatusColor(task.status)}`}>
                                    {task.status}
                                </span>
                                <span className={`px-2 py-1 text-xs font-medium rounded-full ${getPriorityColor(task.priority)}`}>
                                    {task.priority}
                                </span>
                                {isOverdue(task.due_date) && (
                                    <span className="px-2 py-1 text-xs font-medium rounded-full text-red-600 bg-red-100">
                                        Overdue
                                    </span>
                                )}
                            </div>
                            <div className="flex items-center space-x-2 text-sm text-gray-500">
                                {task.project && (
                                    <div className="flex items-center">
                                        <CalendarIcon className="h-4 w-4 mr-1" />
                                        {task.project.title}
                                    </div>
                                )}
                                <div className="flex items-center">
                                    <ClockIcon className="h-4 w-4 mr-1" />
                                    {new Date(task.due_date).toLocaleDateString()}
                                </div>
                                {task.assigned_to_user && (
                                    <div className="flex items-center">
                                        <UserIcon className="h-4 w-4 mr-1" />
                                        {task.assigned_to_user.first_name} {task.assigned_to_user.last_name}
                                    </div>
                                )}
                            </div>
                        </div>

                        <div className="space-y-4">
                            <div>
                                <h3 className="text-lg font-medium text-gray-900">{task.title}</h3>
                                <p className="text-sm text-gray-600 mt-1">
                                    {task.description}
                                </p>
                            </div>

                            {/* Tags */}
                            {task.tags && task.tags.length > 0 && (
                                <div className="flex flex-wrap gap-2 mt-2">
                                    {task.tags.map((tag, index) => (
                                        <span key={index} className="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded-full">
                                            {tag}
                                        </span>
                                    ))}
                                </div>
                            )}

                            {/* Progress Info */}
                            <div className="mt-4 grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span className="text-gray-500">Estimated:</span>
                                    <span className="font-medium">{task.estimated_hours}h</span>
                                </div>
                                <div>
                                    <span className="text-gray-500">Actual:</span>
                                    <span className="font-medium">{task.actual_hours}h</span>
                                </div>
                            </div>

                            {/* Action Buttons */}
                            <div className="mt-6 flex gap-2">
                                {task.status === 'todo' && isStudent && (
                                    <button
                                        onClick={() => handleStatusUpdate(task.id, 'in_progress')}
                                        className="btn-primary text-sm"
                                    >
                                        Start Task
                                    </button>
                                )}
                                
                                {task.status === 'in_progress' && isStudent && (
                                    <button
                                        onClick={() => handleStatusUpdate(task.id, 'completed')}
                                        className="btn-primary text-sm"
                                    >
                                        Complete Task
                                    </button>
                                )}

                                <Link
                                    to={`/tasks/${task.id}`}
                                    className="btn-secondary text-sm flex-1"
                                >
                                    View Details
                                </Link>
                                
                                {(isSupervisor || isAdmin) && (
                                    <Link
                                        to={`/tasks/${task.id}/edit`}
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

            {filteredTasks.length === 0 && (
                <div className="text-center py-12">
                    <CheckSquareIcon className="h-12 w-12 text-gray-400 mx-auto mb-4" />
                    <h3 className="text-lg font-medium text-gray-900 mb-2">No tasks found</h3>
                    <p className="text-gray-500">
                        {searchTerm ? 'Try adjusting your search terms' : 'No tasks match your current filters'}
                    </p>
                </div>
            )}
        </div>
    );
};

export default Tasks;

import React, { useState, useEffect } from 'react';
import { useAuth } from '../contexts/AuthContext';
import { analyticsAPI } from '../services/api';
import { 
    ChartBarIcon, 
    DocumentArrowDownIcon,
    FunnelIcon,
    CalendarIcon,
    UserGroupIcon,
    CheckCircleIcon
} from '@heroicons/react/24/outline';

const Reports = () => {
    const { user, isAdmin, isSupervisor, isStudent } = useAuth();
    const [reportData, setReportData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [reportType, setReportType] = useState('dashboard');
    const [dateRange, setDateRange] = useState('30');

    useEffect(() => {
        fetchReportData();
    }, [reportType, dateRange]);

    const fetchReportData = async () => {
        try {
            let response;
            
            switch (reportType) {
                case 'dashboard':
                    response = await analyticsAPI.dashboard();
                    break;
                case 'group-performance':
                    response = await analyticsAPI.groupPerformance({ days: dateRange });
                    break;
                case 'individual-performance':
                    response = await analyticsAPI.individualPerformance({ days: dateRange });
                    break;
                case 'project-progress':
                    response = await analyticsAPI.projectProgress({ days: dateRange });
                    break;
                case 'skill-distribution':
                    response = await analyticsAPI.skillDistribution();
                    break;
                default:
                    response = await analyticsAPI.dashboard();
            }
            
            setReportData(response.data);
        } catch (error) {
            console.error('Failed to fetch report data:', error);
        } finally {
            setLoading(false);
        }
    };

    const handleExport = async (type) => {
        try {
            const response = await analyticsAPI.exportData(type);
            const blob = new Blob([JSON.stringify(response.data)], { type: 'application/json' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${type}-report-${new Date().toISOString().split('T')[0]}.json`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        } catch (error) {
            console.error('Failed to export data:', error);
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
                <h1 className="text-2xl font-bold text-gray-900">Reports & Analytics</h1>
                <p className="mt-2 text-gray-600">
                    Comprehensive insights and analytics for your projects and teams
                </p>
            </div>

            {/* Report Controls */}
            <div className="bg-white shadow rounded-lg p-6 mb-8">
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                            Report Type
                        </label>
                        <select
                            value={reportType}
                            onChange={(e) => setReportType(e.target.value)}
                            className="input-field"
                        >
                            <option value="dashboard">Dashboard Overview</option>
                            <option value="group-performance">Group Performance</option>
                            <option value="individual-performance">Individual Performance</option>
                            <option value="project-progress">Project Progress</option>
                            <option value="skill-distribution">Skill Distribution</option>
                        </select>
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                            Date Range
                        </label>
                        <select
                            value={dateRange}
                            onChange={(e) => setDateRange(e.target.value)}
                            className="input-field"
                        >
                            <option value="7">Last 7 days</option>
                            <option value="30">Last 30 days</option>
                            <option value="90">Last 90 days</option>
                            <option value="365">Last year</option>
                        </select>
                    </div>

                    {(isAdmin || isSupervisor) && (
                        <div className="md:col-span-2">
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                Export Data
                            </label>
                            <div className="flex gap-2">
                                <button
                                    onClick={() => handleExport('users')}
                                    className="btn-secondary text-sm flex items-center"
                                >
                                    <DocumentArrowDownIcon className="h-4 w-4 mr-2" />
                                    Users
                                </button>
                                <button
                                    onClick={() => handleExport('projects')}
                                    className="btn-secondary text-sm flex items-center"
                                >
                                    <DocumentArrowDownIcon className="h-4 w-4 mr-2" />
                                    Projects
                                </button>
                                <button
                                    onClick={() => handleExport('evaluations')}
                                    className="btn-secondary text-sm flex items-center"
                                >
                                    <DocumentArrowDownIcon className="h-4 w-4 mr-2" />
                                    Evaluations
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </div>

            {/* Report Content */}
            <div className="space-y-8">
                {reportType === 'dashboard' && (
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        {/* Overview Cards */}
                        <div className="card">
                            <h3 className="text-lg font-medium text-gray-900 mb-4">System Overview</h3>
                            <div className="space-y-4">
                                <div className="flex items-center justify-between">
                                    <span className="text-sm text-gray-500">Total Users</span>
                                    <span className="text-lg font-bold text-gray-900">
                                        {reportData?.users?.total || 0}
                                    </span>
                                </div>
                                <div className="flex items-center justify-between">
                                    <span className="text-sm text-gray-500">Active Projects</span>
                                    <span className="text-lg font-bold text-gray-900">
                                        {reportData?.projects?.total || 0}
                                    </span>
                                </div>
                                <div className="flex items-center justify-between">
                                    <span className="text-sm text-gray-500">Completed Tasks</span>
                                    <span className="text-lg font-bold text-gray-900">
                                        {reportData?.tasks?.completed || 0}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div className="card">
                            <h3 className="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                            <div className="space-y-3">
                                {reportData?.recent_activity?.slice(0, 5).map((activity, index) => (
                                    <div key={index} className="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                        <CheckCircleIcon className="h-5 w-5 text-green-500" />
                                        <div className="flex-1">
                                            <p className="text-sm text-gray-900">{activity.description}</p>
                                            <p className="text-xs text-gray-500">
                                                {new Date(activity.created_at).toLocaleDateString()}
                                            </p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>

                        <div className="card">
                            <h3 className="text-lg font-medium text-gray-900 mb-4">Quick Stats</h3>
                            <div className="space-y-4">
                                <div className="flex items-center justify-between">
                                    <span className="text-sm text-gray-500">Avg. Project Completion</span>
                                    <span className="text-lg font-bold text-green-600">87%</span>
                                </div>
                                <div className="flex items-center justify-between">
                                    <span className="text-sm text-gray-500">On-Time Deliveries</span>
                                    <span className="text-lg font-bold text-blue-600">92%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                )}

                {reportType === 'group-performance' && (
                    <div className="card">
                        <h3 className="text-lg font-medium text-gray-900 mb-4">Group Performance Analysis</h3>
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Group Name
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Members
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Performance Score
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {reportData?.map((group, index) => (
                                        <tr key={index} className={index % 2 === 0 ? 'bg-white' : 'bg-gray-50'}>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {group.group?.name}
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {group.member_count}
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm">
                                                <span className={`inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                                                    group.performance_score >= 80 ? 'bg-green-100 text-green-800' :
                                                    group.performance_score >= 60 ? 'bg-yellow-100 text-yellow-800' :
                                                    'bg-red-100 text-red-800'
                                                }`}>
                                                    {group.performance_score}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm">
                                                <span className={`inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                                                    group.status === 'active' ? 'bg-green-100 text-green-800' :
                                                    group.status === 'completed' ? 'bg-blue-100 text-blue-800' :
                                                    'bg-gray-100 text-gray-800'
                                                }`}>
                                                    {group.status}
                                                </span>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}

                {reportType === 'skill-distribution' && (
                    <div className="card">
                        <h3 className="text-lg font-medium text-gray-900 mb-4">Skill Distribution</h3>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            {reportData?.map((skill, index) => (
                                <div key={index} className="bg-gray-50 p-4 rounded-lg">
                                    <h4 className="text-sm font-medium text-gray-900 mb-2">{skill.skill}</h4>
                                    <div className="space-y-2">
                                        <div className="flex items-center justify-between">
                                            <span className="text-xs text-gray-500">Count</span>
                                            <span className="text-lg font-bold text-blue-600">{skill.count}</span>
                                        </div>
                                        <div className="flex items-center justify-between">
                                            <span className="text-xs text-gray-500">Avg. Proficiency</span>
                                            <span className="text-lg font-bold text-green-600">{skill.average_proficiency}</span>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
};

export default Reports;

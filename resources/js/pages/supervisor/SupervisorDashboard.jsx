import React, { useState, useEffect } from 'react';
import { useAuth } from '../../contexts/AuthContext';
import { analyticsAPI } from '../../services/api';
import { 
    AcademicCapIcon, 
    ChartBarIcon, 
    UserGroupIcon, 
    FolderIcon, 
    ExclamationTriangleIcon,
    ArrowTrendingUpIcon,
    ClockIcon,
    DocumentArrowDownIcon
} from '@heroicons/react/24/outline';

const SupervisorDashboard = () => {
    const { user } = useAuth();
    const [dashboardData, setDashboardData] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchDashboardData();
    }, []);

    const fetchDashboardData = async () => {
        try {
            const response = await analyticsAPI.supervisorAnalytics();
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

    return (
        <div className="px-4 sm:px-6 lg:px-8 py-8">
            <div className="mb-8">
                <h1 className="text-2xl font-bold text-gray-900">Supervisor Dashboard</h1>
                <p className="mt-2 text-gray-600">
                    Overview of your supervised projects and team performance
                </p>
            </div>

            {/* Stats Cards */}
            {dashboardData && (
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
                                        <dd className="text-lg font-medium text-gray-900">{dashboardData.total_projects}</dd>
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
                                        <dd className="text-lg font-medium text-gray-900">{dashboardData.active_projects}</dd>
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
                                        <dt className="text-sm font-medium text-gray-500 truncate">At Risk Projects</dt>
                                        <dd className="text-lg font-medium text-gray-900">{dashboardData.at_risk_projects}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white overflow-hidden shadow rounded-lg">
                        <div className="p-5">
                            <div className="flex items-center">
                                <div className="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                    <ChartBarIcon className="h-6 w-6 text-white" />
                                </div>
                                <div className="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt className="text-sm font-medium text-gray-500 truncate">Recent Evaluations</dt>
                                        <dd className="text-lg font-medium text-gray-900">{dashboardData.recent_evaluations?.length || 0}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            )}

            {/* Project Progress */}
            {dashboardData?.project_completion_trends && (
                <div className="bg-white shadow rounded-lg">
                    <div className="px-4 py-5 sm:p-6">
                        <h3 className="text-lg leading-6 font-medium text-gray-900 mb-4">Project Completion Trends</h3>
                        <div className="space-y-4">
                            {dashboardData.project_completion_trends.map((trend, index) => (
                                <div key={index} className="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 className="text-sm font-medium text-gray-900">{trend.date}</h4>
                                        <p className="text-xs text-gray-500">{trend.project}</p>
                                    </div>
                                    <div className="text-right">
                                        <span className={`text-lg font-bold ${
                                            trend.completion_rate >= 80 ? 'text-green-600' :
                                            trend.completion_rate >= 60 ? 'text-yellow-600' :
                                            'text-red-600'
                                        }`}>
                                            {trend.completion_rate}%
                                        </span>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            )}

            {/* Student Performance Ranking */}
            {dashboardData?.student_performance_ranking && (
                <div className="bg-white shadow rounded-lg">
                    <div className="px-4 py-5 sm:p-6">
                        <h3 className="text-lg leading-6 font-medium text-gray-900 mb-4">Student Performance Ranking</h3>
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Student
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Average Score
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Evaluations
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            GPA
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {dashboardData.student_performance_ranking.map((student, index) => (
                                        <tr key={index} className={index % 2 === 0 ? 'bg-white' : 'bg-gray-50'}>
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <div className="flex items-center">
                                                    <div className="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                                        <span className="text-sm font-medium text-gray-600">
                                                            {student.student.first_name?.[0] || 'U'}
                                                        </span>
                                                    </div>
                                                    <div className="ml-3">
                                                        <div className="text-sm font-medium text-gray-900">{student.student.first_name} {student.student.last_name}</div>
                                                        <div className="text-xs text-gray-500">{student.student.email}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <span className={`inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                                                    student.average_score >= 4 ? 'bg-green-100 text-green-800' :
                                                    student.average_score >= 3 ? 'bg-yellow-100 text-yellow-800' :
                                                    'bg-red-100 text-red-800'
                                                }`}>
                                                    {student.average_score}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {student.evaluations_count}
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {student.student.gpa}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            )}

            {/* Group Effectiveness */}
            {dashboardData?.group_effectiveness && (
                <div className="bg-white shadow rounded-lg">
                    <div className="px-4 py-5 sm:p-6">
                        <h3 className="text-lg leading-6 font-medium text-gray-900 mb-4">Group Effectiveness Analysis</h3>
                        <div className="grid grid-cols-1 gap-6 lg:grid-cols-2">
                            {dashboardData.group_effectiveness.map((group, index) => (
                                <div key={index} className="border border-gray-200 rounded-lg p-4">
                                    <div className="flex items-center justify-between mb-4">
                                        <h4 className="text-lg font-medium text-gray-900">{group.project.title}</h4>
                                        <span className={`inline-flex px-3 py-1 text-sm font-semibold rounded-full ${
                                            group.effectiveness_score >= 80 ? 'bg-green-100 text-green-800' :
                                            group.effectiveness_score >= 60 ? 'bg-yellow-100 text-yellow-800' :
                                            'bg-red-100 text-red-800'
                                        }`}>
                                            Score: {group.effectiveness_score}
                                        </span>
                                    </div>
                                    <div className="space-y-2">
                                        <div className="flex items-center justify-between text-sm">
                                            <span className="text-gray-500">Group:</span>
                                            <span className="font-medium text-gray-900">{group.group.name}</span>
                                        </div>
                                        <div className="flex items-center justify-between text-sm">
                                            <span className="text-gray-500">Members:</span>
                                            <span className="font-medium text-gray-900">{group.member_count}</span>
                                        </div>
                                        <div className="flex items-center justify-between text-sm">
                                            <span className="text-gray-500">Status:</span>
                                            <span className={`font-medium ${
                                                group.project.status === 'completed' ? 'text-green-600' :
                                                group.project.status === 'in_progress' ? 'text-blue-600' :
                                                'text-gray-600'
                                            }`}>
                                                {group.project.status}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            )}

            {/* Evaluation Insights */}
            {dashboardData?.evaluation_insights && (
                <div className="bg-white shadow rounded-lg">
                    <div className="px-4 py-5 sm:p-6">
                        <h3 className="text-lg leading-6 font-medium text-gray-900 mb-4">Evaluation Insights</h3>
                        
                        <div className="grid grid-cols-1 gap-6 lg:grid-cols-2">
                            <div className="space-y-4">
                                <h4 className="text-md font-medium text-gray-900">Average Scores</h4>
                                <div className="space-y-2">
                                    {Object.entries(dashboardData.evaluation_insights.average_scores).map(([skill, score]) => (
                                        <div key={skill} className="flex items-center justify-between">
                                            <span className="text-sm text-gray-500 capitalize">{skill.replace('_', ' ')}</span>
                                            <div className="flex items-center">
                                                <div className="w-32 bg-gray-200 rounded-full h-2">
                                                    <div 
                                                        className="bg-blue-600 h-2 rounded-full"
                                                        style={{ width: `${(score / 5) * 100}%` }}
                                                    ></div>
                                                </div>
                                                <span className="ml-2 text-sm font-medium text-gray-900">{score.toFixed(2)}</span>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            <div className="space-y-4">
                                <h4 className="text-md font-medium text-gray-900">Low Performers</h4>
                                <div className="space-y-2">
                                    {dashboardData.evaluation_insights.low_performers.map((performer, index) => (
                                        <div key={index} className="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                                            <div className="flex items-center">
                                                <ExclamationTriangleIcon className="h-5 w-5 text-red-600 mr-2" />
                                                <div>
                                                    <div className="text-sm font-medium text-gray-900">{performer.user.first_name} {performer.user.last_name}</div>
                                                    <div className="text-xs text-gray-500">{performer.user.email}</div>
                                                </div>
                                            </div>
                                            <div className="text-right">
                                                <span className="text-lg font-bold text-red-600">{performer.average_score}</span>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            )}

            {/* Export Options */}
            <div className="bg-white shadow rounded-lg">
                <div className="px-4 py-5 sm:p-6">
                    <h3 className="text-lg leading-6 font-medium text-gray-900 mb-4">Export Data</h3>
                    <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <button className="flex items-center justify-center p-4 border border-gray-300 rounded-lg hover:bg-gray-50">
                            <DocumentArrowDownIcon className="h-6 w-6 text-gray-600 mr-2" />
                            <span className="text-sm font-medium text-gray-900">Export Users</span>
                        </button>
                        <button className="flex items-center justify-center p-4 border border-gray-300 rounded-lg hover:bg-gray-50">
                            <DocumentArrowDownIcon className="h-6 w-6 text-gray-600 mr-2" />
                            <span className="text-sm font-medium text-gray-900">Export Projects</span>
                        </button>
                        <button className="flex items-center justify-center p-4 border border-gray-300 rounded-lg hover:bg-gray-50">
                            <DocumentArrowDownIcon className="h-6 w-6 text-gray-600 mr-2" />
                            <span className="text-sm font-medium text-gray-900">Export Evaluations</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default SupervisorDashboard;

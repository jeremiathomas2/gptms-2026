@extends('layouts.app')

@section('title', 'Analytics Dashboard - Supervisor')

@section('content')
<div class="space-y-6" id="analytics-dashboard">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Analytics Dashboard</h1>
            <p class="text-gray-500">Comprehensive data analysis and insights for your supervised projects</p>
        </div>
        <div class="flex space-x-3">
            <select id="timeRange" class="px-4 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="7">Last 7 days</option>
                <option value="30" selected>Last 30 days</option>
                <option value="90">Last 3 months</option>
                <option value="180">Last 6 months</option>
            </select>
            <button onclick="exportReport()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Export Report</span>
            </button>
            <button onclick="refreshData()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m0 0l3 9m-3-9v12m0 0l-3-9m3 9H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Refresh</span>
            </button>
        </div>
    </div>

    <!-- Loading State -->
    <div id="loadingState" class="hidden">
        <div class="flex justify-center items-center py-12">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <span class="ml-3 text-gray-600">Loading analytics data...</span>
        </div>
    </div>

    <!-- Error State -->
    <div id="errorState" class="hidden">
        <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
            <svg class="w-12 h-12 text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-medium text-red-800 mb-2">Unable to Load Analytics</h3>
            <p class="text-red-600 mb-4">There was an error loading the analytics data. Please try again.</p>
            <button onclick="refreshData()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Retry</button>
        </div>
    </div>

    <!-- Analytics Content -->
    <div id="analyticsContent">
        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Projects</p>
                        <p class="text-2xl font-bold text-gray-900" id="totalProjects">-</p>
                        <div class="flex items-center space-x-2 mt-2">
                            <span class="text-sm text-gray-500">Under your supervision</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Active Projects</p>
                        <p class="text-2xl font-bold text-gray-900" id="activeProjects">-</p>
                        <div class="flex items-center space-x-2 mt-2">
                            <span class="text-sm text-green-600" id="activeProjectsTrend">-</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Students</p>
                        <p class="text-2xl font-bold text-gray-900" id="totalStudents">-</p>
                        <div class="flex items-center space-x-2 mt-2">
                            <span class="text-sm text-gray-500" id="studentGroupsTrend">-</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Completion Rate</p>
                        <p class="text-2xl font-bold text-gray-900" id="completionRate">-</p>
                        <div class="flex items-center space-x-2 mt-2">
                            <span class="text-sm text-gray-500" id="completionTrend">-</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Project Performance Chart -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Project Performance</h3>
                    <button class="text-sm text-blue-600 hover:text-blue-800" onclick="viewAllProjects()">View All</button>
                </div>
                <div class="h-64" id="projectPerformanceChart">
                    <canvas id="projectChart"></canvas>
                </div>
            </div>

            <!-- Student Performance Distribution -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Student Performance</h3>
                    <button class="text-sm text-blue-600 hover:text-blue-800" onclick="viewAllStudents()">View All</button>
                </div>
                <div class="h-64" id="studentPerformanceChart">
                    <canvas id="studentChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Detailed Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Projects Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Project Status</h3>
                        <span class="text-sm text-gray-500" id="projectsCount">-</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="projectsTableBody">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                    Loading projects...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

                    </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                    <button class="text-sm text-blue-600 hover:text-blue-800" onclick="viewAllActivity()">View All</button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="activityTableBody">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                Loading activity...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let analyticsData = null;
let projectChart = null;
let studentChart = null;

// Initialize dashboard
document.addEventListener('DOMContentLoaded', function() {
    loadAnalyticsData();
    
    // Auto-refresh every 5 minutes
    setInterval(loadAnalyticsData, 300000);
});

// Load analytics data from API
async function loadAnalyticsData() {
    showLoading();
    hideError();
    
    try {
        const response = await fetch('/api/analytics/dashboard');
        
        if (!response.ok) {
            throw new Error('Failed to fetch analytics data');
        }
        
        analyticsData = await response.json();
        
        if (analyticsData.error) {
            showError(analyticsData.error);
            return;
        }
        
        updateDashboard();
        hideLoading();
        
    } catch (error) {
        console.error('Error loading analytics:', error);
        showError('Failed to load analytics data. Please try again.');
        hideLoading();
    }
}

// Update dashboard with data
function updateDashboard() {
    if (!analyticsData) return;
    
    // Update key metrics
    updateKeyMetrics();
    
    // Update tables
    updateProjectsTable();
    updateActivityTable();
    
    // Update charts
    updateCharts();
}

// Update key metrics
function updateKeyMetrics() {
    const metrics = analyticsData.key_metrics || {};
    
    document.getElementById('totalStudents').textContent = `${metrics.total_students || 0}`;
    document.getElementById('activeProjects').textContent = `${metrics.at_risk_projects || 0}`;
    document.getElementById('completionTrend').textContent = `${metrics.completed_projects || 0} completed`;
    
    // Update trends
    document.getElementById('activeProjectsTrend').textContent = `${metrics.at_risk_projects || 0} at risk`;
    document.getElementById('studentGroupsTrend').textContent = `${metrics.total_groups || 0} groups`;
    document.getElementById('completionTrend').textContent = 
        `${metrics.completed_projects || 0} completed`;
}

// Update projects table
function updateProjectsTable() {
    const tbody = document.getElementById('projectsTableBody');
    const projects = analyticsData.project_performance || [];
    
    document.getElementById('projectsCount').textContent = `${projects.length} projects`;
    
    if (projects.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                    No projects found
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = projects.slice(0, 5).map(project => `
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
                <div>
                    <div class="text-sm font-medium text-gray-900">${project.name}</div>
                    <div class="text-xs text-gray-500">${project.group_name || 'No group'}</div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: ${project.progress_percentage}%"></div>
                    </div>
                    <span class="text-sm text-gray-600">${project.progress_percentage}%</span>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    ${project.status === 'completed' ? 'bg-green-100 text-green-800' : 
                      project.status === 'active' ? 'bg-blue-100 text-blue-800' : 
                      'bg-gray-100 text-gray-800'}">
                    ${project.status}
                </span>
            </td>
        </tr>
    `).join('');
}


// Update activity table
function updateActivityTable() {
    const tbody = document.getElementById('activityTableBody');
    const activities = analyticsData.activity_summary?.recent_activities || [];
    
    if (activities.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                    No recent activity
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = activities.map(activity => `
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">${activity.user_name}</div>
            </td>
            <td class="px-6 py-4">
                <div class="text-sm text-gray-900">${activity.action}</div>
                <div class="text-xs text-gray-500">${activity.description}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${activity.created_at}
            </td>
        </tr>
    `).join('');
}

// Update charts
function updateCharts() {
    updateProjectChart();
    updateStudentChart();
}

// Update project chart
function updateProjectChart() {
    const ctx = document.getElementById('projectChart').getContext('2d');
    const projects = analyticsData.project_performance || [];
    
    if (projectChart) {
        projectChart.destroy();
    }
    
    projectChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: projects.slice(0, 5).map(p => p.name),
            datasets: [{
                label: 'Progress %',
                data: projects.slice(0, 5).map(p => p.progress_percentage),
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
}

// Update student chart
function updateStudentChart() {
    const ctx = document.getElementById('studentChart').getContext('2d');
    const students = analyticsData.student_performance || [];
    
    if (studentChart) {
        studentChart.destroy();
    }
    
    // Create performance distribution
    const performanceRanges = {
        'Excellent (90-100)': 0,
        'Good (70-89)': 0,
        'Average (50-69)': 0,
        'Poor (0-49)': 0
    };
    
    students.forEach(student => {
        const score = student.performance_score;
        if (score >= 90) performanceRanges['Excellent (90-100)']++;
        else if (score >= 70) performanceRanges['Good (70-89)']++;
        else if (score >= 50) performanceRanges['Average (50-69)']++;
        else performanceRanges['Poor (0-49)']++;
    });
    
    studentChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(performanceRanges),
            datasets: [{
                data: Object.values(performanceRanges),
                backgroundColor: [
                    'rgba(34, 197, 94, 0.5)',
                    'rgba(59, 130, 246, 0.5)',
                    'rgba(251, 191, 36, 0.5)',
                    'rgba(239, 68, 68, 0.5)'
                ],
                borderColor: [
                    'rgba(34, 197, 94, 1)',
                    'rgba(59, 130, 246, 1)',
                    'rgba(251, 191, 36, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

// Utility functions
function showLoading() {
    document.getElementById('loadingState').classList.remove('hidden');
    document.getElementById('analyticsContent').classList.add('hidden');
}

function hideLoading() {
    document.getElementById('loadingState').classList.add('hidden');
    document.getElementById('analyticsContent').classList.remove('hidden');
}

function showError(message) {
    document.getElementById('errorState').classList.remove('hidden');
    document.getElementById('analyticsContent').classList.add('hidden');
    
    const errorDiv = document.getElementById('errorState');
    errorDiv.querySelector('p').textContent = message;
}

function hideError() {
    document.getElementById('errorState').classList.add('hidden');
}

function refreshData() {
    loadAnalyticsData();
}

function exportReport() {
    if (!analyticsData) {
        alert('No data available to export');
        return;
    }
    
    // Create CSV content
    let csv = 'Supervisor Analytics Report\n\n';
    csv += 'Key Metrics\n';
    csv += 'Metric,Value\n';
    
    const metrics = analyticsData.key_metrics || {};
    csv += `Total Projects,${metrics.total_projects || 0}\n`;
    csv += `Active Projects,${metrics.active_projects || 0}\n`;
    csv += `Completed Projects,${metrics.completed_projects || 0}\n`;
    csv += `Total Students,${metrics.total_students || 0}\n`;
    csv += `Completion Rate,${metrics.completion_rate || 0}%\n`;
    
    // Add project data
    csv += '\nProjects\n';
    csv += 'Name,Progress,Status,Group\n';
    const projects = analyticsData.project_performance || [];
    projects.forEach(project => {
        csv += `"${project.name}",${project.progress_percentage}%,${project.status},"${project.group_name || ''}"\n`;
    });
    
    // Download CSV
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'supervisor_analytics_' + new Date().toISOString().split('T')[0] + '.csv';
    a.click();
    window.URL.revokeObjectURL(url);
}

// Navigation functions
function viewAllProjects() {
    window.location.href = '/projects';
}

function viewAllStudents() {
    window.location.href = '/users';
}

function viewAllActivity() {
    window.location.href = '/admin/logs';
}

// Time range change handler
document.getElementById('timeRange')?.addEventListener('change', function() {
    loadAnalyticsData();
});
</script>
@endsection

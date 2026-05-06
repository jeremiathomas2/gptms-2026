@extends('layouts.app')

@section('title', 'Reports - GPTFMS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Reports</h1>
            <p class="text-gray-500">Generate and manage system reports</p>
        </div>
        <div class="flex space-x-3">
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Schedule Report</span>
            </button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Generate Report</span>
            </button>
        </div>
    </div>

    <!-- Report Categories -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-500">Analytics</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Analytics Report</h3>
            <p class="text-sm text-gray-600 mt-2">Comprehensive analytics and performance metrics</p>
            <div class="mt-4 flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Last generated: 2 days ago
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-500">Users</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">User Activity Report</h3>
            <p class="text-sm text-gray-600 mt-2">User engagement and activity statistics</p>
            <div class="mt-4 flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Last generated: 1 week ago
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-500">Projects</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Project Summary Report</h3>
            <p class="text-sm text-gray-600 mt-2">Project status and completion overview</p>
            <div class="mt-4 flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Last generated: 3 days ago
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-500">Financial</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Financial Report</h3>
            <p class="text-sm text-gray-600 mt-2">Budget and expense analysis</p>
            <div class="mt-4 flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Last generated: 1 month ago
            </div>
        </div>
    </div>

    <!-- Recent Reports -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Recent Reports</h3>
                <div class="flex space-x-2">
                    <select class="text-sm border border-gray-300 rounded px-3 py-1">
                        <option>All Types</option>
                        <option>Analytics</option>
                        <option>Users</option>
                        <option>Projects</option>
                        <option>Financial</option>
                    </select>
                    <select class="text-sm border border-gray-300 rounded px-3 py-1">
                        <option>All Time</option>
                        <option>Last 7 days</option>
                        <option>Last 30 days</option>
                        <option>Last 3 months</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Generated By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Generated At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Monthly Analytics Report</div>
                                    <div class="text-sm text-gray-500">January 2024</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Analytics</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img src="https://picsum.photos/seed/user1/32/32.jpg" alt="" class="w-6 h-6 rounded-full mr-2">
                                <div class="text-sm text-gray-900">John Doe</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Feb 1, 2024 - 10:30 AM</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">View</button>
                                <button class="text-gray-600 hover:text-gray-900">Download</button>
                                <button class="text-red-600 hover:text-red-900">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">User Engagement Report</div>
                                    <div class="text-sm text-gray-500">Q4 2023</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Users</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img src="https://picsum.photos/seed/user2/32/32.jpg" alt="" class="w-6 h-6 rounded-full mr-2">
                                <div class="text-sm text-gray-900">Jane Smith</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jan 28, 2024 - 2:15 PM</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">View</button>
                                <button class="text-gray-600 hover:text-gray-900">Download</button>
                                <button class="text-red-600 hover:text-red-900">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Project Status Report</div>
                                    <div class="text-sm text-gray-500">January 2024</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Projects</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img src="https://picsum.photos/seed/user3/32/32.jpg" alt="" class="w-6 h-6 rounded-full mr-2">
                                <div class="text-sm text-gray-900">Mike Johnson</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jan 25, 2024 - 4:45 PM</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">View</button>
                                <button class="text-gray-600 hover:text-gray-900">Download</button>
                                <button class="text-red-600 hover:text-red-900">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2zm0-8c1.11 0 2 .89 2 2s-.89 2-2 2-2-.89-2-2 2zM8 16v-2a4 4 0 01-4-4H4a4 4 0 00-4 4v2a2 2 0 002 2h8a2 2 0 002-2z"/>
                                </svg>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Financial Summary</div>
                                    <div class="text-sm text-gray-500">Q4 2023</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Financial</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img src="https://picsum.photos/seed/user4/32/32.jpg" alt="" class="w-6 h-6 rounded-full mr-2">
                                <div class="text-sm text-gray-900">Sarah Davis</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jan 20, 2024 - 11:00 AM</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">View</button>
                                <button class="text-gray-600 hover:text-gray-900">Download</button>
                                <button class="text-red-600 hover:text-red-900">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Weekly Analytics Report</div>
                                    <div class="text-sm text-gray-500">Week 4 - January</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Analytics</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img src="https://picsum.photos/seed/user5/32/32.jpg" alt="" class="w-6 h-6 rounded-full mr-2">
                                <div class="text-sm text-gray-900">Bob Wilson</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jan 15, 2024 - 9:00 AM</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Processing</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">View</button>
                                <button class="text-gray-400 hover:text-gray-900" disabled>Download</button>
                                <button class="text-red-600 hover:text-red-900">Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Report Generation Modal -->
    <div id="generate-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Generate New Report</h3>
            </div>
            <div class="p-6">
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option>Select report type</option>
                            <option>Analytics Report</option>
                            <option>User Activity Report</option>
                            <option>Project Summary Report</option>
                            <option>Financial Report</option>
                            <option>Custom Report</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Report Period</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                            <option>Last 3 months</option>
                            <option>Last 6 months</option>
                            <option>Last year</option>
                            <option>Custom range</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="format" value="pdf" class="mr-2" checked>
                                <span class="text-sm">PDF</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="format" value="excel" class="mr-2">
                                <span class="text-sm">Excel</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="format" value="csv" class="mr-2">
                                <span class="text-sm">CSV</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Report</label>
                        <input type="email" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Enter email address (optional)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Additional Options</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-2" checked>
                                <span class="text-sm">Include charts and graphs</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-2">
                                <span class="text-sm">Include detailed breakdown</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-2">
                                <span class="text-sm">Include recommendations</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-end space-x-3">
                <button onclick="closeGenerateModal()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Generate Report</button>
            </div>
        </div>
    </div>
</div>

<script>
function openGenerateModal() {
    document.getElementById('generate-modal').classList.remove('hidden');
}

function closeGenerateModal() {
    document.getElementById('generate-modal').classList.add('hidden');
}

// Generate report function
function generateReport() {
    const reportType = document.querySelector('select[name="report_type"]').value;
    const reportPeriod = document.querySelector('select[name="report_period"]').value;
    const format = document.querySelector('input[name="format"]:checked').value;
    const email = document.querySelector('input[type="email"]').value;
    
    if (!reportType || reportType === 'Select report type') {
        showNotification('Please select a report type', 'error');
        return;
    }
    
    // Show loading state
    const generateBtn = document.querySelector('button[onclick="generateReport()"]');
    generateBtn.disabled = true;
    generateBtn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m0 0l3 9m-3-9v12m0 0l-3-9m3 9H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Generating...';
    
    // Simulate report generation
    setTimeout(() => {
        // Here you would normally make an AJAX call to the server
        // For demo purposes, we'll simulate the generation
        console.log('Generating report:', {
            type: reportType,
            period: reportPeriod,
            format: format,
            email: email
        });
        
        // Reset button
        generateBtn.disabled = false;
        generateBtn.innerHTML = 'Generate Report';
        
        // Show success message
        showNotification(`Report "${reportType}" generated successfully!`, 'success');
        
        // Close modal
        closeGenerateModal();
        
        // In a real implementation, you would redirect or download the file
        if (format === 'pdf') {
            console.log('Downloading PDF report...');
        } else if (format === 'excel') {
            console.log('Downloading Excel report...');
        } else if (format === 'csv') {
            console.log('Downloading CSV report...');
        }
        
    }, 2000);
}

function scheduleReport() {
    openGenerateModal();
    // Pre-select scheduling options
    const reportType = document.querySelector('select[name="report_type"]');
    if (reportType) {
        reportType.value = 'scheduled_report';
    }
}

function downloadReport(reportId) {
    console.log('Downloading report:', reportId);
    showNotification('Report download started...', 'info');
    
    // In a real implementation, this would trigger a file download
    setTimeout(() => {
        showNotification('Report downloaded successfully!', 'success');
    }, 1000);
}

function deleteReport(reportId) {
    if (confirm('Are you sure you want to delete this report? This action cannot be undone.')) {
        console.log('Deleting report:', reportId);
        showNotification('Report deleted successfully!', 'success');
        
        // In a real implementation, this would make an API call to delete the report
        // Then remove the row from the table
        const row = document.querySelector(`[data-report-id="${reportId}"]`);
        if (row) {
            row.remove();
        }
    }
}

// Close modal when clicking outside
document.getElementById('generate-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeGenerateModal();
    }
});

// Add click handlers to report cards
document.addEventListener('DOMContentLoaded', function() {
    const reportCards = document.querySelectorAll('.cursor-pointer');
    reportCards.forEach(card => {
        card.addEventListener('click', function() {
            // Handle click on report cards
            const reportTitle = this.querySelector('h3')?.textContent;
            console.log('Report card clicked:', reportTitle);
        });
    });
});
</script>
@endsection

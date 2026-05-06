@extends('layouts.app')

@section('title', 'Kanban Board - Project Management')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kanban Board</h1>
            <p class="text-gray-500">Manage tasks and project workflow visually</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="openAddTaskModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="whitespace-nowrap">Add Task</span>
            </button>
            <button onclick="refreshKanban()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m0 0l3 9m-3-9v12m0 0l-3-9m3 9H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="whitespace-nowrap">Refresh</span>
            </button>
        </div>
    </div>

    <!-- Kanban Board -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <!-- Board Filters -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <select class="border border-gray-300 rounded-lg px-3 py-2" onchange="filterByProject(this.value)">
                        <option value="all">All Projects</option>
                        <option value="project1">Project Alpha</option>
                        <option value="project2">Project Beta</option>
                        <option value="project3">Project Gamma</option>
                    </select>
                    <select class="border border-gray-300 rounded-lg px-3 py-2" onchange="filterByAssignee(this.value)">
                        <option value="all">All Assignees</option>
                        <option value="me">My Tasks</option>
                        <option value="unassigned">Unassigned</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="toggleView()" class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Kanban Columns -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6" id="kanban-board">
                <!-- To Do Column -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900">To Do</h3>
                        <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full" id="todo-count">0</span>
                    </div>
                    <div class="space-y-3 min-h-[400px]" id="todo-column" ondrop="drop(event, 'todo')" ondragover="allowDrop(event)">
                        <!-- Sample Tasks -->
                        <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-200 cursor-move hover:shadow-md transition-shadow" draggable="true" ondragstart="drag(event)" id="task-1">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Feature</span>
                                <span class="text-xs text-gray-500">High</span>
                            </div>
                            <h4 class="font-medium text-gray-900 mb-2">Implement user authentication</h4>
                            <p class="text-sm text-gray-600 mb-3">Add login and registration functionality with JWT tokens</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <img src="https://picsum.photos/seed/user1/24/24.jpg" alt="User" class="w-6 h-6 rounded-full">
                                    <span class="text-xs text-gray-500">John Doe</span>
                                </div>
                                <span class="text-xs text-gray-400">2 days</span>
                            </div>
                        </div>
                        
                        <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-200 cursor-move hover:shadow-md transition-shadow" draggable="true" ondragstart="drag(event)" id="task-2">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Bug</span>
                                <span class="text-xs text-gray-500">Medium</span>
                            </div>
                            <h4 class="font-medium text-gray-900 mb-2">Fix navigation menu issue</h4>
                            <p class="text-sm text-gray-600 mb-3">Mobile menu not closing properly after selection</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <img src="https://picsum.photos/seed/user2/24/24.jpg" alt="User" class="w-6 h-6 rounded-full">
                                    <span class="text-xs text-gray-500">Jane Smith</span>
                                </div>
                                <span class="text-xs text-gray-400">1 day</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- In Progress Column -->
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-blue-900">In Progress</h3>
                        <span class="bg-blue-200 text-blue-700 text-xs px-2 py-1 rounded-full" id="progress-count">0</span>
                    </div>
                    <div class="space-y-3 min-h-[400px]" id="progress-column" ondrop="drop(event, 'progress')" ondragover="allowDrop(event)">
                        <!-- Sample Tasks -->
                        <div class="bg-white p-3 rounded-lg shadow-sm border border-blue-200 cursor-move hover:shadow-md transition-shadow" draggable="true" ondragstart="drag(event)" id="task-3">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded">Enhancement</span>
                                <span class="text-xs text-gray-500">Low</span>
                            </div>
                            <h4 class="font-medium text-gray-900 mb-2">Optimize database queries</h4>
                            <p class="text-sm text-gray-600 mb-3">Improve performance of user dashboard loading</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <img src="https://picsum.photos/seed/user3/24/24.jpg" alt="User" class="w-6 h-6 rounded-full">
                                    <span class="text-xs text-gray-500">Mike Johnson</span>
                                </div>
                                <span class="text-xs text-gray-400">3 days</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Column -->
                <div class="bg-yellow-50 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-yellow-900">Review</h3>
                        <span class="bg-yellow-200 text-yellow-700 text-xs px-2 py-1 rounded-full" id="review-count">0</span>
                    </div>
                    <div class="space-y-3 min-h-[400px]" id="review-column" ondrop="drop(event, 'review')" ondragover="allowDrop(event)">
                        <!-- Sample Tasks -->
                        <div class="bg-white p-3 rounded-lg shadow-sm border border-yellow-200 cursor-move hover:shadow-md transition-shadow" draggable="true" ondragstart="drag(event)" id="task-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Feature</span>
                                <span class="text-xs text-gray-500">High</span>
                            </div>
                            <h4 class="font-medium text-gray-900 mb-2">Add email notifications</h4>
                            <p class="text-sm text-gray-600 mb-3">Implement email alerts for task assignments</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <img src="https://picsum.photos/seed/user4/24/24.jpg" alt="User" class="w-6 h-6 rounded-full">
                                    <span class="text-xs text-gray-500">Sarah Wilson</span>
                                </div>
                                <span class="text-xs text-gray-400">1 day</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Done Column -->
                <div class="bg-green-50 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-green-900">Done</h3>
                        <span class="bg-green-200 text-green-700 text-xs px-2 py-1 rounded-full" id="done-count">0</span>
                    </div>
                    <div class="space-y-3 min-h-[400px]" id="done-column" ondrop="drop(event, 'done')" ondragover="allowDrop(event)">
                        <!-- Sample Tasks -->
                        <div class="bg-white p-3 rounded-lg shadow-sm border border-green-200 cursor-move hover:shadow-md transition-shadow" draggable="true" ondragstart="drag(event)" id="task-5">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">Documentation</span>
                                <span class="text-xs text-gray-500">Low</span>
                            </div>
                            <h4 class="font-medium text-gray-900 mb-2">Update API documentation</h4>
                            <p class="text-sm text-gray-600 mb-3">Add new endpoints to developer docs</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <img src="https://picsum.photos/seed/user5/24/24.jpg" alt="User" class="w-6 h-6 rounded-full">
                                    <span class="text-xs text-gray-500">Tom Brown</span>
                                </div>
                                <span class="text-xs text-gray-400">Completed</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Task Modal -->
<div id="addTaskModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Add New Task</h3>
        <form id="addTaskForm">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Task Title</label>
                    <input type="text" name="title" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="feature">Feature</option>
                            <option value="bug">Bug</option>
                            <option value="enhancement">Enhancement</option>
                            <option value="documentation">Documentation</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                        <select name="priority" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Assignee</label>
                    <select name="assignee" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">Unassigned</option>
                        <option value="user1">John Doe</option>
                        <option value="user2">Jane Smith</option>
                        <option value="user3">Mike Johnson</option>
                        <option value="user4">Sarah Wilson</option>
                        <option value="user5">Tom Brown</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeAddTaskModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add Task</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
let draggedTask = null;

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    draggedTask = ev.target;
    ev.dataTransfer.effectAllowed = 'move';
}

function drop(ev, column) {
    ev.preventDefault();
    if (draggedTask) {
        const targetColumn = document.getElementById(column + '-column');
        targetColumn.appendChild(draggedTask);
        updateTaskCounts();
        
        // Show notification
        showNotification('Task moved successfully!', 'success');
        
        // In a real app, you would save this change to the backend
        console.log('Task moved to:', column);
    }
}

function updateTaskCounts() {
    const todoCount = document.getElementById('todo-column').children.length;
    const progressCount = document.getElementById('progress-column').children.length;
    const reviewCount = document.getElementById('review-column').children.length;
    const doneCount = document.getElementById('done-column').children.length;
    
    document.getElementById('todo-count').textContent = todoCount;
    document.getElementById('progress-count').textContent = progressCount;
    document.getElementById('review-count').textContent = reviewCount;
    document.getElementById('done-count').textContent = doneCount;
}

function openAddTaskModal() {
    document.getElementById('addTaskModal').classList.remove('hidden');
}

function closeAddTaskModal() {
    document.getElementById('addTaskModal').classList.add('hidden');
    document.getElementById('addTaskForm').reset();
}

function refreshKanban() {
    // In a real app, this would fetch fresh data from the backend
    showNotification('Kanban board refreshed!', 'info');
}

function filterByProject(project) {
    // In a real app, this would filter tasks by project
    console.log('Filter by project:', project);
}

function filterByAssignee(assignee) {
    // In a real app, this would filter tasks by assignee
    console.log('Filter by assignee:', assignee);
}

function toggleView() {
    // In a real app, this would toggle between different views
    console.log('Toggle view');
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Initialize task counts on page load
document.addEventListener('DOMContentLoaded', function() {
    updateTaskCounts();
});

// Handle form submission
document.getElementById('addTaskForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // In a real app, this would save the task to the backend
    const formData = new FormData(this);
    const taskData = Object.fromEntries(formData);
    
    console.log('New task:', taskData);
    
    // Close modal and show success message
    closeAddTaskModal();
    showNotification('Task added successfully!', 'success');
});
</script>
@endsection

import axios from 'axios';

const API_BASE_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api';

// Create axios instance
const api = axios.create({
    baseURL: API_BASE_URL,
    headers: {
        'Content-Type': 'application/json',
    },
});

// Add request interceptor to include token
api.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Add response interceptor to handle errors
api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            localStorage.removeItem('token');
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);

// Authentication API
export const authAPI = {
    login: (credentials) => api.post('/auth/login', credentials),
    register: (userData) => api.post('/auth/register', userData),
    logout: () => api.post('/auth/logout'),
    getProfile: () => api.get('/auth/profile'),
    updateProfile: (data) => api.put('/auth/profile', data),
    changePassword: (data) => api.post('/auth/change-password', data),
    forgotPassword: (data) => api.post('/auth/forgot-password', data),
    verifyEmail: (data) => api.post('/auth/verify-email', data),
};

// Groups API
export const groupAPI = {
    getAll: (params) => api.get('/groups', { params }),
    getById: (id) => api.get(`/groups/${id}`),
    create: (data) => api.post('/groups', data),
    update: (id, data) => api.put(`/groups/${id}`, data),
    delete: (id) => api.delete(`/groups/${id}`),
    myGroups: () => api.get('/groups/my-groups'),
    joinGroup: (id) => api.post(`/groups/${id}/join`),
    leaveGroup: (id) => api.post(`/groups/${id}/leave`),
    inviteMember: (id, data) => api.post(`/groups/${id}/invite`, data),
    removeMember: (id, userId) => api.post(`/groups/${id}/remove/${userId}`),
    autoFormGroups: (data) => api.post('/groups/auto-form', data),
    getAnalytics: (id) => api.get(`/groups/${id}/analytics`),
    assignRole: (id, data) => api.post(`/groups/${id}/assign-role`, data),
    supervisorGroups: () => api.get('/supervisor/groups'),
};

// Projects API
export const projectAPI = {
    getAll: (params) => api.get('/projects', { params }),
    getById: (id) => api.get(`/projects/${id}`),
    create: (data) => api.post('/projects', data),
    update: (id, data) => api.put(`/projects/${id}`, data),
    delete: (id) => api.delete(`/projects/${id}`),
    myProjects: () => api.get('/projects/my-projects'),
    supervisedProjects: () => api.get('/projects/supervised'),
    assignGroup: (id, data) => api.post(`/projects/${id}/assign-group`, data),
    updateProgress: (id, data) => api.post(`/projects/${id}/update-progress`, data),
    getMilestones: (id) => api.get(`/projects/${id}/milestones`),
    createMilestone: (id, data) => api.post(`/projects/${id}/milestones`, data),
    updateMilestone: (id, milestoneId, data) => api.put(`/projects/${id}/milestones/${milestoneId}`, data),
    deleteMilestone: (id, milestoneId) => api.delete(`/projects/${id}/milestones/${milestoneId}`),
    provideFeedback: (id, data) => api.post(`/projects/${id}/provide-feedback`, data),
};

// Tasks API
export const taskAPI = {
    getAll: (params) => api.get('/tasks', { params }),
    getById: (id) => api.get(`/tasks/${id}`),
    create: (data) => api.post('/tasks', data),
    update: (id, data) => api.put(`/tasks/${id}`, data),
    delete: (id) => api.delete(`/tasks/${id}`),
    projectTasks: (projectId) => api.get(`/projects/${projectId}/tasks`),
    myTasks: () => api.get('/tasks/my-tasks'),
    assignTask: (id, data) => api.post(`/tasks/${id}/assign`, data),
    updateStatus: (id, data) => api.post(`/tasks/${id}/update-status`, data),
    addComment: (id, data) => api.post(`/tasks/${id}/add-comment`, data),
    getComments: (id) => api.get(`/tasks/${id}/comments`),
};

// Messages API
export const messageAPI = {
    getAll: (params) => api.get('/messages', { params }),
    getById: (id) => api.get(`/messages/${id}`),
    create: (data) => api.post('/messages', data),
    conversations: () => api.get('/messages/conversations'),
    conversation: (userId) => api.get(`/messages/conversation/${userId}`),
    sendMessage: (data) => api.post('/messages/send', data),
    groupMessages: (groupId) => api.get(`/messages/group/${groupId}`),
    sendGroupMessage: (groupId, data) => api.post(`/messages/group/${groupId}/send`, data),
    markAsRead: (id) => api.post(`/messages/${id}/mark-read`),
};

// Notifications API
export const notificationAPI = {
    getAll: (params) => api.get('/notifications', { params }),
    getById: (id) => api.get(`/notifications/${id}`),
    create: (data) => api.post('/notifications', data),
    update: (id, data) => api.put(`/notifications/${id}`, data),
    delete: (id) => api.delete(`/notifications/${id}`),
    unread: () => api.get('/notifications/unread'),
    markAllAsRead: () => api.post('/notifications/mark-all-read'),
    markAsRead: (id) => api.post(`/notifications/${id}/mark-read`),
    getUnreadCount: () => api.get('/notifications/get-unread-count'),
};

// Student Profiles API
export const studentProfileAPI = {
    getAll: (params) => api.get('/student-profiles', { params }),
    getById: (id) => api.get(`/student-profiles/${id}`),
    create: (data) => api.post('/student-profiles', data),
    update: (id, data) => api.put(`/student-profiles/${id}`, data),
    delete: (id) => api.delete(`/student-profiles/${id}`),
    getSkills: () => api.get('/student-profile/skills'),
    updateSkills: (data) => api.post('/student-profile/skills', data),
    getAvailability: () => api.get('/student-profile/availability'),
    updateAvailability: (data) => api.post('/student-profile/availability', data),
    getPersonalityTraits: () => api.get('/student-profile/personality'),
    updatePersonalityTraits: (data) => api.post('/student-profile/personality', data),
    getAvailableSkills: () => api.get('/student-profile/get-available-skills'),
};

// Peer Evaluations API
export const peerEvaluationAPI = {
    getAll: (params) => api.get('/peer-evaluations', { params }),
    getById: (id) => api.get(`/peer-evaluations/${id}`),
    create: (data) => api.post('/peer-evaluations', data),
    update: (id, data) => api.put(`/peer-evaluations/${id}`, data),
    delete: (id) => api.delete(`/peer-evaluations/${id}`),
    projectEvaluations: (projectId) => api.get(`/peer-evaluations/project/${projectId}`),
    myEvaluations: () => api.get('/peer-evaluations/my-evaluations'),
    receivedEvaluations: (projectId) => api.get(`/peer-evaluations/received/${projectId}`),
    submitEvaluation: (id) => api.post(`/peer-evaluations/${id}/submit`),
    getEvaluationSummary: (projectId) => api.get(`/peer-evaluations/get-evaluation-summary/${projectId}`),
};

// Analytics API
export const analyticsAPI = {
    dashboard: () => api.get('/analytics/dashboard'),
    groupPerformance: (params) => api.get('/analytics/group-performance', { params }),
    individualPerformance: (params) => api.get('/analytics/individual-performance', { params }),
    projectProgress: (params) => api.get('/analytics/project-progress', { params }),
    skillDistribution: () => api.get('/analytics/skill-distribution'),
    exportData: (type) => api.get(`/analytics/export/${type}`),
    getAllUsers: () => api.get('/admin/get-all-users'),
    toggleUserStatus: (id) => api.post(`/admin/toggle-user-status/${id}`),
    systemStats: () => api.get('/admin/system-stats'),
    activityLogs: () => api.get('/admin/activity-logs'),
    supervisorAnalytics: () => api.get('/supervisor/analytics'),
};

export default api;

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\StudentProfileController;
use App\Http\Controllers\Api\PeerEvaluationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);

// Protected routes
Route::middleware('auth:api')->group(function () {
    
    // Authentication routes
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);
    Route::get('/auth/profile', [AuthController::class, 'profile']);
    Route::put('/auth/profile', [AuthController::class, 'updateProfile']);
    Route::post('/auth/change-password', [AuthController::class, 'changePassword']);
    Route::post('/auth/verify-email', [AuthController::class, 'verifyEmail']);

    // Student Profile routes
    Route::apiResource('student-profiles', StudentProfileController::class);
    Route::get('/student-profile/skills', [StudentProfileController::class, 'getSkills']);
    Route::post('/student-profile/skills', [StudentProfileController::class, 'updateSkills']);
    Route::get('/student-profile/availability', [StudentProfileController::class, 'getAvailability']);
    Route::post('/student-profile/availability', [StudentProfileController::class, 'updateAvailability']);
    Route::get('/student-profile/personality', [StudentProfileController::class, 'getPersonalityTraits']);
    Route::post('/student-profile/personality', [StudentProfileController::class, 'updatePersonalityTraits']);

    // Group routes
    Route::apiResource('groups', GroupController::class);
    Route::get('/groups/my-groups', [GroupController::class, 'myGroups']);
    Route::post('/groups/{group}/join', [GroupController::class, 'joinGroup']);
    Route::post('/groups/{group}/leave', [GroupController::class, 'leaveGroup']);
    Route::post('/groups/{group}/invite', [GroupController::class, 'inviteMember']);
    Route::post('/groups/{group}/remove/{user}', [GroupController::class, 'removeMember']);
    Route::post('/groups/auto-form', [GroupController::class, 'autoFormGroups']);
    Route::get('/groups/{group}/analytics', [GroupController::class, 'groupAnalytics']);
    Route::post('/groups/{group}/assign-role', [GroupController::class, 'assignRole']);

    // Project routes
    Route::apiResource('projects', ProjectController::class);
    Route::get('/projects/my-projects', [ProjectController::class, 'myProjects']);
    Route::get('/projects/supervised', [ProjectController::class, 'supervisedProjects']);
    Route::post('/projects/{project}/assign-group', [ProjectController::class, 'assignGroup']);
    Route::post('/projects/{project}/update-progress', [ProjectController::class, 'updateProgress']);
    Route::get('/projects/{project}/milestones', [ProjectController::class, 'getMilestones']);
    Route::post('/projects/{project}/milestones', [ProjectController::class, 'createMilestone']);
    Route::put('/projects/{project}/milestones/{milestone}', [ProjectController::class, 'updateMilestone']);
    Route::delete('/projects/{project}/milestones/{milestone}', [ProjectController::class, 'deleteMilestone']);

    // Task routes
    Route::apiResource('tasks', TaskController::class);
    Route::get('/projects/{project}/tasks', [TaskController::class, 'projectTasks']);
    Route::get('/tasks/my-tasks', [TaskController::class, 'myTasks']);
    Route::post('/tasks/{task}/assign', [TaskController::class, 'assignTask']);
    Route::post('/tasks/{task}/update-status', [TaskController::class, 'updateStatus']);
    Route::post('/tasks/{task}/add-comment', [TaskController::class, 'addComment']);
    Route::get('/tasks/{task}/comments', [TaskController::class, 'getComments']);

    // Message routes
    Route::apiResource('messages', MessageController::class);
    Route::get('/messages/conversations', [MessageController::class, 'conversations']);
    Route::get('/messages/conversation/{userId}', [MessageController::class, 'conversation']);
    Route::post('/messages/send', [MessageController::class, 'sendMessage']);
    Route::get('/messages/group/{groupId}', [MessageController::class, 'groupMessages']);
    Route::post('/messages/group/{groupId}/send', [MessageController::class, 'sendGroupMessage']);
    Route::post('/messages/{message}/mark-read', [MessageController::class, 'markAsRead']);

    // Notification routes
    Route::apiResource('notifications', NotificationController::class);
    Route::get('/notifications/unread', [NotificationController::class, 'unread']);
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
    Route::post('/notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead']);

    // Peer Evaluation routes
    Route::apiResource('peer-evaluations', PeerEvaluationController::class);
    Route::get('/peer-evaluations/project/{project}', [PeerEvaluationController::class, 'projectEvaluations']);
    Route::get('/peer-evaluations/my-evaluations', [PeerEvaluationController::class, 'myEvaluations']);
    Route::get('/peer-evaluations/received/{project}', [PeerEvaluationController::class, 'receivedEvaluations']);
    Route::post('/peer-evaluations/submit', [PeerEvaluationController::class, 'submitEvaluation']);

    // Analytics routes
    Route::get('/analytics/dashboard', [AnalyticsController::class, 'dashboard']);
    Route::get('/analytics/group-performance', [AnalyticsController::class, 'groupPerformance']);
    Route::get('/analytics/individual-performance', [AnalyticsController::class, 'individualPerformance']);
    Route::get('/analytics/project-progress', [AnalyticsController::class, 'projectProgress']);
    Route::get('/analytics/skill-distribution', [AnalyticsController::class, 'skillDistribution']);
    Route::get('/analytics/export/{type}', [AnalyticsController::class, 'exportData']);

    // Admin routes (role-based)
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/users', [AnalyticsController::class, 'getAllUsers']);
        Route::post('/admin/users/{user}/toggle-status', [AnalyticsController::class, 'toggleUserStatus']);
        Route::get('/admin/system-stats', [AnalyticsController::class, 'systemStats']);
        Route::get('/admin/activity-logs', [AnalyticsController::class, 'activityLogs']);
    });

    // Supervisor routes (role-based)
    Route::middleware('role:supervisor')->group(function () {
        Route::get('/supervisor/groups', [GroupController::class, 'supervisorGroups']);
        Route::get('/supervisor/projects', [ProjectController::class, 'supervisorProjects']);
        Route::post('/supervisor/projects/{project}/provide-feedback', [ProjectController::class, 'provideFeedback']);
        Route::get('/supervisor/analytics', [AnalyticsController::class, 'supervisorAnalytics']);
    });
});

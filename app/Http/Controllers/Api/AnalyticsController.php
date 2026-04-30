<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Group;
use App\Models\Project;
use App\Models\Task;
use App\Models\PeerEvaluation;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $data = [];

        if ($user->hasRole('student')) {
            $data = $this->getStudentDashboard();
        } elseif ($user->hasRole('supervisor')) {
            $data = $this->getSupervisorDashboard();
        } elseif ($user->hasRole('admin')) {
            $data = $this->getAdminDashboard();
        }

        return response()->json($data);
    }

    private function getStudentDashboard()
    {
        $user = Auth::user();
        
        return [
            'profile_completion' => $this->getProfileCompletion($user),
            'my_groups' => $user->groupMemberships()->with('group')->count(),
            'active_projects' => $user->assignedTasks()->whereHas('project', function ($query) {
                $query->whereIn('status', ['active', 'in_progress']);
            })->count(),
            'pending_tasks' => $user->assignedTasks()->where('status', 'todo')->count(),
            'completed_tasks' => $user->assignedTasks()->where('status', 'completed')->count(),
            'unread_messages' => $user->receivedMessages()->where('is_read', false)->count(),
            'unread_notifications' => $user->notifications()->where('is_read', false)->count(),
            'recent_activity' => $user->activityLogs()->with('subject')->latest()->take(5)->get(),
            'upcoming_deadlines' => $user->assignedTasks()
                ->where('due_date', '>', now())
                ->where('due_date', '<', now()->addDays(7))
                ->with('project')
                ->orderBy('due_date')
                ->get(),
        ];
    }

    private function getSupervisorDashboard()
    {
        $user = Auth::user();
        
        return [
            'total_projects' => $user->supervisedProjects()->count(),
            'active_projects' => $user->supervisedProjects()->active()->count(),
            'completed_projects' => $user->supervisedProjects()->completed()->count(),
            'total_groups' => $user->supervisedProjects()->whereNotNull('group_id')->count(),
            'at_risk_projects' => $user->supervisedProjects()->overdue()->count(),
            'recent_evaluations' => PeerEvaluation::whereHas('project', function ($query) use ($user) {
                $query->where('supervisor_id', $user->id);
            })->with(['evaluator', 'evaluated', 'project'])->latest()->take(5)->get(),
            'project_progress' => $this->getProjectProgressSummary($user),
            'group_performance' => $this->getGroupPerformanceSummary($user),
        ];
    }

    private function getAdminDashboard()
    {
        return [
            'total_users' => User::count(),
            'total_students' => User::role('student')->count(),
            'total_supervisors' => User::role('supervisor')->count(),
            'total_groups' => Group::count(),
            'active_groups' => Group::active()->count(),
            'total_projects' => Project::count(),
            'active_projects' => Project::active()->count(),
            'completed_projects' => Project::completed()->count(),
            'total_tasks' => Task::count(),
            'completed_tasks' => Task::where('status', 'completed')->count(),
            'user_registrations' => $this->getUserRegistrationTrends(),
            'project_completion_rates' => $this->getProjectCompletionRates(),
            'skill_distribution' => $this->getSkillDistribution(),
        ];
    }

    private function getProfileCompletion($user)
    {
        $profile = $user->studentProfile;
        if (!$profile) return 0;

        $fields = ['gpa', 'major', 'semester', 'bio', 'skills', 'availability', 'personality_traits'];
        $completed = 0;

        foreach ($fields as $field) {
            if (!empty($profile->$field)) $completed++;
        }

        return round(($completed / count($fields)) * 100);
    }

    private function getProjectProgressSummary($user)
    {
        $projects = $user->supervisedProjects()->with('tasks')->get();
        
        return $projects->map(function ($project) {
            $totalTasks = $project->tasks->count();
            $completedTasks = $project->tasks->where('status', 'completed')->count();
            $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

            return [
                'project' => $project,
                'progress' => round($progress, 2),
                'tasks_completed' => $completedTasks,
                'total_tasks' => $totalTasks,
            ];
        });
    }

    private function getGroupPerformanceSummary($user)
    {
        $projects = $user->supervisedProjects()->with('group.activeMembers.user.studentProfile')->get();
        
        return $projects->filter(function ($project) {
            return $project->group !== null;
        })->map(function ($project) {
            $group = $project->group;
            $evaluations = PeerEvaluation::where('project_id', $project->id)
                ->submitted()
                ->get();

            return [
                'group' => $group,
                'project' => $project,
                'member_count' => $group->activeMembers->count(),
                'average_gpa' => $group->getAverageGpa(),
                'evaluations_count' => $evaluations->count(),
                'average_score' => $evaluations->avg('overall_score'),
            ];
        });
    }

    private function getUserRegistrationTrends()
    {
        return User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getProjectCompletionRates()
    {
        return Project::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();
    }

    private function getSkillDistribution()
    {
        $skills = DB::table('student_profiles')
            ->selectRaw('JSON_UNQUOTE(JSON_EXTRACT(skills, "$[*].name")) as skill_name')
            ->whereNotNull('skills')
            ->get();

        $skillCounts = [];
        foreach ($skills as $skill) {
            $skillNames = json_decode($skill->skill_name, true);
            if (is_array($skillNames)) {
                foreach ($skillNames as $name) {
                    $skillCounts[$name] = ($skillCounts[$name] ?? 0) + 1;
                }
            }
        }

        return $skillCounts;
    }

    public function groupPerformance(Request $request)
    {
        $query = Group::with(['activeMembers.user.studentProfile', 'project.tasks']);

        // Filter by project
        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $groups = $query->get();

        $performance = $groups->map(function ($group) {
            $evaluations = PeerEvaluation::whereHas('evaluated', function ($query) use ($group) {
                $query->whereHas('groupMemberships', function ($q) use ($group) {
                    $q->where('group_id', $group->id);
                });
            })->submitted()->get();

            return [
                'group' => $group,
                'member_count' => $group->activeMembers->count(),
                'average_gpa' => $group->getAverageGpa(),
                'skill_diversity' => count($group->getSkillDistribution()),
                'tasks_completed' => $group->tasks()->where('status', 'completed')->count(),
                'total_tasks' => $group->tasks()->count(),
                'evaluations_count' => $evaluations->count(),
                'average_evaluation_score' => $evaluations->avg('overall_score'),
                'performance_score' => $this->calculateGroupPerformanceScore($group, $evaluations),
            ];
        });

        return response()->json($performance);
    }

    private function calculateGroupPerformanceScore($group, $evaluations)
    {
        $taskScore = $group->tasks()->count() > 0 
            ? ($group->tasks()->where('status', 'completed')->count() / $group->tasks()->count()) * 40 
            : 0;

        $evaluationScore = $evaluations->count() > 0 
            ? ($evaluations->avg('overall_score') / 5) * 30 
            : 0;

        $gpaScore = $group->getAverageGpa() ? ($group->getAverageGpa() / 4) * 20 : 0;

        $diversityScore = min(count($group->getSkillDistribution()) * 2, 10);

        return round($taskScore + $evaluationScore + $gpaScore + $diversityScore, 2);
    }

    public function individualPerformance(Request $request)
    {
        $query = User::role('student')->with('studentProfile', 'groupMemberships.group');

        // Filter by project
        if ($request->has('project_id')) {
            $query->whereHas('groupMemberships.group.project', function ($q) use ($request) {
                $q->where('id', $request->project_id);
            });
        }

        $students = $query->get();

        $performance = $students->map(function ($student) {
            $evaluationsGiven = $student->peerEvaluationsGiven()->submitted()->get();
            $evaluationsReceived = $student->peerEvaluationsReceived()->submitted()->get();
            $tasksCompleted = $student->assignedTasks()->where('status', 'completed')->count();
            $totalTasks = $student->assignedTasks()->count();

            return [
                'student' => $student,
                'gpa' => $student->studentProfile->gpa ?? 0,
                'total_projects' => $student->studentProfile->total_projects ?? 0,
                'average_rating' => $student->studentProfile->average_rating ?? 0,
                'tasks_completed' => $tasksCompleted,
                'total_tasks' => $totalTasks,
                'task_completion_rate' => $totalTasks > 0 ? round(($tasksCompleted / $totalTasks) * 100, 2) : 0,
                'evaluations_given' => $evaluationsGiven->count(),
                'evaluations_received' => $evaluationsReceived->count(),
                'average_evaluation_given' => $evaluationsGiven->avg('overall_score'),
                'average_evaluation_received' => $evaluationsReceived->avg('overall_score'),
                'performance_score' => $this->calculateIndividualPerformanceScore($student, $evaluationsReceived, $tasksCompleted, $totalTasks),
            ];
        });

        return response()->json($performance);
    }

    private function calculateIndividualPerformanceScore($student, $evaluationsReceived, $tasksCompleted, $totalTasks)
    {
        $gpaScore = ($student->studentProfile->gpa ?? 0) / 4 * 25;

        $evaluationScore = $evaluationsReceived->count() > 0 
            ? ($evaluationsReceived->avg('overall_score') / 5) * 35 
            : 0;

        $taskScore = $totalTasks > 0 
            ? ($tasksCompleted / $totalTasks) * 30 
            : 0;

        $participationScore = min(($evaluationsReceived->count() * 2), 10);

        return round($gpaScore + $evaluationScore + $taskScore + $participationScore, 2);
    }

    public function projectProgress(Request $request)
    {
        $query = Project::with(['supervisor', 'group.activeMembers', 'tasks', 'milestones']);

        // Filter by supervisor
        if ($request->has('supervisor_id')) {
            $query->where('supervisor_id', $request->supervisor_id);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $projects = $query->get();

        $progress = $projects->map(function ($project) {
            $tasksByStatus = $project->tasks->groupBy('status');
            $milestonesByStatus = $project->milestones->groupBy('status');

            return [
                'project' => $project,
                'progress_percentage' => $project->progress_percentage,
                'tasks' => [
                    'total' => $project->tasks->count(),
                    'completed' => ($tasksByStatus['completed'] ?? collect())->count(),
                    'in_progress' => ($tasksByStatus['in_progress'] ?? collect())->count(),
                    'todo' => ($tasksByStatus['todo'] ?? collect())->count(),
                ],
                'milestones' => [
                    'total' => $project->milestones->count(),
                    'completed' => ($milestonesByStatus['completed'] ?? collect())->count(),
                    'in_progress' => ($milestonesByStatus['in_progress'] ?? collect())->count(),
                    'pending' => ($milestonesByStatus['pending'] ?? collect())->count(),
                ],
                'days_remaining' => $project->getDaysRemaining(),
                'is_overdue' => $project->isOverdue(),
            ];
        });

        return response()->json($progress);
    }

    public function skillDistribution()
    {
        $skills = DB::table('student_profiles')
            ->selectRaw('JSON_UNQUOTE(JSON_EXTRACT(skills, "$[*].name")) as skill_name')
            ->whereNotNull('skills')
            ->get();

        $skillCounts = [];
        $skillProficiency = [];

        foreach ($skills as $skill) {
            $skillData = json_decode($skill->skill_name, true);
            if (is_array($skillData)) {
                foreach ($skillData as $name) {
                    $skillCounts[$name] = ($skillCounts[$name] ?? 0) + 1;
                }
            }
        }

        // Get proficiency levels
        $profiles = DB::table('student_profiles')->whereNotNull('skills')->get();
        foreach ($profiles as $profile) {
            $skillsArray = json_decode($profile->skills, true);
            if (is_array($skillsArray)) {
                foreach ($skillsArray as $skill) {
                    $name = $skill['name'];
                    $proficiency = $skill['proficiency'] ?? 0;
                    
                    if (!isset($skillProficiency[$name])) {
                        $skillProficiency[$name] = ['total' => 0, 'sum' => 0];
                    }
                    $skillProficiency[$name]['total']++;
                    $skillProficiency[$name]['sum'] += $proficiency;
                }
            }
        }

        $distribution = [];
        foreach ($skillCounts as $name => $count) {
            $distribution[] = [
                'skill' => $name,
                'count' => $count,
                'average_proficiency' => isset($skillProficiency[$name]) 
                    ? round($skillProficiency[$name]['sum'] / $skillProficiency[$name]['total'], 2)
                    : 0,
            ];
        }

        return response()->json($distribution);
    }

    public function exportData(Request $request)
    {
        $type = $request->type;
        $data = [];

        switch ($type) {
            case 'users':
                $data = User::with('studentProfile')->get();
                break;
            case 'groups':
                $data = Group::with(['creator', 'activeMembers.user', 'project'])->get();
                break;
            case 'projects':
                $data = Project::with(['supervisor', 'group', 'tasks', 'milestones'])->get();
                break;
            case 'evaluations':
                $data = PeerEvaluation::with(['evaluator', 'evaluated', 'project'])->get();
                break;
            default:
                return response()->json(['error' => 'Invalid export type'], 422);
        }

        return response()->json($data);
    }

    public function getAllUsers()
    {
        $users = User::with('roles', 'studentProfile')
            ->withCount(['groupMemberships' => function ($query) {
                $query->where('status', 'joined');
            }])
            ->paginate(20);

        return response()->json($users);
    }

    public function toggleUserStatus(User $user)
    {
        if (!Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->log("Changed user status to {$newStatus}");

        return response()->json(['message' => 'User status updated successfully']);
    }

    public function systemStats()
    {
        return response()->json([
            'users' => [
                'total' => User::count(),
                'students' => User::role('student')->count(),
                'supervisors' => User::role('supervisor')->count(),
                'admins' => User::role('admin')->count(),
                'active' => User::where('status', 'active')->count(),
            ],
            'groups' => [
                'total' => Group::count(),
                'active' => Group::active()->count(),
                'forming' => Group::forming()->count(),
                'completed' => Group::completed()->count(),
            ],
            'projects' => [
                'total' => Project::count(),
                'active' => Project::active()->count(),
                'completed' => Project::completed()->count(),
                'overdue' => Project::overdue()->count(),
            ],
            'tasks' => [
                'total' => Task::count(),
                'completed' => Task::where('status', 'completed')->count(),
                'in_progress' => Task::where('status', 'in_progress')->count(),
                'overdue' => Task::overdue()->count(),
            ],
        ]);
    }

    public function activityLogs()
    {
        $logs = ActivityLog::with(['user', 'subject'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return response()->json($logs);
    }

    public function supervisorAnalytics()
    {
        $user = Auth::user();
        
        return [
            'project_completion_trends' => $this->getProjectCompletionTrends($user),
            'student_performance_ranking' => $this->getStudentPerformanceRanking($user),
            'group_effectiveness' => $this->getGroupEffectiveness($user),
            'evaluation_insights' => $this->getEvaluationInsights($user),
        ];
    }

    private function getProjectCompletionTrends($user)
    {
        return $user->supervisedProjects()
            ->selectRaw('DATE(end_date) as date, COUNT(*) as count')
            ->whereNotNull('end_date')
            ->where('status', 'completed')
            ->orderBy('date')
            ->get();
    }

    private function getStudentPerformanceRanking($user)
    {
        $students = User::role('student')
            ->whereHas('groupMemberships.group.project', function ($query) use ($user) {
                $query->where('supervisor_id', $user->id);
            })
            ->with('studentProfile', 'groupMemberships.group')
            ->get();

        return $students->map(function ($student) {
            $evaluations = $student->peerEvaluationsReceived()->submitted()->get();
            return [
                'student' => $student,
                'average_score' => $evaluations->avg('overall_score'),
                'evaluations_count' => $evaluations->count(),
                'gpa' => $student->studentProfile->gpa ?? 0,
            ];
        })->sortByDesc('average_score')->values();
    }

    private function getGroupEffectiveness($user)
    {
        $projects = $user->supervisedProjects()->with('group.activeMembers.user.studentProfile')->get();
        
        return $projects->filter(function ($project) {
            return $project->group !== null;
        })->map(function ($project) {
            return [
                'project' => $project,
                'group' => $project->group,
                'effectiveness_score' => $this->calculateGroupEffectiveness($project->group),
            ];
        });
    }

    private function getEvaluationInsights($user)
    {
        $evaluations = PeerEvaluation::whereHas('project', function ($query) use ($user) {
            $query->where('supervisor_id', $user->id);
        })->submitted()->get();

        return [
            'total_evaluations' => $evaluations->count(),
            'average_scores' => [
                'contribution' => $evaluations->avg('contribution_score'),
                'teamwork' => $evaluations->avg('teamwork_score'),
                'communication' => $evaluations->avg('communication_score'),
                'quality' => $evaluations->avg('quality_score'),
                'timeliness' => $evaluations->avg('timeliness_score'),
            ],
            'low_performers' => $evaluations->groupBy('evaluated_id')
                ->filter(function ($userEvaluations) {
                    return $userEvaluations->avg('overall_score') < 3;
                })
                ->map(function ($userEvaluations) {
                    return [
                        'user' => $userEvaluations->first()->evaluated,
                        'average_score' => $userEvaluations->avg('overall_score'),
                    ];
                })->values(),
        ];
    }

    private function calculateGroupEffectiveness($group)
    {
        $tasks = $group->tasks ?? collect();
        $completedTasks = $tasks->where('status', 'completed');
        
        $taskScore = $tasks->count() > 0 
            ? ($completedTasks->count() / $tasks->count()) * 50 
            : 0;

        $memberScore = min($group->activeMembers->count() * 10, 30);

        $gpaScore = ($group->getAverageGpa() ?? 0) / 4 * 20;

        return round($taskScore + $memberScore + $gpaScore, 2);
    }
}

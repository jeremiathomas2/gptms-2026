<?php

namespace App\Services;

use App\Models\User;
use App\Models\Group;
use App\Models\Project;
use App\Models\Task;
use App\Models\PeerEvaluation;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SupervisorAnalyticsService
{
    private $supervisor;
    private $cacheTtl = 300; // 5 minutes

    public function __construct(?User $supervisor = null)
    {
        $this->supervisor = $supervisor ?? Auth::user();
    }

    /**
     * Get comprehensive supervisor dashboard data
     */
    public function getDashboardData(): array
    {
        try {
            $cacheKey = "supervisor_analytics_{$this->supervisor->id}";
            
            return Cache::remember($cacheKey, $this->cacheTtl, function () {
                return [
                    'key_metrics' => $this->getKeyMetrics(),
                    'project_performance' => $this->getProjectPerformance(),
                    'group_effectiveness' => $this->getGroupEffectiveness(),
                    'student_performance' => $this->getStudentPerformance(),
                    'evaluation_insights' => $this->getEvaluationInsights(),
                    'activity_summary' => $this->getActivitySummary(),
                    'trend_data' => $this->getTrendData(),
                ];
            });
        } catch (\Exception $e) {
            \Log::error('Supervisor Analytics Service Error', [
                'error' => $e->getMessage(),
                'supervisor_id' => $this->supervisor->id,
            ]);
            
            return $this->getFallbackData();
        }
    }

    /**
     * Get key performance metrics
     */
    private function getKeyMetrics(): array
    {
        $projects = $this->supervisor->supervisedProjects();
        
        return [
            'total_projects' => $projects->count(),
            'active_projects' => $projects->where('status', 'active')->count(),
            'completed_projects' => $projects->where('status', 'completed')->count(),
            'at_risk_projects' => $projects->where('end_date', '<', now())->where('status', '!=', 'completed')->count(),
            'total_groups' => $projects->whereNotNull('group_id')->count(),
            'total_students' => $this->getSupervisedStudentsCount(),
            'average_project_score' => $this->getAverageProjectScore(),
            'completion_rate' => $this->getCompletionRate(),
        ];
    }

    /**
     * Get project performance data
     */
    private function getProjectPerformance(): array
    {
        $projects = $this->supervisor->supervisedProjects()
            ->with(['group.activeMembers.user.studentProfile', 'tasks', 'milestones'])
            ->get();

        return $projects->map(function ($project) {
            $totalTasks = $project->tasks->count();
            $completedTasks = $project->tasks->where('status', 'completed')->count();
            $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

            return [
                'id' => $project->id,
                'name' => $project->name,
                'status' => $project->status,
                'progress_percentage' => round($progress, 2),
                'tasks_completed' => $completedTasks,
                'total_tasks' => $totalTasks,
                'group_name' => $project->group?->name,
                'member_count' => $project->group?->activeMembers->count() ?? 0,
                'days_remaining' => $this->getDaysRemaining($project->end_date),
                'is_overdue' => $project->end_date && $project->end_date < now() && $project->status !== 'completed',
                'last_activity' => $this->getLastProjectActivity($project->id),
            ];
        })->toArray();
    }

    /**
     * Get group effectiveness data
     */
    private function getGroupEffectiveness(): array
    {
        $projects = $this->supervisor->supervisedProjects()
            ->with('group.activeMembers.user.studentProfile')
            ->whereNotNull('group_id')
            ->get();

        return $projects->map(function ($project) {
            $group = $project->group;
            if (!$group) return null;

            $evaluations = PeerEvaluation::where('project_id', $project->id)
                ->where('status', 'submitted')
                ->get();

            return [
                'group_id' => $group->id,
                'group_name' => $group->name,
                'project_name' => $project->name,
                'member_count' => $group->activeMembers->count(),
                'average_gpa' => $this->getGroupAverageGpa($group),
                'skill_diversity' => count($this->getGroupSkills($group)),
                'evaluations_count' => $evaluations->count(),
                'average_evaluation_score' => $evaluations->avg('overall_score'),
                'effectiveness_score' => $this->calculateGroupEffectiveness($group, $evaluations),
                'performance_trend' => $this->getGroupPerformanceTrend($group->id),
            ];
        })->filter()->values()->toArray();
    }

    /**
     * Get student performance data
     */
    private function getStudentPerformance(): array
    {
        $students = User::role('student')
            ->whereHas('groupMemberships.group.project', function ($query) {
                $query->where('supervisor_id', $this->supervisor->id);
            })
            ->with('studentProfile', 'groupMemberships.group.project')
            ->get();

        return $students->map(function ($student) {
            $evaluationsGiven = $student->peerEvaluationsGiven()->where('status', 'submitted')->get();
            $evaluationsReceived = $student->peerEvaluationsReceived()->where('status', 'submitted')->get();
            $tasksCompleted = $student->assignedTasks()->where('status', 'completed')->count();
            $totalTasks = $student->assignedTasks()->count();

            return [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'gpa' => $student->studentProfile->gpa ?? 0,
                'major' => $student->studentProfile->major ?? 'Unknown',
                'group_name' => $student->groupMemberships->first()?->group?->name,
                'tasks_completed' => $tasksCompleted,
                'total_tasks' => $totalTasks,
                'task_completion_rate' => $totalTasks > 0 ? round(($tasksCompleted / $totalTasks) * 100, 2) : 0,
                'evaluations_given' => $evaluationsGiven->count(),
                'evaluations_received' => $evaluationsReceived->count(),
                'average_evaluation_given' => $evaluationsGiven->avg('overall_score'),
                'average_evaluation_received' => $evaluationsReceived->avg('overall_score'),
                'performance_score' => $this->calculateStudentPerformanceScore($student, $evaluationsReceived, $tasksCompleted, $totalTasks),
                'last_active' => $student->last_login_at?->diffForHumans() ?? 'Never',
            ];
        })->sortByDesc('performance_score')->values()->toArray();
    }

    /**
     * Get evaluation insights
     */
    private function getEvaluationInsights(): array
    {
        $evaluations = PeerEvaluation::whereHas('project', function ($query) {
            $query->where('supervisor_id', $this->supervisor->id);
        })->where('status', 'submitted')->get();

        return [
            'total_evaluations' => $evaluations->count(),
            'average_scores' => [
                'overall' => round($evaluations->avg('overall_score'), 2),
                'contribution' => round($evaluations->avg('contribution_score'), 2),
                'teamwork' => round($evaluations->avg('teamwork_score'), 2),
                'communication' => round($evaluations->avg('communication_score'), 2),
                'quality' => round($evaluations->avg('quality_score'), 2),
                'timeliness' => round($evaluations->avg('timeliness_score'), 2),
            ],
            'score_distribution' => $this->getScoreDistribution($evaluations),
            'low_performers' => $this->getLowPerformers($evaluations),
            'high_performers' => $this->getHighPerformers($evaluations),
            'evaluation_trends' => $this->getEvaluationTrends(),
        ];
    }

    /**
     * Get activity summary
     */
    private function getActivitySummary(): array
    {
        $recentActivities = ActivityLog::whereHas('user', function ($query) {
            $query->whereHas('groupMemberships.group.project', function ($q) {
                $q->where('supervisor_id', $this->supervisor->id);
            });
        })->with('user')
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->get();

        return [
            'recent_activities' => $recentActivities->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'user_name' => $activity->user->name,
                    'action' => $activity->action,
                    'description' => $activity->description,
                    'created_at' => $activity->created_at->diffForHumans(),
                    'properties' => $activity->properties,
                ];
            })->toArray(),
            'activity_trends' => $this->getActivityTrends(),
        ];
    }

    /**
     * Get trend data for charts
     */
    private function getTrendData(): array
    {
        return [
            'project_completion_trends' => $this->getProjectCompletionTrends(),
            'student_performance_trends' => $this->getStudentPerformanceTrends(),
            'group_formation_trends' => $this->getGroupFormationTrends(),
        ];
    }

    // Helper methods
    private function getSupervisedStudentsCount(): int
    {
        return User::role('student')
            ->whereHas('groupMemberships.group.project', function ($query) {
                $query->where('supervisor_id', $this->supervisor->id);
            })
            ->count();
    }

    private function getAverageProjectScore(): float
    {
        $projects = $this->supervisor->supervisedProjects()->where('status', 'completed')->get();
        
        if ($projects->isEmpty()) return 0;
        
        $totalScore = $projects->sum(function ($project) {
            $evaluations = PeerEvaluation::where('project_id', $project->id)
                ->where('status', 'submitted')
                ->get();
            return $evaluations->avg('overall_score') ?? 0;
        });
        
        return round($totalScore / $projects->count(), 2);
    }

    private function getCompletionRate(): float
    {
        $projects = $this->supervisor->supervisedProjects();
        
        if ($projects->isEmpty()) return 0;
        
        $completed = $projects->where('status', 'completed')->count();
        return round(($completed / $projects->count()) * 100, 2);
    }

    private function getDaysRemaining(?string $endDate): int
    {
        if (!$endDate) return 0;
        
        return now()->diffInDays(Carbon::parse($endDate), false);
    }

    private function getLastProjectActivity(int $projectId): ?string
    {
        $activity = ActivityLog::where('subject_type', 'Project')
            ->where('subject_id', $projectId)
            ->orderBy('created_at', 'desc')
            ->first();
            
        return $activity?->created_at->diffForHumans();
    }

    private function getGroupAverageGpa($group): float
    {
        $members = $group->activeMembers;
        
        if ($members->isEmpty()) return 0;
        
        $totalGpa = $members->sum(function ($member) {
            return $member->user->studentProfile->gpa ?? 0;
        });
        
        return round($totalGpa / $members->count(), 2);
    }

    private function getGroupSkills($group): array
    {
        $members = $group->activeMembers;
        $allSkills = [];
        
        foreach ($members as $member) {
            $skills = $member->user->studentProfile->skills ?? [];
            if (is_array($skills)) {
                $allSkills = array_merge($allSkills, $skills);
            }
        }
        
        return array_unique($allSkills);
    }

    private function calculateGroupEffectiveness($group, $evaluations): float
    {
        $taskScore = 0;
        $evaluationScore = 0;
        $gpaScore = 0;
        $participationScore = 0;

        // Task completion score (40%)
        $tasks = $group->tasks ?? collect();
        if ($tasks->isNotEmpty()) {
            $completedTasks = $tasks->where('status', 'completed')->count();
            $taskScore = ($completedTasks / $tasks->count()) * 40;
        }

        // Evaluation score (30%)
        if ($evaluations->isNotEmpty()) {
            $evaluationScore = ($evaluations->avg('overall_score') / 5) * 30;
        }

        // GPA score (20%)
        $avgGpa = $this->getGroupAverageGpa($group);
        $gpaScore = ($avgGpa / 4) * 20;

        // Participation score (10%)
        $memberCount = $group->activeMembers->count();
        $participationScore = min($memberCount * 2, 10);

        return round($taskScore + $evaluationScore + $gpaScore + $participationScore, 2);
    }

    private function calculateStudentPerformanceScore($student, $evaluations, $tasksCompleted, $totalTasks): float
    {
        $gpaScore = ($student->studentProfile->gpa ?? 0) / 4 * 25;
        
        $evaluationScore = 0;
        if ($evaluations->isNotEmpty()) {
            $evaluationScore = ($evaluations->avg('overall_score') / 5) * 35;
        }
        
        $taskScore = 0;
        if ($totalTasks > 0) {
            $taskScore = ($tasksCompleted / $totalTasks) * 30;
        }
        
        $participationScore = min($evaluations->count() * 2, 10);

        return round($gpaScore + $evaluationScore + $taskScore + $participationScore, 2);
    }

    private function getScoreDistribution($evaluations): array
    {
        $distribution = [
            'excellent' => 0, // 4.5-5.0
            'good' => 0,      // 3.5-4.4
            'average' => 0,   // 2.5-3.4
            'poor' => 0,      // 0-2.4
        ];

        foreach ($evaluations as $evaluation) {
            $score = $evaluation->overall_score;
            if ($score >= 4.5) $distribution['excellent']++;
            elseif ($score >= 3.5) $distribution['good']++;
            elseif ($score >= 2.5) $distribution['average']++;
            else $distribution['poor']++;
        }

        return $distribution;
    }

    private function getLowPerformers($evaluations): array
    {
        return $evaluations->groupBy('evaluated_id')
            ->filter(function ($userEvaluations) {
                return $userEvaluations->avg('overall_score') < 3.0;
            })
            ->map(function ($userEvaluations) {
                return [
                    'student' => $userEvaluations->first()->evaluated,
                    'average_score' => round($userEvaluations->avg('overall_score'), 2),
                    'evaluations_count' => $userEvaluations->count(),
                ];
            })
            ->values()
            ->take(5)
            ->toArray();
    }

    private function getHighPerformers($evaluations): array
    {
        return $evaluations->groupBy('evaluated_id')
            ->filter(function ($userEvaluations) {
                return $userEvaluations->avg('overall_score') >= 4.0;
            })
            ->map(function ($userEvaluations) {
                return [
                    'student' => $userEvaluations->first()->evaluated,
                    'average_score' => round($userEvaluations->avg('overall_score'), 2),
                    'evaluations_count' => $userEvaluations->count(),
                ];
            })
            ->values()
            ->take(5)
            ->toArray();
    }

    private function getProjectCompletionTrends(): array
    {
        return $this->supervisor->supervisedProjects()
            ->selectRaw('DATE(end_date) as date, COUNT(*) as count')
            ->whereNotNull('end_date')
            ->where('status', 'completed')
            ->where('end_date', '>=', now()->subMonths(6))
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    private function getStudentPerformanceTrends(): array
    {
        // This would require more complex historical data analysis
        return [];
    }

    private function getGroupFormationTrends(): array
    {
        return Group::whereHas('project', function ($query) {
            $query->where('supervisor_id', $this->supervisor->id);
        })->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    private function getGroupPerformanceTrend(int $groupId): array
    {
        // Simplified trend calculation
        return ['trend' => 'stable', 'change' => 0];
    }

    private function getActivityTrends(): array
    {
        return ActivityLog::whereHas('user', function ($query) {
            $query->whereHas('groupMemberships.group.project', function ($q) {
                $q->where('supervisor_id', $this->supervisor->id);
            });
        })->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    private function getEvaluationTrends(): array
    {
        return PeerEvaluation::whereHas('project', function ($query) {
            $query->where('supervisor_id', $this->supervisor->id);
        })->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    /**
     * Get fallback data when errors occur
     */
    private function getFallbackData(): array
    {
        return [
            'key_metrics' => [
                'total_projects' => 0,
                'active_projects' => 0,
                'completed_projects' => 0,
                'at_risk_projects' => 0,
                'total_groups' => 0,
                'total_students' => 0,
                'average_project_score' => 0,
                'completion_rate' => 0,
            ],
            'project_performance' => [],
            'group_effectiveness' => [],
            'student_performance' => [],
            'evaluation_insights' => [
                'total_evaluations' => 0,
                'average_scores' => [
                    'overall' => 0,
                    'contribution' => 0,
                    'teamwork' => 0,
                    'communication' => 0,
                    'quality' => 0,
                    'timeliness' => 0,
                ],
                'score_distribution' => [
                    'excellent' => 0,
                    'good' => 0,
                    'average' => 0,
                    'poor' => 0,
                ],
                'low_performers' => [],
                'high_performers' => [],
                'evaluation_trends' => [],
            ],
            'activity_summary' => [
                'recent_activities' => [],
                'activity_trends' => [],
            ],
            'trend_data' => [
                'project_completion_trends' => [],
                'student_performance_trends' => [],
                'group_formation_trends' => [],
            ],
        ];
    }

    /**
     * Clear analytics cache for supervisor
     */
    public function clearCache(): void
    {
        $cacheKey = "supervisor_analytics_{$this->supervisor->id}";
        Cache::forget($cacheKey);
    }
}

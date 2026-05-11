<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivityLogger
{
    /**
     * Log an activity
     *
     * @param string $action
     * @param string|null $description
     * @param mixed|null $subject
     * @param array $properties
     * @param User|null $user
     * @return ActivityLog|null
     */
    public static function log(
        string $action,
        ?string $description = null,
        $subject = null,
        array $properties = [],
        ?User $user = null
    ): ?ActivityLog {
        try {
            $userId = $user?->id ?? session('user.id') ?? Auth::id();
            
            $data = [
                'user_id' => $userId,
                'action' => $action,
                'description' => $description,
                'properties' => $properties,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ];

            // Set subject if provided
            if ($subject) {
                $data['subject_type'] = class_basename($subject);
                $data['subject_id'] = $subject->id;
            }

            $activityLog = ActivityLog::create($data);
            
            // Log to system log for debugging
            Log::info('Activity logged', [
                'action' => $action,
                'user_id' => $userId,
                'description' => $description,
                'log_id' => $activityLog->id
            ]);

            return $activityLog;
        } catch (\Exception $e) {
            Log::error('Failed to log activity', [
                'action' => $action,
                'error' => $e->getMessage(),
                'user_id' => $userId ?? 'unknown'
            ]);
            
            return null;
        }
    }

    /**
     * Log login activity
     */
    public static function logLogin(User $user, ?Request $request = null): ?ActivityLog
    {
        $request = $request ?? request();
        
        return self::log(
            'login',
            "User {$user->name} logged in",
            $user,
            [
                'email' => $user->email,
                'role' => $user->roles->first()?->name,
                'login_time' => now()->toISOString(),
            ],
            $user
        );
    }

    /**
     * Log logout activity
     */
    public static function logLogout(User $user, ?Request $request = null): ?ActivityLog
    {
        $request = $request ?? request();
        
        return self::log(
            'logout',
            "User {$user->name} logged out",
            $user,
            [
                'email' => $user->email,
                'role' => $user->roles->first()?->name,
                'logout_time' => now()->toISOString(),
            ],
            $user
        );
    }

    /**
     * Log group creation
     */
    public static function logGroupCreation($group, User $creator): ?ActivityLog
    {
        return self::log(
            'create',
            "Group '{$group->name}' was created",
            $group,
            [
                'group_name' => $group->name,
                'creator_name' => $creator->name,
                'created_at' => $group->created_at->toISOString(),
            ],
            $creator
        );
    }

    /**
     * Log group member addition
     */
    public static function logGroupMemberAddition($group, $member, User $actor): ?ActivityLog
    {
        return self::log(
            'update',
            "Member '{$member->name}' added to group '{$group->name}'",
            $group,
            [
                'member_name' => $member->name,
                'group_name' => $group->name,
                'actor_name' => $actor->name,
                'action_type' => 'member_added',
            ],
            $actor
        );
    }

    /**
     * Log countdown start
     */
    public static function logCountdownStart($settings, User $user): ?ActivityLog
    {
        return self::log(
            'update',
            "Automatic group formation countdown started",
            $settings,
            [
                'duration_minutes' => $settings->countdown_minutes,
                'participants_per_group' => $settings->participants_per_group,
                'balance_by_gender' => $settings->balance_by_gender,
                'balance_by_skills' => $settings->balance_by_skills,
                'auto_create_groups' => $settings->auto_create_groups,
                'started_by' => $user->name,
            ],
            $user
        );
    }

    /**
     * Log countdown stop
     */
    public static function logCountdownStop($settings, User $user): ?ActivityLog
    {
        return self::log(
            'update',
            "Automatic group formation countdown stopped",
            $settings,
            [
                'stopped_by' => $user->name,
                'stop_time' => now()->toISOString(),
            ],
            $user
        );
    }

    /**
     * Log automatic group creation
     */
    public static function logAutomaticGroupCreation($groupsCreated, $settings, User $user): ?ActivityLog
    {
        return self::log(
            'create',
            "Automatically created {$groupsCreated} groups",
            $settings,
            [
                'groups_created' => $groupsCreated,
                'participants_per_group' => $settings->participants_per_group,
                'balance_by_gender' => $settings->balance_by_gender,
                'balance_by_skills' => $settings->balance_by_skills,
                'created_by' => $user->name,
            ],
            $user
        );
    }

    /**
     * Log settings update
     */
    public static function logSettingsUpdate($settings, array $changes, User $user): ?ActivityLog
    {
        return self::log(
            'update',
            "Group settings updated",
            $settings,
            [
                'changes' => $changes,
                'updated_by' => $user->name,
                'update_time' => now()->toISOString(),
            ],
            $user
        );
    }

    /**
     * Log user management actions
     */
    public static function logUserAction($action, $targetUser, User $actor, array $details = []): ?ActivityLog
    {
        $description = match($action) {
            'toggle_status' => "User '{$targetUser->name}' status toggled to " . ($targetUser->is_active ? 'active' : 'inactive'),
            'update_role' => "User '{$targetUser->name}' role updated",
            'delete' => "User '{$targetUser->name}' deleted",
            'create' => "User '{$targetUser->name}' created",
            default => "User action '{$action}' performed on '{$targetUser->name}'"
        };

        return self::log(
            $action,
            $description,
            $targetUser,
            array_merge($details, [
                'target_user_id' => $targetUser->id,
                'target_user_email' => $targetUser->email,
                'actor_name' => $actor->name,
            ]),
            $actor
        );
    }

    /**
     * Log system errors or important events
     */
    public static function logSystemEvent(string $event, string $description, array $details = []): ?ActivityLog
    {
        return self::log(
            'system',
            $description,
            null,
            array_merge($details, [
                'event_type' => $event,
                'timestamp' => now()->toISOString(),
                'environment' => app()->environment(),
            ])
        );
    }

    /**
     * Get recent activities with filtering
     */
    public static function getRecentActivities(
        int $limit = 100,
        ?string $action = null,
        ?int $userId = null,
        ?\Carbon\Carbon $since = null
    ) {
        $query = ActivityLog::with('user')
            ->orderBy('created_at', 'desc');

        if ($action) {
            $query->where('action', $action);
        }

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($since) {
            $query->where('created_at', '>=', $since);
        }

        return $query->limit($limit)->get();
    }

    /**
     * Clean up old activity logs
     */
    public static function cleanup(int $daysToKeep = 90): int
    {
        $cutoffDate = now()->subDays($daysToKeep);
        
        $deleted = ActivityLog::where('created_at', '<', $cutoffDate)->delete();
        
        Log::info('Activity logs cleanup completed', [
            'deleted_count' => $deleted,
            'cutoff_date' => $cutoffDate->toISOString(),
        ]);

        return $deleted;
    }
}

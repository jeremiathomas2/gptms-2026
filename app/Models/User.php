<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'avatar',
        'status',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = [
        'full_name',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->getRoleNames()->first(),
            'permissions' => $this->getAllPermissions()->pluck('name'),
        ];
    }

    // Relationships
    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function createdGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'created_by');
    }

    public function groupMemberships(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    public function activeGroup(): HasOne
    {
        return $this->hasOne(GroupMember::class)
            ->where('status', 'joined')
            ->with('group');
    }

    public function supervisedProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'supervisor_id');
    }

    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function createdTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function peerEvaluationsGiven(): HasMany
    {
        return $this->hasMany(PeerEvaluation::class, 'evaluator_id');
    }

    public function peerEvaluationsReceived(): HasMany
    {
        return $this->hasMany(PeerEvaluation::class, 'evaluated_id');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeStudents($query)
    {
        return $query->role('student');
    }

    public function scopeSupervisors($query)
    {
        return $query->role('supervisor');
    }

    public function scopeAdmins($query)
    {
        return $query->role('admin');
    }
}

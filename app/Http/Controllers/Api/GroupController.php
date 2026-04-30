<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $query = Group::with(['creator', 'activeMembers.user', 'project']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by availability
        if ($request->boolean('available_only')) {
            $query->available();
        }

        $groups = $query->paginate(15);

        return response()->json($groups);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'max_members' => 'required|integer|min:2|max:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'max_members' => $request->max_members,
            'created_by' => Auth::id(),
        ]);

        // Add creator as member
        GroupMember::create([
            'group_id' => $group->id,
            'user_id' => Auth::id(),
            'role' => 'leader',
            'status' => 'joined',
            'joined_at' => now(),
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($group)
            ->log('Created group');

        return response()->json([
            'message' => 'Group created successfully',
            'group' => $group->load(['creator', 'activeMembers.user'])
        ], 201);
    }

    public function show(Group $group)
    {
        $group->load([
            'creator',
            'activeMembers.user.studentProfile',
            'project',
            'messages.sender'
        ]);

        return response()->json($group);
    }

    public function update(Request $request, Group $group)
    {
        // Check if user is group leader or admin
        if ($group->created_by !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'nullable|in:forming,active,completed,archived',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $group->update($request->only(['name', 'description', 'status']));

        activity()
            ->causedBy(Auth::user())
            ->performedOn($group)
            ->log('Updated group');

        return response()->json([
            'message' => 'Group updated successfully',
            'group' => $group->fresh()
        ]);
    }

    public function destroy(Group $group)
    {
        // Check if user is group leader or admin
        if ($group->created_by !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $group->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($group)
            ->log('Deleted group');

        return response()->json(['message' => 'Group deleted successfully']);
    }

    public function myGroups()
    {
        $groups = Group::whereHas('members', function ($query) {
            $query->where('user_id', Auth::id())->where('status', 'joined');
        })->with(['creator', 'activeMembers.user', 'project'])->get();

        return response()->json($groups);
    }

    public function joinGroup(Request $request, Group $group)
    {
        // Check if user is already a member
        $existingMember = GroupMember::where('group_id', $group->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingMember) {
            return response()->json(['error' => 'Already a member of this group'], 422);
        }

        // Check if group is full
        if ($group->isFull()) {
            return response()->json(['error' => 'Group is full'], 422);
        }

        GroupMember::create([
            'group_id' => $group->id,
            'user_id' => Auth::id(),
            'role' => 'member',
            'status' => 'joined',
            'joined_at' => now(),
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($group)
            ->log('Joined group');

        return response()->json(['message' => 'Joined group successfully']);
    }

    public function leaveGroup(Group $group)
    {
        $member = GroupMember::where('group_id', $group->id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$member) {
            return response()->json(['error' => 'Not a member of this group'], 422);
        }

        $member->update([
            'status' => 'left',
            'left_at' => now(),
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($group)
            ->log('Left group');

        return response()->json(['message' => 'Left group successfully']);
    }

    public function inviteMember(Request $request, Group $group)
    {
        // Check if user is group leader
        if ($group->created_by !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        // Check if user is already a member
        $existingMember = GroupMember::where('group_id', $group->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingMember) {
            return response()->json(['error' => 'User is already a member of this group'], 422);
        }

        // Check if group is full
        if ($group->isFull()) {
            return response()->json(['error' => 'Group is full'], 422);
        }

        GroupMember::create([
            'group_id' => $group->id,
            'user_id' => $user->id,
            'role' => 'member',
            'status' => 'invited',
        ]);

        // Create notification
        $user->notifications()->create([
            'title' => 'Group Invitation',
            'message' => "You have been invited to join group: {$group->name}",
            'type' => 'message',
            'action_url' => "/groups/{$group->id}",
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($group)
            ->log("Invited {$user->full_name} to group");

        return response()->json(['message' => 'Invitation sent successfully']);
    }

    public function removeMember(Group $group, User $user)
    {
        // Check if user is group leader
        if ($group->created_by !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $member = GroupMember::where('group_id', $group->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$member) {
            return response()->json(['error' => 'User is not a member of this group'], 422);
        }

        $member->update([
            'status' => 'left',
            'left_at' => now(),
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($group)
            ->log("Removed {$user->full_name} from group");

        return response()->json(['message' => 'Member removed successfully']);
    }

    public function autoFormGroups(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_size' => 'required|integer|min:2|max:6',
            'formation_strategy' => 'required|in:skill_balance,gpa_balance,random',
            'filters' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Get students without groups
        $studentsQuery = StudentProfile::with('user')
            ->whereDoesntHave('user.groupMemberships', function ($query) {
                $query->where('status', 'joined');
            });

        // Apply filters
        if ($request->has('filters')) {
            $filters = $request->filters;
            
            if (isset($filters['major'])) {
                $studentsQuery->where('major', $filters['major']);
            }
            
            if (isset($filters['gpa_min'])) {
                $studentsQuery->where('gpa', '>=', $filters['gpa_min']);
            }
            
            if (isset($filters['gpa_max'])) {
                $studentsQuery->where('gpa', '<=', $filters['gpa_max']);
            }
        }

        $students = $studentsQuery->get();

        if ($students->count() < $request->group_size) {
            return response()->json(['error' => 'Not enough students to form groups'], 422);
        }

        // Implement group formation algorithm
        $groups = $this->formGroupsAlgorithm($students, $request->group_size, $request->formation_strategy);

        DB::transaction(function () use ($groups) {
            foreach ($groups as $groupData) {
                $group = Group::create([
                    'name' => 'Auto-formed Group ' . uniqid(),
                    'description' => 'Automatically formed group',
                    'status' => 'forming',
                    'max_members' => count($groupData['members']),
                    'created_by' => Auth::id(),
                    'formation_criteria' => $groupData['criteria'],
                    'formation_score' => $groupData['score'],
                ]);

                foreach ($groupData['members'] as $index => $student) {
                    GroupMember::create([
                        'group_id' => $group->id,
                        'user_id' => $student->user_id,
                        'role' => $index === 0 ? 'leader' : 'member',
                        'status' => 'joined',
                        'joined_at' => now(),
                    ]);
                }
            }
        });

        activity()
            ->causedBy(Auth::user())
            ->log('Auto-formed groups');

        return response()->json([
            'message' => 'Groups formed successfully',
            'groups_count' => count($groups),
        ]);
    }

    private function formGroupsAlgorithm($students, $groupSize, $strategy)
    {
        $groups = [];
        $students = $students->shuffle();

        if ($strategy === 'random') {
            // Simple random grouping
            for ($i = 0; $i < count($students); $i += $groupSize) {
                $groupMembers = $students->slice($i, $groupSize);
                if ($groupMembers->count() === $groupSize) {
                    $groups[] = [
                        'members' => $groupMembers->toArray(),
                        'criteria' => ['strategy' => 'random'],
                        'score' => 0,
                    ];
                }
            }
        } elseif ($strategy === 'skill_balance') {
            // Skill-based grouping
            $this->skillBasedGrouping($students, $groupSize, $groups);
        } elseif ($strategy === 'gpa_balance') {
            // GPA-based grouping
            $this->gpaBasedGrouping($students, $groupSize, $groups);
        }

        return $groups;
    }

    private function skillBasedGrouping(&$students, $groupSize, &$groups)
    {
        // Sort students by skill diversity
        $students = $students->sortBy(function ($student) {
            return count($student->skills ?? []);
        });

        for ($i = 0; $i < count($students); $i += $groupSize) {
            $groupMembers = $students->slice($i, $groupSize);
            if ($groupMembers->count() === $groupSize) {
                $score = $this->calculateSkillBalanceScore($groupMembers);
                $groups[] = [
                    'members' => $groupMembers->toArray(),
                    'criteria' => ['strategy' => 'skill_balance'],
                    'score' => $score,
                ];
            }
        }
    }

    private function gpaBasedGrouping(&$students, $groupSize, &$groups)
    {
        // Sort by GPA and create balanced groups
        $students = $students->sortBy('gpa');
        
        for ($i = 0; $i < count($students); $i += $groupSize) {
            $groupMembers = $students->slice($i, $groupSize);
            if ($groupMembers->count() === $groupSize) {
                $score = $this->calculateGpaBalanceScore($groupMembers);
                $groups[] = [
                    'members' => $groupMembers->toArray(),
                    'criteria' => ['strategy' => 'gpa_balance'],
                    'score' => $score,
                ];
            }
        }
    }

    private function calculateSkillBalanceScore($groupMembers)
    {
        $allSkills = [];
        foreach ($groupMembers as $member) {
            foreach ($member->skills ?? [] as $skill) {
                $allSkills[] = $skill['name'];
            }
        }
        
        return count(array_unique($allSkills)) / max(1, count($allSkills)) * 100;
    }

    private function calculateGpaBalanceScore($groupMembers)
    {
        $gpas = $groupMembers->pluck('gpa')->filter();
        if ($gpas->isEmpty()) return 0;
        
        $mean = $gpas->avg();
        $variance = $gpas->sum(function ($gpa) use ($mean) {
            return pow($gpa - $mean, 2);
        }) / $gpas->count();
        
        // Lower variance = higher score
        return max(0, 100 - ($variance * 100));
    }

    public function groupAnalytics(Group $group)
    {
        $analytics = [
            'member_count' => $group->getCurrentMemberCount(),
            'skill_distribution' => $group->getSkillDistribution(),
            'average_gpa' => $group->getAverageGpa(),
            'tasks_completed' => $group->tasks()->where('status', 'completed')->count(),
            'total_tasks' => $group->tasks()->count(),
            'progress_percentage' => $group->tasks()->count() > 0 
                ? ($group->tasks()->where('status', 'completed')->count() / $group->tasks()->count()) * 100 
                : 0,
        ];

        return response()->json($analytics);
    }

    public function assignRole(Request $request, Group $group)
    {
        // Check if user is group leader
        if ($group->created_by !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:leader,member,researcher,developer,designer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $member = GroupMember::where('group_id', $group->id)
            ->where('user_id', $request->user_id)
            ->first();

        if (!$member) {
            return response()->json(['error' => 'User is not a member of this group'], 422);
        }

        $member->update(['role' => $request->role]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($group)
            ->log("Assigned role {$request->role} to member");

        return response()->json(['message' => 'Role assigned successfully']);
    }

    public function supervisorGroups()
    {
        $groups = Group::with(['creator', 'activeMembers.user.studentProfile', 'project'])
            ->whereHas('project', function ($query) {
                $query->where('supervisor_id', Auth::id());
            })
            ->get();

        return response()->json($groups);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Group;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with(['supervisor', 'group.activeMembers.user', 'milestones']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by supervisor
        if ($request->has('supervisor_id')) {
            $query->where('supervisor_id', $request->supervisor_id);
        }

        // Filter by course
        if ($request->has('course_code')) {
            $query->where('course_code', $request->course_code);
        }

        $projects = $query->paginate(15);

        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'course_code' => 'required|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'priority' => 'required|in:low,medium,high,urgent',
            'max_grade' => 'required|numeric|min:0|max:100',
            'requirements' => 'nullable|array',
            'deliverables' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'supervisor_id' => Auth::id(),
            'course_code' => $request->course_code,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'priority' => $request->priority,
            'max_grade' => $request->max_grade,
            'requirements' => $request->requirements,
            'deliverables' => $request->deliverables,
            'status' => 'draft',
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($project)
            ->log('Created project');

        return response()->json([
            'message' => 'Project created successfully',
            'project' => $project->load(['supervisor', 'group', 'milestones'])
        ], 201);
    }

    public function show(Project $project)
    {
        $project->load([
            'supervisor',
            'group.activeMembers.user.studentProfile',
            'tasks.assignee',
            'milestones',
            'peerEvaluations.evaluator',
            'peerEvaluations.evaluated'
        ]);

        return response()->json($project);
    }

    public function update(Request $request, Project $project)
    {
        // Check if user is supervisor or admin
        if ($project->supervisor_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|in:draft,active,in_progress,completed,cancelled',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'final_grade' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $project->update($request->only([
            'title', 'description', 'status', 'priority', 
            'start_date', 'end_date', 'final_grade'
        ]));

        activity()
            ->causedBy(Auth::user())
            ->performedOn($project)
            ->log('Updated project');

        return response()->json([
            'message' => 'Project updated successfully',
            'project' => $project->fresh()
        ]);
    }

    public function destroy(Project $project)
    {
        // Check if user is supervisor or admin
        if ($project->supervisor_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $project->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($project)
            ->log('Deleted project');

        return response()->json(['message' => 'Project deleted successfully']);
    }

    public function myProjects()
    {
        $projects = Project::whereHas('group.activeMembers', function ($query) {
            $query->where('user_id', Auth::id());
        })->with(['supervisor', 'group', 'tasks', 'milestones'])->get();

        return response()->json($projects);
    }

    public function supervisedProjects()
    {
        $projects = Project::where('supervisor_id', Auth::id())
            ->with(['group.activeMembers.user.studentProfile', 'tasks', 'milestones'])
            ->get();

        return response()->json($projects);
    }

    public function assignGroup(Request $request, Project $project)
    {
        // Check if user is supervisor or admin
        if ($project->supervisor_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'group_id' => 'required|exists:groups,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $group = Group::findOrFail($request->group_id);

        // Check if group is already assigned to another project
        if ($group->project_id && $group->project_id !== $project->id) {
            return response()->json(['error' => 'Group is already assigned to another project'], 422);
        }

        $project->update(['group_id' => $group->id]);
        $group->update(['status' => 'active']);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($project)
            ->log("Assigned group {$group->name} to project");

        return response()->json(['message' => 'Group assigned successfully']);
    }

    public function updateProgress(Request $request, Project $project)
    {
        // Check if user is supervisor, group member, or admin
        $isAuthorized = $project->supervisor_id === Auth::id() || 
                       Auth::user()->hasRole('admin') ||
                       $project->group && $project->group->activeMembers()->where('user_id', Auth::id())->exists();

        if (!$isAuthorized) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'progress_percentage' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $project->update(['progress_percentage' => $request->progress_percentage]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($project)
            ->log('Updated project progress');

        return response()->json(['message' => 'Progress updated successfully']);
    }

    public function getMilestones(Project $project)
    {
        $milestones = $project->milestones()->orderBy('order')->get();

        return response()->json($milestones);
    }

    public function createMilestone(Request $request, Project $project)
    {
        // Check if user is supervisor or admin
        if ($project->supervisor_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'order' => 'nullable|integer|min:0',
            'deliverables' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $milestone = $project->milestones()->create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'order' => $request->order ?? 0,
            'deliverables' => $request->deliverables,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($milestone)
            ->log('Created milestone');

        return response()->json([
            'message' => 'Milestone created successfully',
            'milestone' => $milestone
        ], 201);
    }

    public function updateMilestone(Request $request, Project $project, Milestone $milestone)
    {
        // Check if milestone belongs to project
        if ($milestone->project_id !== $project->id) {
            return response()->json(['error' => 'Milestone does not belong to this project'], 422);
        }

        // Check if user is supervisor, group member, or admin
        $isAuthorized = $project->supervisor_id === Auth::id() || 
                       Auth::user()->hasRole('admin') ||
                       $project->group && $project->group->activeMembers()->where('user_id', Auth::id())->exists();

        if (!$isAuthorized) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed,overdue',
            'progress_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $milestone->update($request->only([
            'title', 'description', 'status', 'progress_percentage'
        ]));

        if ($request->status === 'completed') {
            $milestone->update(['completed_at' => now()]);
        }

        activity()
            ->causedBy(Auth::user())
            ->performedOn($milestone)
            ->log('Updated milestone');

        return response()->json(['message' => 'Milestone updated successfully']);
    }

    public function deleteMilestone(Project $project, Milestone $milestone)
    {
        // Check if milestone belongs to project
        if ($milestone->project_id !== $project->id) {
            return response()->json(['error' => 'Milestone does not belong to this project'], 422);
        }

        // Check if user is supervisor or admin
        if ($project->supervisor_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $milestone->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($milestone)
            ->log('Deleted milestone');

        return response()->json(['message' => 'Milestone deleted successfully']);
    }

    public function provideFeedback(Request $request, Project $project)
    {
        // Check if user is supervisor
        if ($project->supervisor_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'feedback' => 'required|string',
            'type' => 'required|in:general,milestone,task',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create notification for group members
        if ($project->group) {
            foreach ($project->group->activeMembers as $member) {
                $member->user->notifications()->create([
                    'title' => 'Project Feedback',
                    'message' => "Supervisor provided feedback on project: {$project->title}",
                    'type' => 'project',
                    'action_url' => "/projects/{$project->id}",
                ]);
            }
        }

        activity()
            ->causedBy(Auth::user())
            ->performedOn($project)
            ->log('Provided project feedback');

        return response()->json(['message' => 'Feedback provided successfully']);
    }
}

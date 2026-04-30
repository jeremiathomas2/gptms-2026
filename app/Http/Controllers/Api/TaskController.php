<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['project', 'assignee', 'creator']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by project
        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Filter by assignee
        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Filter by overdue tasks
        if ($request->boolean('overdue')) {
            $query->overdue();
        }

        $tasks = $query->orderBy('order')->paginate(20);

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'estimated_hours' => 'nullable|integer|min:0',
            'due_date' => 'nullable|date',
            'dependencies' => 'nullable|array',
            'tags' => 'nullable|array',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if user has permission to create task for this project
        $project = Project::findOrFail($request->project_id);
        $isAuthorized = $project->supervisor_id === Auth::id() || 
                       Auth::user()->hasRole('admin') ||
                       ($project->group && $project->group->activeMembers()->where('user_id', Auth::id())->exists());

        if (!$isAuthorized) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'created_by' => Auth::id(),
            'priority' => $request->priority,
            'estimated_hours' => $request->estimated_hours,
            'due_date' => $request->due_date,
            'dependencies' => $request->dependencies,
            'tags' => $request->tags,
            'order' => $request->order ?? 0,
        ]);

        // Create notification for assignee
        if ($task->assigned_to && $task->assigned_to !== Auth::id()) {
            $task->assignee->notifications()->create([
                'title' => 'New Task Assigned',
                'message' => "You have been assigned a new task: {$task->title}",
                'type' => 'task',
                'action_url' => "/tasks/{$task->id}",
            ]);
        }

        activity()
            ->causedBy(Auth::user())
            ->performedOn($task)
            ->log('Created task');

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task->load(['project', 'assignee', 'creator'])
        ], 201);
    }

    public function show(Task $task)
    {
        $task->load([
            'project.supervisor',
            'assignee.studentProfile',
            'creator',
            'dependencies'
        ]);

        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        // Check if user has permission to update this task
        $isAuthorized = $task->project->supervisor_id === Auth::id() || 
                       Auth::user()->hasRole('admin') ||
                       $task->assigned_to === Auth::id() ||
                       $task->created_by === Auth::id() ||
                       ($task->project->group && $task->project->group->activeMembers()->where('user_id', Auth::id())->exists());

        if (!$isAuthorized) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'estimated_hours' => 'nullable|integer|min:0',
            'actual_hours' => 'nullable|integer|min:0',
            'due_date' => 'nullable|date',
            'dependencies' => 'nullable|array',
            'tags' => 'nullable|array',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $task->update($request->only([
            'title', 'description', 'priority', 'estimated_hours', 
            'actual_hours', 'due_date', 'dependencies', 'tags', 'order'
        ]));

        activity()
            ->causedBy(Auth::user())
            ->performedOn($task)
            ->log('Updated task');

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task->fresh()
        ]);
    }

    public function destroy(Task $task)
    {
        // Check if user has permission to delete this task
        $isAuthorized = $task->project->supervisor_id === Auth::id() || 
                       Auth::user()->hasRole('admin') ||
                       $task->created_by === Auth::id();

        if (!$isAuthorized) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($task)
            ->log('Deleted task');

        return response()->json(['message' => 'Task deleted successfully']);
    }

    public function projectTasks(Project $project)
    {
        // Check if user has permission to view project tasks
        $isAuthorized = $project->supervisor_id === Auth::id() || 
                       Auth::user()->hasRole('admin') ||
                       ($project->group && $project->group->activeMembers()->where('user_id', Auth::id())->exists());

        if (!$isAuthorized) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $tasks = $project->tasks()
            ->with(['assignee', 'creator'])
            ->orderBy('order')
            ->get();

        return response()->json($tasks);
    }

    public function myTasks()
    {
        $tasks = Task::where('assigned_to', Auth::id())
            ->with(['project', 'creator'])
            ->orderBy('due_date')
            ->get();

        return response()->json($tasks);
    }

    public function assignTask(Request $request, Task $task)
    {
        // Check if user has permission to assign this task
        $isAuthorized = $task->project->supervisor_id === Auth::id() || 
                       Auth::user()->hasRole('admin') ||
                       $task->created_by === Auth::id();

        if (!$isAuthorized) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $oldAssignee = $task->assigned_to;
        $task->update(['assigned_to' => $request->user_id]);

        // Create notification for new assignee
        if ($request->user_id !== Auth::id()) {
            $user = User::find($request->user_id);
            $user->notifications()->create([
                'title' => 'Task Assigned',
                'message' => "You have been assigned to task: {$task->title}",
                'type' => 'task',
                'action_url' => "/tasks/{$task->id}",
            ]);
        }

        activity()
            ->causedBy(Auth::user())
            ->performedOn($task)
            ->log("Assigned task to user {$request->user_id}");

        return response()->json(['message' => 'Task assigned successfully']);
    }

    public function updateStatus(Request $request, Task $task)
    {
        // Check if user has permission to update task status
        $isAuthorized = $task->assigned_to === Auth::id() || 
                       $task->project->supervisor_id === Auth::id() || 
                       Auth::user()->hasRole('admin') ||
                       $task->created_by === Auth::id();

        if (!$isAuthorized) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:todo,in_progress,review,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $oldStatus = $task->status;
        $task->update(['status' => $request->status]);

        if ($request->status === 'completed') {
            $task->update(['completed_at' => now()]);
            
            // Update member's task completion count
            if ($task->assigned_to) {
                $member = $task->assignee->groupMemberships()
                    ->where('group_id', $task->project->group_id)
                    ->first();
                if ($member) {
                    $member->increment('tasks_completed');
                }
            }
        }

        activity()
            ->causedBy(Auth::user())
            ->performedOn($task)
            ->log("Changed status from {$oldStatus} to {$request->status}");

        return response()->json(['message' => 'Task status updated successfully']);
    }

    public function addComment(Request $request, Task $task)
    {
        // Check if user has permission to comment on this task
        $isAuthorized = $task->assigned_to === Auth::id() || 
                       $task->project->supervisor_id === Auth::id() || 
                       Auth::user()->hasRole('admin') ||
                       $task->created_by === Auth::id() ||
                       ($task->project->group && $task->project->group->activeMembers()->where('user_id', Auth::id())->exists());

        if (!$isAuthorized) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Store comment in activity log for now (could be separate comments table)
        activity()
            ->causedBy(Auth::user())
            ->performedOn($task)
            ->withProperties(['comment' => $request->comment])
            ->log('Added comment to task');

        // Notify relevant users
        if ($task->assigned_to && $task->assigned_to !== Auth::id()) {
            $task->assignee->notifications()->create([
                'title' => 'New Comment on Task',
                'message' => "New comment on task: {$task->title}",
                'type' => 'task',
                'action_url' => "/tasks/{$task->id}",
            ]);
        }

        if ($task->created_by && $task->created_by !== Auth::id() && $task->created_by !== $task->assigned_to) {
            $task->creator->notifications()->create([
                'title' => 'New Comment on Task',
                'message' => "New comment on task: {$task->title}",
                'type' => 'task',
                'action_url' => "/tasks/{$task->id}",
            ]);
        }

        return response()->json(['message' => 'Comment added successfully']);
    }

    public function getComments(Task $task)
    {
        // Check if user has permission to view task comments
        $isAuthorized = $task->assigned_to === Auth::id() || 
                       $task->project->supervisor_id === Auth::id() || 
                       Auth::user()->hasRole('admin') ||
                       $task->created_by === Auth::id() ||
                       ($task->project->group && $task->project->group->activeMembers()->where('user_id', Auth::id())->exists());

        if (!$isAuthorized) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comments = ActivityLog::where('subject_type', 'Task')
            ->where('subject_id', $task->id)
            ->where('action', 'Added comment to task')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comments);
    }
}

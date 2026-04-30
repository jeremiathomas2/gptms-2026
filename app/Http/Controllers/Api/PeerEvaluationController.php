<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PeerEvaluation;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PeerEvaluationController extends Controller
{
    public function index(Request $request)
    {
        $query = PeerEvaluation::with(['evaluator', 'evaluated', 'project']);

        // Filter by project
        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Filter by evaluator
        if ($request->has('evaluator_id')) {
            $query->where('evaluator_id', $request->evaluator_id);
        }

        // Filter by evaluated
        if ($request->has('evaluated_id')) {
            $query->where('evaluated_id', $request->evaluated_id);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $evaluations = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($evaluations);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'evaluated_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'contribution_score' => 'required|integer|min:1|max:5',
            'teamwork_score' => 'required|integer|min:1|max:5',
            'communication_score' => 'required|integer|min:1|max:5',
            'quality_score' => 'required|integer|min:1|max:5',
            'timeliness_score' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if user is evaluating themselves
        if ($request->evaluated_id === Auth::id()) {
            return response()->json(['error' => 'Cannot evaluate yourself'], 422);
        }

        // Check if evaluator and evaluated are in the same project group
        $project = Project::findOrFail($request->project_id);
        if (!$project->group) {
            return response()->json(['error' => 'Project has no assigned group'], 422);
        }

        $evaluatorInGroup = $project->group->activeMembers()
            ->where('user_id', Auth::id())->exists();
        $evaluatedInGroup = $project->group->activeMembers()
            ->where('user_id', $request->evaluated_id)->exists();

        if (!$evaluatorInGroup || !$evaluatedInGroup) {
            return response()->json(['error' => 'Both users must be in the same project group'], 422);
        }

        // Check if evaluation already exists
        $existingEvaluation = PeerEvaluation::where('evaluator_id', Auth::id())
            ->where('evaluated_id', $request->evaluated_id)
            ->where('project_id', $request->project_id)
            ->first();

        if ($existingEvaluation) {
            return response()->json(['error' => 'Evaluation already exists for this user in this project'], 422);
        }

        $evaluation = PeerEvaluation::create([
            'evaluator_id' => Auth::id(),
            'evaluated_id' => $request->evaluated_id,
            'project_id' => $request->project_id,
            'contribution_score' => $request->contribution_score,
            'teamwork_score' => $request->teamwork_score,
            'communication_score' => $request->communication_score,
            'quality_score' => $request->quality_score,
            'timeliness_score' => $request->timeliness_score,
            'comments' => $request->comments,
            'status' => 'draft',
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($evaluation)
            ->log('Created peer evaluation');

        return response()->json([
            'message' => 'Peer evaluation created successfully',
            'evaluation' => $evaluation->load(['evaluator', 'evaluated', 'project'])
        ], 201);
    }

    public function show(PeerEvaluation $evaluation)
    {
        // Check if user is evaluator, evaluated, or admin/supervisor
        $isAuthorized = $evaluation->evaluator_id === Auth::id() || 
                       $evaluation->evaluated_id === Auth::id() ||
                       Auth::user()->hasRole('admin') ||
                       ($evaluation->project->supervisor_id === Auth::id());

        if (!$isAuthorized) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $evaluation->load(['evaluator', 'evaluated', 'project']);

        return response()->json($evaluation);
    }

    public function update(Request $request, PeerEvaluation $evaluation)
    {
        // Check if user is evaluator
        if ($evaluation->evaluator_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if evaluation is already submitted
        if ($evaluation->status === 'submitted') {
            return response()->json(['error' => 'Cannot update submitted evaluation'], 422);
        }

        $validator = Validator::make($request->all(), [
            'contribution_score' => 'required|integer|min:1|max:5',
            'teamwork_score' => 'required|integer|min:1|max:5',
            'communication_score' => 'required|integer|min:1|max:5',
            'quality_score' => 'required|integer|min:1|max:5',
            'timeliness_score' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $evaluation->update([
            'contribution_score' => $request->contribution_score,
            'teamwork_score' => $request->teamwork_score,
            'communication_score' => $request->communication_score,
            'quality_score' => $request->quality_score,
            'timeliness_score' => $request->timeliness_score,
            'comments' => $request->comments,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($evaluation)
            ->log('Updated peer evaluation');

        return response()->json([
            'message' => 'Peer evaluation updated successfully',
            'evaluation' => $evaluation->fresh()
        ]);
    }

    public function destroy(PeerEvaluation $evaluation)
    {
        // Check if user is evaluator or admin
        if ($evaluation->evaluator_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if evaluation is already submitted
        if ($evaluation->status === 'submitted') {
            return response()->json(['error' => 'Cannot delete submitted evaluation'], 422);
        }

        $evaluation->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($evaluation)
            ->log('Deleted peer evaluation');

        return response()->json(['message' => 'Peer evaluation deleted successfully']);
    }

    public function projectEvaluations(Project $project)
    {
        // Check if user is in project group or is supervisor/admin
        $isAuthorized = $project->supervisor_id === Auth::id() || 
                       Auth::user()->hasRole('admin') ||
                       ($project->group && $project->group->activeMembers()->where('user_id', Auth::id())->exists());

        if (!$isAuthorized) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $evaluations = $project->peerEvaluations()
            ->with(['evaluator', 'evaluated'])
            ->get();

        return response()->json($evaluations);
    }

    public function myEvaluations()
    {
        $evaluations = PeerEvaluation::where('evaluator_id', Auth::id())
            ->with(['evaluated', 'project'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($evaluations);
    }

    public function receivedEvaluations(Project $project)
    {
        // Check if user is in project group
        if (!$project->group || !$project->group->activeMembers()->where('user_id', Auth::id())->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $evaluations = PeerEvaluation::where('evaluated_id', Auth::id())
            ->where('project_id', $project->id)
            ->with(['evaluator', 'project'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($evaluations);
    }

    public function submitEvaluation(Request $request, PeerEvaluation $evaluation)
    {
        // Check if user is evaluator
        if ($evaluation->evaluator_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if evaluation is already submitted
        if ($evaluation->status === 'submitted') {
            return response()->json(['error' => 'Evaluation already submitted'], 422);
        }

        $evaluation->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($evaluation)
            ->log('Submitted peer evaluation');

        return response()->json(['message' => 'Evaluation submitted successfully']);
    }

    public function getEvaluationSummary(Project $project)
    {
        // Check if user is supervisor or admin
        if ($project->supervisor_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $evaluations = $project->peerEvaluations()->submitted()->get();

        $summary = [
            'total_evaluations' => $evaluations->count(),
            'average_scores' => [
                'contribution' => $evaluations->avg('contribution_score'),
                'teamwork' => $evaluations->avg('teamwork_score'),
                'communication' => $evaluations->avg('communication_score'),
                'quality' => $evaluations->avg('quality_score'),
                'timeliness' => $evaluations->avg('timeliness_score'),
            ],
            'individual_scores' => $evaluations->groupBy('evaluated_id')
                ->map(function ($userEvaluations) {
                    return [
                        'evaluated_user' => $userEvaluations->first()->evaluated,
                        'average_score' => $userEvaluations->avg('overall_score'),
                        'evaluation_count' => $userEvaluations->count(),
                        'scores' => [
                            'contribution' => $userEvaluations->avg('contribution_score'),
                            'teamwork' => $userEvaluations->avg('teamwork_score'),
                            'communication' => $userEvaluations->avg('communication_score'),
                            'quality' => $userEvaluations->avg('quality_score'),
                            'timeliness' => $userEvaluations->avg('timeliness_score'),
                        ]
                    ];
                })
        ];

        return response()->json($summary);
    }
}

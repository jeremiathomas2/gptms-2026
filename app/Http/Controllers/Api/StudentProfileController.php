<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentProfile::with('user');

        // Filter by major
        if ($request->has('major')) {
            $query->where('major', $request->major);
        }

        // Filter by GPA range
        if ($request->has('gpa_min')) {
            $query->where('gpa', '>=', $request->gpa_min);
        }
        if ($request->has('gpa_max')) {
            $query->where('gpa', '<=', $request->gpa_max);
        }

        // Filter by semester
        if ($request->has('semester')) {
            $query->where('semester', $request->semester);
        }

        $profiles = $query->paginate(20);

        return response()->json($profiles);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|string|max:20|unique:student_profiles',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'major' => 'nullable|string|max:100',
            'semester' => 'nullable|integer|min:1|max:12',
            'bio' => 'nullable|string|max:1000',
            'preferred_group_size' => 'nullable|integer|min:2|max:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $profile = StudentProfile::create([
            'user_id' => Auth::id(),
            'student_id' => $request->student_id,
            'gpa' => $request->gpa ?? 0.00,
            'major' => $request->major,
            'semester' => $request->semester ?? 1,
            'bio' => $request->bio,
            'preferred_group_size' => $request->preferred_group_size ?? 4,
            'total_projects' => 0,
            'average_rating' => 0.00,
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($profile)
            ->log('Created student profile');

        return response()->json([
            'message' => 'Student profile created successfully',
            'profile' => $profile->load('user')
        ], 201);
    }

    public function show(StudentProfile $profile)
    {
        $profile->load(['user', 'groupMemberships.group']);

        return response()->json($profile);
    }

    public function update(Request $request, StudentProfile $profile)
    {
        // Check if profile belongs to user or user is admin
        if ($profile->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'student_id' => 'required|string|max:20|unique:student_profiles,student_id,' . $profile->id,
            'gpa' => 'nullable|numeric|min:0|max:4',
            'major' => 'nullable|string|max:100',
            'semester' => 'nullable|integer|min:1|max:12',
            'bio' => 'nullable|string|max:1000',
            'preferred_group_size' => 'nullable|integer|min:2|max:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $profile->update($request->only([
            'student_id', 'gpa', 'major', 'semester', 
            'bio', 'preferred_group_size'
        ]));

        activity()
            ->causedBy(Auth::user())
            ->performedOn($profile)
            ->log('Updated student profile');

        return response()->json([
            'message' => 'Student profile updated successfully',
            'profile' => $profile->fresh()
        ]);
    }

    public function destroy(StudentProfile $profile)
    {
        // Check if profile belongs to user or user is admin
        if ($profile->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $profile->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($profile)
            ->log('Deleted student profile');

        return response()->json(['message' => 'Student profile deleted successfully']);
    }

    public function getSkills()
    {
        $profile = Auth::user()->studentProfile;
        
        if (!$profile) {
            return response()->json(['error' => 'Student profile not found'], 404);
        }

        return response()->json($profile->skills ?? []);
    }

    public function updateSkills(Request $request)
    {
        $profile = Auth::user()->studentProfile;
        
        if (!$profile) {
            return response()->json(['error' => 'Student profile not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'skills' => 'required|array',
            'skills.*.name' => 'required|string|max:100',
            'skills.*.proficiency' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $profile->update(['skills' => $request->skills]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($profile)
            ->log('Updated skills');

        return response()->json(['message' => 'Skills updated successfully']);
    }

    public function getAvailability()
    {
        $profile = Auth::user()->studentProfile;
        
        if (!$profile) {
            return response()->json(['error' => 'Student profile not found'], 404);
        }

        return response()->json($profile->availability ?? []);
    }

    public function updateAvailability(Request $request)
    {
        $profile = Auth::user()->studentProfile;
        
        if (!$profile) {
            return response()->json(['error' => 'Student profile not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'availability' => 'required|array',
            'availability.*.day' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'availability.*.time_slots' => 'required|array',
            'availability.*.time_slots.*.start' => 'required|string',
            'availability.*.time_slots.*.end' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $profile->update(['availability' => $request->availability]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($profile)
            ->log('Updated availability');

        return response()->json(['message' => 'Availability updated successfully']);
    }

    public function getPersonalityTraits()
    {
        $profile = Auth::user()->studentProfile;
        
        if (!$profile) {
            return response()->json(['error' => 'Student profile not found'], 404);
        }

        return response()->json($profile->personality_traits ?? []);
    }

    public function updatePersonalityTraits(Request $request)
    {
        $profile = Auth::user()->studentProfile;
        
        if (!$profile) {
            return response()->json(['error' => 'Student profile not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'personality_traits' => 'required|array',
            'personality_traits.work_style' => 'required|string|in:independent,collaborative,leader,follower',
            'personality_traits.communication_preference' => 'required|string|in:written,verbal,visual',
            'personality_traits.time_management' => 'required|string|in:early_planner,last_minute,flexible',
            'personality_traits.conflict_resolution' => 'required|string|in:confrontational,avoidant,collaborative,compromising',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $profile->update(['personality_traits' => $request->personality_traits]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($profile)
            ->log('Updated personality traits');

        return response()->json(['message' => 'Personality traits updated successfully']);
    }

    public function getAvailableSkills()
    {
        $skills = Skill::active()->get()->groupBy('category');

        return response()->json($skills);
    }
}

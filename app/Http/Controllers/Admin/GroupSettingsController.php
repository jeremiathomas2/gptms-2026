<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GroupSettings;
use App\Models\Group;
use App\Models\User;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupSettingsController extends Controller
{
    public function index()
    {
        $settings = GroupSettings::getCurrent();
        $groups = Group::with('members')->latest()->get();
        
        return view('admin.group-settings', compact('settings', 'groups'));
    }

    public function update(Request $request)
    {
        $action = $request->input('action');
        
        if ($action === 'start_countdown') {
            return $this->startCountdown($request);
        } elseif ($action === 'stop_countdown') {
            return $this->stopCountdown($request);
        }
        
        return $this->saveSettings($request);
    }

    private function saveSettings(Request $request)
    {
        $validated = $request->validate([
            'participants_per_group' => 'required|integer|min:2|max:10',
            'countdown_minutes' => 'required|integer|min:1|max:1440',
            'balance_by_gender' => 'boolean',
            'balance_by_skills' => 'boolean',
            'auto_create_groups' => 'boolean',
        ]);

        $settings = GroupSettings::getCurrent();
        $settings->fill($validated);
        $settings->updated_by = session('user.id');
        
        // If countdown is active, update end time
        if ($settings->is_active && $settings->countdown_end_time) {
            $settings->countdown_end_time = now()->addMinutes($validated['countdown_minutes']);
        }
        
        $settings->save();

        return response()->json([
            'success' => true,
            'message' => 'Settings saved successfully'
        ]);
    }

    private function startCountdown(Request $request)
    {
        \Log::info('Start countdown method called');
        \Log::info('Request data:', $request->all());
        
        $validated = $request->validate([
            'participants_per_group' => 'required|integer|min:2|max:10',
            'countdown_minutes' => 'required|integer|min:1|max:1440',
            'balance_by_gender' => 'boolean',
            'balance_by_skills' => 'boolean',
            'auto_create_groups' => 'boolean',
        ]);

        \Log::info('Validated data:', $validated);

        $settings = GroupSettings::getCurrent();
        $settings->fill($validated);
        $settings->is_active = true;
        $settings->countdown_end_time = now()->addMinutes($validated['countdown_minutes']);
        $settings->created_by = session('user.id');
        $settings->updated_by = session('user.id');
        
        \Log::info('Settings before save:', $settings->toArray());
        $settings->save();
        \Log::info('Settings saved successfully');

        return response()->json([
            'success' => true,
            'message' => 'Countdown started successfully'
        ]);
    }

    private function stopCountdown(Request $request)
    {
        $settings = GroupSettings::getCurrent();
        if ($settings) {
            $settings->is_active = false;
            $settings->countdown_end_time = null;
            $settings->updated_by = session('user.id');
            $settings->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Countdown stopped successfully'
        ]);
    }

    public function createGroups()
    {
        $settings = GroupSettings::getCurrent();
        if (!$settings) {
            return response()->json([
                'success' => false,
                'message' => 'No group settings found'
            ]);
        }

        // Get all students
        $students = User::whereHas('roles', function($query) {
            $query->where('name', 'student');
        })->with(['studentProfile', 'skills'])->get();

        if ($students->count() < $settings->participants_per_group) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough students to create groups'
            ]);
        }

        // Clear existing groups
        GroupMember::truncate();
        Group::truncate();

        // Create balanced groups
        $groupsCreated = $this->createBalancedGroups($students, $settings);

        // Stop countdown after creating groups
        $settings->is_active = false;
        $settings->countdown_end_time = null;
        $settings->save();

        return response()->json([
            'success' => true,
            'message' => "Successfully created {$groupsCreated} groups",
            'groups_created' => $groupsCreated
        ]);
    }

    private function createBalancedGroups($students, $settings)
    {
        $participantsPerGroup = $settings->participants_per_group;
        
        // Sort students based on balancing criteria
        if ($settings->balance_by_gender) {
            $students = $this->sortByGender($students);
        }
        
        if ($settings->balance_by_skills) {
            $students = $this->sortBySkills($students);
        }

        // Create groups using round-robin distribution
        $groups = [];
        $groupIndex = 0;
        
        foreach ($students as $student) {
            if (!isset($groups[$groupIndex])) {
                $group = Group::create([
                    'name' => 'Group ' . ($groupIndex + 1),
                    'created_by' => session('user.id'),
                ]);
                $groups[$groupIndex] = $group;
            }

            GroupMember::create([
                'group_id' => $groups[$groupIndex]->id,
                'user_id' => $student->id,
                'joined_at' => now(),
            ]);

            $groupIndex = ($groupIndex + 1) % $participantsPerGroup;
        }

        return count($groups);
    }

    private function sortByGender($students)
    {
        // Separate by gender
        $males = $students->filter(function($student) {
            return $student->studentProfile && $student->studentProfile->gender === 'male';
        });

        $females = $students->filter(function($student) {
            return $student->studentProfile && $student->studentProfile->gender === 'female';
        });

        $others = $students->filter(function($student) {
            return !$student->studentProfile || !in_array($student->studentProfile->gender, ['male', 'female']);
        });

        // Interleave for balance
        $balanced = collect();
        $maxCount = max($males->count(), $females->count(), $others->count());

        for ($i = 0; $i < $maxCount; $i++) {
            if ($males->has($i)) $balanced->push($males[$i]);
            if ($females->has($i)) $balanced->push($females[$i]);
            if ($others->has($i)) $balanced->push($others[$i]);
        }

        return $balanced;
    }

    private function sortBySkills($students)
    {
        // Sort by skill diversity
        return $students->sortBy(function($student) {
            $skillCount = $student->skills->count();
            return -$skillCount; // Higher skill count first
        })->values();
    }

    public function countdownStatus()
    {
        $settings = GroupSettings::getCurrent();
        
        if (!$settings || !$settings->isCountdownRunning()) {
            return response()->json([
                'remaining_time' => 0,
                'is_active' => false,
                'total_students' => User::whereHas('roles', function($query) {
                    $query->where('name', 'student');
                })->count(),
                'participants_per_group' => $settings->participants_per_group ?? 4
            ]);
        }

        return response()->json([
            'remaining_time' => $settings->getRemainingTime(),
            'is_active' => true,
            'formatted_time' => $settings->formatted_remaining_time,
            'total_students' => User::whereHas('roles', function($query) {
                $query->where('name', 'student');
            })->count(),
            'participants_per_group' => $settings->participants_per_group ?? 4
        ]);
    }
}

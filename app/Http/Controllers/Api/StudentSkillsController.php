<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StudentSkillsController extends Controller
{
    /**
     * Get student's current skills
     */
    public function index(Request $request)
    {
        try {
            // Use session-based authentication
            $user = session('user');
            
            if (!$user || !isset($user['id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Get skills from student profile or survey
            $skills = [];
            
            // Check if user has survey data
            $survey = \App\Models\StudentSkillsSurvey::where('user_id', $user['id'])->first();
            if ($survey && $survey->skills) {
                $surveySkills = json_decode($survey->skills, true);
                if (is_array($surveySkills)) {
                    $skills = $surveySkills;
                }
            }
            
            // Also check if user has skills in profile (if applicable)
            if (isset($user['skills'])) {
                $profileSkills = is_array($user['skills']) ? $user['skills'] : json_decode($user['skills'], true);
                if (is_array($profileSkills)) {
                    // Merge and deduplicate skills
                    $skills = array_unique(array_merge($skills, $profileSkills));
                }
            }
            
            return response()->json([
                'success' => true,
                'skills' => array_values($skills)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving skills: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Save student's skills
     */
    public function save(Request $request)
    {
        try {
            $request->validate([
                'skills' => 'required|array|min:1',
                'skills.*' => 'string|max:50'
            ]);
            
            // Use session-based authentication
            $user = session('user');
            
            if (!$user || !isset($user['id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            
            $skills = $request->skills;
            
            // Update or create survey with new skills
            $survey = \App\Models\StudentSkillsSurvey::updateOrCreate(
                ['user_id' => $user['id']],
                [
                    'skills' => json_encode($skills, JSON_UNESCAPED_UNICODE),
                    'completed_at' => now()
                ]
            );
            
            return response()->json([
                'success' => true,
                'message' => 'Skills saved successfully',
                'skills' => $skills
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving skills: ' . $e->getMessage()
            ], 500);
        }
    }
}

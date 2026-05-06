<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentSkillsSurvey;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class StudentSkillsSurveyController extends Controller
{
    /**
     * Store a new survey
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'skills' => 'required|array|min:1',
            'experience_level' => 'required|in:beginner,intermediate,advanced',
            'interests' => 'required|array|min:1',
            'project_type' => 'required|in:individual,team,both',
            'project_duration' => 'required|in:short,medium,long',
            'goals' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Try multiple authentication methods
            $userId = null;
            $user = null;
            
            // Method 1: Try standard Laravel Auth
            if (Auth::check()) {
                $user = Auth::user();
                $userId = $user->id;
                \Log::info('Using standard Laravel Auth');
            }
            // Method 2: Try session-based user data
            elseif (session('user') && isset(session('user')['id'])) {
                $sessionUser = session('user');
                $userId = $sessionUser['id'];
                \Log::info('Using session-based authentication');
            }
            // Method 3: Try session user_id directly
            elseif (session('user_id')) {
                $userId = session('user_id');
                \Log::info('Using session user_id');
            }
            
            if (!$userId) {
                \Log::error('Survey submission failed - no valid authentication found', [
                    'auth_check' => Auth::check(),
                    'session_user' => session('user'),
                    'session_user_id' => session('user_id'),
                    'session_data' => session()->all(),
                    'session_id' => session()->getId()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to submit the survey.',
                    'debug' => [
                        'auth_check' => Auth::check(),
                        'session_user' => session('user'),
                        'session_user_id' => session('user_id')
                    ]
                ], 401);
            }
            
            \Log::info('Survey authentication check:', [
                'session_user' => $user,
                'user_id' => $userId,
                'session_id' => session()->getId(),
                'request_headers' => $request->headers->all(),
                'request_ip' => $request->ip(),
                'request_user_agent' => $request->userAgent()
            ]);
            
            // Debug: Log received data
            \Log::info('Survey submission data:', [
                'all_data' => $request->all(),
                'skills' => $request->skills,
                'experience_level' => $request->experience_level,
                'interests' => $request->interests,
                'project_type' => $request->project_type,
                'project_duration' => $request->project_duration,
                'goals' => $request->goals,
                'user_id' => $userId,
                'authenticated' => true
            ]);
            
            // Create or update survey
            $surveyData = [
                'skills' => is_array($request->skills) ? json_encode($request->skills, JSON_UNESCAPED_UNICODE) : $request->skills,
                'experience_level' => $request->experience_level,
                'interests' => is_array($request->interests) ? json_encode($request->interests, JSON_UNESCAPED_UNICODE) : $request->interests,
                'project_type' => $request->project_type,
                'project_duration' => $request->project_duration,
                'goals' => $request->goals,
                'completed_at' => now(),
            ];
            
            // Debug: Log the data types
            \Log::info('Survey data types:', [
                'skills_type' => gettype($request->skills),
                'interests_type' => gettype($request->interests),
                'skills_is_array' => is_array($request->skills),
                'interests_is_array' => is_array($request->interests),
                'skills_json' => is_array($request->skills) ? json_encode($request->skills, JSON_UNESCAPED_UNICODE) : 'not_array',
                'interests_json' => is_array($request->interests) ? json_encode($request->interests, JSON_UNESCAPED_UNICODE) : 'not_array'
            ]);
            
            \Log::info('Survey data to be stored:', $surveyData);
            
            \Log::info('About to create StudentSkillsSurvey object');
            
            // Temporarily remove casting to avoid conflicts
            $survey = new StudentSkillsSurvey();
            
            \Log::info('Setting survey properties');
            $survey->user_id = $userId;
            $survey->skills = $surveyData['skills'];
            $survey->experience_level = $surveyData['experience_level'];
            $survey->interests = $surveyData['interests'];
            $survey->project_type = $surveyData['project_type'];
            $survey->project_duration = $surveyData['project_duration'];
            $survey->goals = $surveyData['goals'];
            $survey->completed_at = $surveyData['completed_at'];
            
            \Log::info('About to save survey', [
                'survey_object' => $survey->toArray(),
                'user_id_set' => $survey->user_id,
                'skills_set' => $survey->skills
            ]);
            
            $survey->save();
            
            \Log::info('Survey saved successfully');
            
            // Verify data was stored correctly
            $storedSurvey = StudentSkillsSurvey::where('user_id', $userId)->first();
            \Log::info('Stored survey data:', [
                'stored_skills' => $storedSurvey->skills,
                'stored_interests' => $storedSurvey->interests,
                'stored_experience_level' => $storedSurvey->experience_level,
                'stored_project_type' => $storedSurvey->project_type,
                'stored_project_duration' => $storedSurvey->project_duration,
                'stored_goals' => $storedSurvey->goals,
                'stored_completed_at' => $storedSurvey->completed_at,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Survey completed successfully',
                'data' => $storedSurvey
            ], 200);

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Survey completion error: ' . $e->getMessage(), [
                'exception_class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'user_id' => $userId ?? null,
                'session_data' => session()->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving your survey. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : 'Survey submission failed',
                'debug' => [
                    'exception_class' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]
            ], 500);
        }
    }

    /**
     * Get user's survey
     */
    public function show()
    {
        try {
            $survey = StudentSkillsSurvey::where('user_id', Auth::id())->first();
            
            \Log::info('Retrieved survey for user ' . Auth::id() . ':', [
                'survey_exists' => $survey ? true : false,
                'survey_data' => $survey ? $survey->toArray() : null
            ]);
            
            return response()->json([
                'success' => true,
                'data' => $survey
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error retrieving survey: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving survey: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if user has completed survey
     */
    public function check()
    {
        $completed = StudentSkillsSurvey::isCompletedByUser(Auth::id());
        
        return response()->json([
            'completed' => $completed,
            'message' => $completed ? 'Survey completed' : 'Survey not completed'
        ]);
    }
}

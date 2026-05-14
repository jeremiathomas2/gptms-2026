<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Survey;

class SurveyCompletionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Only check for students
        if ($user && (session('user.role') === 'student' || (method_exists($user, 'hasRole') && $user->hasRole('student')))) {
            // Check if student has completed survey
            $hasCompletedSurvey = Survey::isCompletedByUser($user->id);
            
            if (!$hasCompletedSurvey) {
                // Get or create survey record for this user
                $survey = Survey::getOrCreateForUser($user->id, $user->name);
                
                // Share survey data with view for popup
                view()->share('showSurveyPopup', true);
                view()->share('studentName', $user->name);
                view()->share('surveyId', $survey->id);
            }
        }
        
        return $next($request);
    }
}

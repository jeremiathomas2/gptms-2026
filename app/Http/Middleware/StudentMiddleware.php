<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        $user = session('user');
        if (!$user || !isset($user['logged_in']) || !$user['logged_in']) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            
            session(['url.intended' => $request->fullUrl()]);
            return redirect()->route('login')
                ->with('error', 'Please login to access this page.');
        }

        // Check if user is a student
        if ($user['role'] !== 'student') {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'Forbidden', 
                    'message' => 'This page is only accessible to students.'
                ], 403);
            }
            
            return redirect()->route('dashboard')
                ->with('error', 'This page is only accessible to students.');
        }

        return $next($request);
    }
}

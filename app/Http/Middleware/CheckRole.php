<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
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

        // Check if user has required role
        $userRole = $user['role'] ?? null;
        
        if (empty($roles) || !in_array($userRole, $roles)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'Forbidden', 
                    'message' => 'You do not have permission to access this resource.'
                ], 403);
            }
            
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}

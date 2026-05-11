<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RoleSwitchMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is trying to switch roles
        if ($request->has('switch_role') && $request->has('role')) {
            $user = Auth::user();
            $targetRole = $request->input('role');
            
            // Check if user has the target role
            if ($user && $user->hasRole($targetRole)) {
                // Store the switched role in session
                Session::put('active_role', $targetRole);
                
                // Flash success message
                Session::flash('success', "Switched to {$targetRole} role successfully");
            } else {
                Session::flash('error', 'You do not have permission to switch to this role');
            }
            
            // Redirect back to prevent form resubmission
            return redirect()->back();
        }
        
        // Set default active role if not set
        if (!Session::has('active_role') && Auth::check()) {
            $user = Auth::user();
            $primaryRole = $user->getRoleNames()->first();
            if ($primaryRole) {
                Session::put('active_role', $primaryRole);
            }
        }
        
        return $next($request);
    }
}

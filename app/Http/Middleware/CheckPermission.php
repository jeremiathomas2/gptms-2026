<?php

namespace App\Http\Middleware;

use App\Helpers\PermissionHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $userRole = session('user.role');
        
        if (!$userRole) {
            return Redirect::route('login')->with('error', 'Please login to continue.');
        }

        if (!PermissionHelper::hasPermission($permission, $userRole)) {
            // Log the unauthorized access attempt
            \Log::warning("Unauthorized access attempt", [
                'user_role' => $userRole,
                'permission' => $permission,
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);

            return Redirect::route('dashboard')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}

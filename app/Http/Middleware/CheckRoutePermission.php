<?php

namespace App\Http\Middleware;

use App\Helpers\PermissionHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CheckRoutePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userRole = session('user.role');
        
        if (!$userRole) {
            return Redirect::route('login')->with('error', 'Please login to continue.');
        }

        // Determine permission based on route
        $permission = $this->getPermissionFromRoute($request);
        
        if (!PermissionHelper::hasPermission($permission, $userRole)) {
            // Log the unauthorized access attempt
            \Log::warning("Unauthorized access attempt", [
                'user_role' => $userRole,
                'permission' => $permission,
                'route' => $request->route()->getName(),
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);

            return Redirect::route('dashboard')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }

    /**
     * Get permission name from current route
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    private function getPermissionFromRoute(Request $request)
    {
        $routeName = $request->route()->getName();
        
        // Map route names to permissions
        $permissionMap = [
            'admin.settings' => 'settings',
            'admin.settings.update' => 'settings',
            'users' => 'users',
            'projects' => 'projects',
            'analytics' => 'analytics',
            'reports' => 'reports',
            'messages' => 'messages',
        ];

        return $permissionMap[$routeName] ?? 'dashboard';
    }
}

<?php

namespace App\Http\Middleware;

use App\Services\ActivityLogger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log if user is authenticated and it's not an AJAX/API request for static content
        if (Auth::check() && !$this->shouldSkipLogging($request)) {
            $this->logRequestActivity($request, $response);
        }

        return $response;
    }

    /**
     * Determine if the request should be skipped from activity logging
     */
    private function shouldSkipLogging(Request $request): bool
    {
        // Skip AJAX requests that are not form submissions
        if ($request->ajax() && !$request->isMethod('POST')) {
            return true;
        }

        // Skip certain routes that don't need activity logging
        $skipRoutes = [
            'admin.countdown-status', // Status polling
            'admin.logs', // Viewing logs (don't log viewing logs)
            'dashboard', // Dashboard views can be too frequent
            'profile', // Profile views can be too frequent
        ];

        return in_array($request->route()?->getName(), $skipRoutes);
    }

    /**
     * Log the request activity
     */
    private function logRequestActivity(Request $request, Response $response): void
    {
        try {
            $user = Auth::user();
            $routeName = $request->route()?->getName();
            $method = $request->method();
            
            // Only log POST, PUT, PATCH, DELETE requests and specific GET requests
            if (!$this->shouldLogMethod($method, $routeName)) {
                return;
            }

            $action = $this->getActionFromRoute($routeName, $method);
            $description = $this->getDescriptionFromRoute($request, $routeName, $method);
            $subject = $this->getSubjectFromRoute($request, $routeName);
            $properties = $this->getPropertiesFromRequest($request, $response);

            if ($action && $description) {
                ActivityLogger::log($action, $description, $subject, $properties, $user);
            }
        } catch (\Exception $e) {
            // Don't let logging errors break the application
            \Log::error('Activity logging middleware error', [
                'error' => $e->getMessage(),
                'route' => $request->route()?->getName(),
                'method' => $request->method(),
            ]);
        }
    }

    /**
     * Determine if the HTTP method should be logged
     */
    private function shouldLogMethod(string $method, ?string $routeName): bool
    {
        // Always log POST, PUT, PATCH, DELETE
        if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return true;
        }

        // Only log specific GET routes
        $loggableGetRoutes = [
            'admin.settings',
            'admin.group-settings',
            'users',
            'groups.all',
            'projects',
            'analytics',
            'reports',
        ];

        return $method === 'GET' && in_array($routeName, $loggableGetRoutes);
    }

    /**
     * Get action from route name and method
     */
    private function getActionFromRoute(?string $routeName, string $method): ?string
    {
        if (!$routeName) {
            return null;
        }

        $actionMap = [
            // Authentication
            'login' => 'login',
            'logout' => 'logout',
            'register' => 'create',

            // Admin actions
            'admin.settings' => $method === 'POST' ? 'update' : 'view',
            'admin.settings.update' => 'update',
            'admin.group-settings' => $method === 'POST' ? 'update' : 'view',
            'admin.group-settings.update' => 'update',
            'admin.create-groups' => 'create',
            'admin.users.toggle' => 'update',
            'admin.users.delete' => 'delete',

            // User management
            'users' => $method === 'POST' ? 'create' : 'view',
            'users.update' => 'update',
            'users.delete' => 'delete',

            // Group management
            'groups.all' => 'view',
            'groups.my' => 'view',
            'groups.create' => 'create',
            'groups.join' => 'update',
            'groups.leave' => 'update',
            'groups.delete' => 'delete',

            // Project management
            'projects' => $method === 'POST' ? 'create' : 'view',
            'projects.update' => 'update',
            'projects.delete' => 'delete',

            // Reports and analytics
            'analytics' => 'view',
            'reports' => 'view',
            'reports.generate' => 'create',

            // Messages
            'messages' => $method === 'POST' ? 'create' : 'view',
            'messages.send' => 'create',
        ];

        return $actionMap[$routeName] ?? match($method) {
            'POST' => 'create',
            'PUT', 'PATCH' => 'update',
            'DELETE' => 'delete',
            'GET' => 'view',
            default => null
        };
    }

    /**
     * Get description from route and request
     */
    private function getDescriptionFromRoute(Request $request, ?string $routeName, string $method): ?string
    {
        $user = Auth::user();
        $userName = $user?->name ?? 'Unknown User';

        $descriptionMap = [
            // Authentication
            'login' => "User {$userName} logged in",
            'logout' => "User {$userName} logged out",
            'register' => "New user registered: {$userName}",

            // Admin actions
            'admin.settings' => $method === 'POST' ? "System settings updated by {$userName}" : "System settings viewed by {$userName}",
            'admin.group-settings' => $method === 'POST' ? "Group settings updated by {$userName}" : "Group settings viewed by {$userName}",
            'admin.create-groups' => "Groups automatically created by {$userName}",
            'admin.users.toggle' => "User status toggled by {$userName}",
            'admin.users.delete' => "User deleted by {$userName}",

            // User management
            'users' => $method === 'POST' ? "New user created by {$userName}" : "User list viewed by {$userName}",
            'users.update' => "User updated by {$userName}",
            'users.delete' => "User deleted by {$userName}",

            // Group management
            'groups.all' => "All groups viewed by {$userName}",
            'groups.my' => "My groups viewed by {$userName}",
            'groups.create' => "Group created by {$userName}",
            'groups.join' => "Group joined by {$userName}",
            'groups.leave' => "Group left by {$userName}",
            'groups.delete' => "Group deleted by {$userName}",

            // Project management
            'projects' => $method === 'POST' ? "Project created by {$userName}" : "Projects viewed by {$userName}",
            'projects.update' => "Project updated by {$userName}",
            'projects.delete' => "Project deleted by {$userName}",

            // Reports and analytics
            'analytics' => "Analytics viewed by {$userName}",
            'reports' => "Reports viewed by {$userName}",
            'reports.generate' => "Report generated by {$userName}",

            // Messages
            'messages' => $method === 'POST' ? "Message sent by {$userName}" : "Messages viewed by {$userName}",
            'messages.send' => "Message sent by {$userName}",
        ];

        return $descriptionMap[$routeName] ?? "{$userName} performed {$method} on {$routeName}";
    }

    /**
     * Get subject model from route
     */
    private function getSubjectFromRoute(Request $request, ?string $routeName)
    {
        if (!$routeName) {
            return null;
        }

        // Extract subject from route parameters
        $subjectMap = [
            'users' => \App\Models\User::find($request->route('id')),
            'users.show' => \App\Models\User::find($request->route('id')),
            'users.edit' => \App\Models\User::find($request->route('id')),
            'groups.show' => \App\Models\Group::find($request->route('id')),
            'projects.show' => \App\Models\Project::find($request->route('id')),
        ];

        return $subjectMap[$routeName] ?? null;
    }

    /**
     * Get additional properties from request
     */
    private function getPropertiesFromRequest(Request $request, Response $response): array
    {
        $properties = [
            'method' => $request->method(),
            'route' => $request->route()?->getName(),
            'url' => $request->fullUrl(),
            'response_status' => $response->getStatusCode(),
        ];

        // Add specific properties based on route
        $routeName = $request->route()?->getName();

        if ($routeName === 'admin.create-groups') {
            $properties['auto_create'] = $request->input('auto_create_groups', false);
            $properties['participants_per_group'] = $request->input('participants_per_group', 4);
        }

        if ($routeName === 'admin.group-settings.update') {
            $properties['settings_updated'] = array_keys($request->except(['_token', '_method', 'action']));
        }

        if ($request->has('search') || $request->has('filter')) {
            $properties['search_params'] = [
                'search' => $request->input('search'),
                'filter' => $request->input('filter'),
            ];
        }

        return $properties;
    }
}

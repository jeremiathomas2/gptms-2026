<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated via session
        $user = session('user');
        if (!$user || !isset($user['logged_in']) || !$user['logged_in']) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            
            // Store the intended URL for redirect after login
            session(['url.intended' => $request->fullUrl()]);
            
            return redirect()->route('login')
                ->with('error', 'Please login to access this page.');
        }

        // Enhanced session security checks
        $this->validateSessionSecurity($request);

        return $next($request);
    }

    /**
     * Validate session security
     */
    protected function validateSessionSecurity(Request $request): void
    {
        $user = session('user');
        if (!$user) return;
        
        $currentTime = now()->timestamp;

        // Check for session timeout (30 minutes)
        if (isset($user['last_activity']) && ($currentTime - $user['last_activity']) > 1800) {
            session()->flush();
            session()->regenerate(true);
            abort(401, 'Session expired. Please login again.');
        }

        // Check IP address consistency
        if (isset($user['ip_address']) && $user['ip_address'] !== $request->ip()) {
            session()->flush();
            session()->regenerate(true);
            abort(401, 'Security violation: IP address changed. Please login again.');
        }

        // Update last activity timestamp
        $user['last_activity'] = $currentTime;
        session(['user' => $user]);

        // Regenerate session ID periodically (every 5 minutes)
        if (!session()->has('last_regeneration') || ($currentTime - session('last_regeneration')) > 300) {
            session()->regenerate(true);
            session(['last_regeneration' => $currentTime]);
        }
    }
}

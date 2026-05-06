<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in
        if (!session('user.logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to access admin panel.');
        }

        // Get user from database
        $user = \App\Models\User::find(session('user.id'));
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found.');
        }

        // Check if user has admin role
        if (!$user->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        // Update last activity
        $user->update(['last_activity_at' => now()]);

        // Log admin access
        \Log::info('Admin access: ' . $user->email . ' accessed ' . $request->path());

        return $next($request);
    }
}

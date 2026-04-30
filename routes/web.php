<?php

use Illuminate\Support\Facades\Route;

// Authentication routes (only accessible when not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Illuminate\Http\Request $request) {
        // Validate login credentials
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            '_token' => 'required'
        ]);

        // For demo purposes, accept any email/password combination
        // In a real application, you would use Laravel's Auth facade
        $request->session()->regenerate(true); // Prevent session fixation
        $request->session()->put('user', [
            'email' => $request->email,
            'name' => 'Demo User',
            'logged_in' => true,
            'login_time' => now()->timestamp,
            'last_activity' => now()->timestamp,
            'ip_address' => $request->ip()
        ]);

        // Clear intended URL if exists and redirect to intended or dashboard
        $intended = session('url.intended');
        session()->forget('url.intended');
        
        return redirect($intended ?? route('dashboard'));
    })->name('login.submit');

    Route::post('/register', function (Illuminate\Http\Request $request) {
        // Handle registration logic here
        return redirect()->route('dashboard');
    })->name('register');
});

Route::post('/logout', function (Illuminate\Http\Request $request) {
    // Validate CSRF token
    $request->validate(['_token' => 'required']);
    
    // Clear user session completely
    $request->session()->forget('user');
    $request->session()->flush();
    $request->session()->regenerate(true); // Generate new session ID
    
    return redirect()->route('login')
        ->with('success', 'You have been logged out successfully.');
})->name('logout');

// Dashboard routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Groups routes
    Route::get('/groups', function () {
        return view('groups.index');
    })->name('groups.all');

    Route::get('/groups/my', function () {
        return view('groups.my');
    })->name('groups.my');

    Route::get('/groups/create', function () {
        return view('groups.create');
    })->name('groups.create');

    Route::get('/groups/requests', function () {
        return view('groups.requests');
    })->name('groups.requests');

    Route::get('/groups/analytics', function () {
        return view('groups.analytics');
    })->name('groups.analytics');

    // Projects routes
    Route::get('/projects', function () {
        return view('projects.index');
    })->name('projects');

    // Users routes
    Route::get('/users', function () {
        return view('users.index');
    })->name('users');

    // Analytics routes
    Route::get('/analytics', function () {
        return view('analytics.index');
    })->name('analytics');

    // Reports routes
    Route::get('/reports', function () {
        return view('reports.index');
    })->name('reports');

    // Messages routes
    Route::get('/messages', function () {
        return view('messages.index');
    })->name('messages');

    // Profile routes
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile');

    // Settings routes
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings');

    // Additional routes
    Route::get('/notifications', function () {
        return view('notifications.index');
    })->name('notifications');

    Route::get('/help', function () {
        return view('help.index');
    })->name('help');
});

// Fallback route (must be last) - only redirect unknown routes to login for guest users
Route::get('/{path?}', function () {
    return redirect()->route('login');
})->where('path', '.*')->middleware('guest');

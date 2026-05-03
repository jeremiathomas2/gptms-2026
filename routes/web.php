<?php

use Illuminate\Support\Facades\Route;

// Authentication routes (only accessible when not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/login', function (Illuminate\Http\Request $request) {
        // Validate login credentials
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            '_token' => 'required'
        ]);

        // Implement proper authentication with database validation
        // In a real application, you would use Laravel's Auth facade
        $request->session()->regenerate(true); // Prevent session fixation
        
        // Validate user credentials against database
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if (!$user || !\Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['login' => 'Invalid email or password. Please try again.']);
        }
        
        // Successful login - create proper session
        $request->session()->put('user', [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'registration_number' => $user->registration_number,
            'role' => $user->roles->first()->name ?? 'user',
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
        // Validate registration data for GPTFMS system
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'role' => 'required|in:student,supervisor',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
            '_token' => 'required'
        ];
        
        $messages = [
            'first_name.required' => 'First name is required.',
            'first_name.max' => 'First name cannot exceed 255 characters.',
            'last_name.required' => 'Last name is required.',
            'last_name.max' => 'Last name cannot exceed 255 characters.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'phone.required' => 'Phone number is required.',
            'phone.max' => 'Phone number cannot exceed 20 characters.',
            'role.required' => 'Please select your user type.',
            'role.in' => 'Invalid user type selected.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'terms.accepted' => 'You must accept the terms and conditions.'
        ];
        
        // Add registration number validation only for students
        if ($request->input('role') === 'student') {
            $rules['registration_number'] = 'required|string|max:50|unique:users,registration_number';
            $messages['registration_number.required'] = 'Registration number is required for students.';
            $messages['registration_number.max'] = 'Registration number cannot exceed 50 characters.';
            $messages['registration_number.unique'] = 'This registration number is already registered.';
        }
        
        $validated = $request->validate($rules, $messages);

        try {
            // Create user in database with GPTFMS requirements
            $userData = [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => bcrypt($validated['password']), // Hash password
                'status' => 'active',
                'last_login_ip' => $request->ip(),
            ];
            
            // Add registration number only for students
            if ($validated['role'] === 'student') {
                $userData['registration_number'] = $validated['registration_number'];
            } else {
                // For supervisors, generate a unique registration number
                $userData['registration_number'] = 'SUP_' . time() . '_' . rand(1000, 9999);
            }
            
            $user = \App\Models\User::create($userData);

            // Assign role using Spatie Permission package
            $user->assignRole($validated['role']);

            // Create student profile if student role
            if ($validated['role'] === 'student') {
                // You might want to create a student profile here
                // For now, we'll just log that a student was created
                \Log::info('Student registered: ' . $user->email);
            }

            // Log the user in by creating session
            $request->session()->regenerate(true); // Prevent session fixation
            $request->session()->put('user', [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $validated['role'],
                'logged_in' => true,
                'login_time' => now()->timestamp,
                'last_activity' => now()->timestamp,
                'ip_address' => $request->ip()
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Registration successful! Welcome to GPTFMS. You are registered as a ' . ucfirst($validated['role']) . '.');

        } catch (\Exception $e) {
            // Log error and return with error message
            \Log::error('Registration failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['registration' => 'Registration failed. Please try again.']);
        }
    })->name('register.submit');
});

Route::post('/logout', function (Illuminate\Http\Request $request) {
    // Validate CSRF token - Laravel handles this automatically with @csrf
    // No need for manual validation as Laravel's VerifyCsrfToken middleware handles it
    
    // Clear all user session data
    $request->session()->flush();
    
    // Invalidate the current session and regenerate a new one
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
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
        // Fetch users from database with their roles
        $users = \App\Models\User::with('roles')->get();
        
        return view('users.index', compact('users'));
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

    Route::post('/settings/profile', function (Illuminate\Http\Request $request) {
        // Validate profile update data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'registration_number' => 'nullable|string|max:50',
        ], [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
        ]);

        // Update session data (simulate user update)
        session([
            'user.first_name' => $validated['first_name'],
            'user.last_name' => $validated['last_name'],
            'user.name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'user.email' => $validated['email'],
            'user.phone' => $validated['phone'],
            'user.registration_number' => $validated['registration_number'],
        ]);

        return redirect()->route('settings')->with('success', 'Profile updated successfully!');
    })->name('settings.profile');

    Route::post('/settings/password', function (Illuminate\Http\Request $request) {
        // Validate password change data
        $validated = $request->validate([
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Current password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'Password must be at least 8 characters long.',
            'new_password.confirmed' => 'Password confirmation does not match.',
        ]);

        // In a real application, you would verify the current password against the database
        // and update the user's password. For now, we'll just simulate success.
        
        return redirect()->route('settings')->with('success', 'Password updated successfully!');
    })->name('settings.password');

    Route::post('/settings/notifications', function (Illuminate\Http\Request $request) {
        // Validate notification preferences
        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'group_invitations' => 'boolean',
            'project_updates' => 'boolean',
            'system_messages' => 'boolean',
        ]);

        // Store notification preferences in session (simulate database storage)
        session([
            'user.notifications.email_notifications' => $request->has('email_notifications'),
            'user.notifications.group_invitations' => $request->has('group_invitations'),
            'user.notifications.project_updates' => $request->has('project_updates'),
            'user.notifications.system_messages' => $request->has('system_messages'),
        ]);

        return redirect()->route('settings')->with('success', 'Notification preferences updated successfully!');
    })->name('settings.notifications');

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

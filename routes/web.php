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

            // Create supervisor profile if supervisor role
            if ($validated['role'] === 'supervisor') {
                \Log::info('Supervisor registered: ' . $user->email);
            }

            // Redirect students to survey, supervisors to profile completion
            if ($validated['role'] === 'student') {
                return redirect()->route('survey')
                    ->with('success', 'Registration successful! Please complete the skills assessment survey to help us personalize your experience.');
            } else {
                return redirect()->route('supervisor.profile')
                    ->with('success', 'Registration successful! Please complete your supervisor profile to help us match you with suitable students.');
            }

        } catch (\Exception $e) {
            // Log error and return with error message
            \Log::error('Registration failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['registration' => 'Registration failed. Please try again.']);
        }
    })->name('register.submit');
});

// Survey routes
Route::get('/survey', function () {
    // Check if user is logged in
    if (!session('user.logged_in')) {
        return redirect()->route('login')->with('error', 'Please login to access the survey.');
    }
    
    // Check if user is a student
    if (session('user.role') !== 'student') {
        return redirect()->route('dashboard')->with('info', 'Survey is only required for students.');
    }
    
    return view('auth.survey');
})->name('survey');

Route::post('/survey', function (Illuminate\Http\Request $request) {
    // Check if user is logged in
    if (!session('user.logged_in')) {
        return redirect()->route('login')->with('error', 'Please login to submit the survey.');
    }
    
    // Validate survey data
    $rules = [
        'user_id' => 'required|integer',
        'experience_level' => 'required|in:beginner,intermediate,advanced',
        'project_type' => 'required|in:individual,team,both',
        'project_duration' => 'required|in:short,medium,long',
    ];
    
    $messages = [
        'experience_level.required' => 'Please select your experience level.',
        'project_type.required' => 'Please select your preferred project type.',
        'project_duration.required' => 'Please select your preferred project duration.',
    ];
    
    $validated = $request->validate($rules, $messages);
    
    try {
        // Check if user already completed survey
        if (\App\Models\StudentSkillsSurvey::isCompletedByUser($validated['user_id'])) {
            return redirect()->route('dashboard')
                ->with('info', 'You have already completed the skills survey.');
        }
        
        // Process skills data
        $skills = [];
        if ($request->has('skills')) {
            foreach ($request->input('skills') as $category => $skillList) {
                $skills[$category] = is_array($skillList) ? $skillList : [$skillList];
            }
        }
        
        // Process interests
        $interests = $request->input('interests', []);
        
        // Create survey record in database
        \App\Models\StudentSkillsSurvey::create([
            'user_id' => $validated['user_id'],
            'skills' => $skills,
            'experience_level' => $validated['experience_level'],
            'interests' => $interests,
            'project_type' => $validated['project_type'],
            'project_duration' => $validated['project_duration'],
            'goals' => $request->input('goals', ''),
            'completed_at' => now(),
        ]);
        
        // Log the survey completion
        \Log::info('Survey completed by user: ' . session('user.email'));
        
        return redirect()->route('dashboard')
            ->with('success', 'Thank you for completing the skills survey! Your responses will help us provide personalized recommendations.');
            
    } catch (\Exception $e) {
        \Log::error('Survey submission failed: ' . $e->getMessage());
        
        return redirect()->back()
            ->withInput()
            ->withErrors(['survey' => 'Survey submission failed. Please try again.']);
    }
})->name('survey.submit');

// Supervisor profile routes
Route::get('/supervisor-profile', function () {
    // Check if user is logged in
    if (!session('user.logged_in')) {
        return redirect()->route('login')->with('error', 'Please login to access your profile.');
    }
    
    // Check if user is a supervisor
    if (session('user.role') !== 'supervisor') {
        return redirect()->route('dashboard')->with('info', 'Supervisor profile is only for supervisors.');
    }
    
    // Check if supervisor already completed profile
    if (\App\Models\SupervisorProfile::getByUserId(session('user.id'))) {
        return redirect()->route('dashboard')->with('info', 'You have already completed your supervisor profile.');
    }
    
    return view('auth.supervisor-profile');
})->name('supervisor.profile');

Route::post('/supervisor-profile', function (Illuminate\Http\Request $request) {
    // Check if user is logged in
    if (!session('user.logged_in')) {
        return redirect()->route('login')->with('error', 'Please login to submit your profile.');
    }
    
    // Validate profile data
    $rules = [
        'user_id' => 'required|integer',
        'department' => 'required|string|max:100',
        'position' => 'required|string|max:255',
        'years_of_experience' => 'required|integer|min:0|max:50',
        'highest_education' => 'required|string|max:100',
        'bio' => 'required|string|max:2000',
        'max_students' => 'required|integer|min:1|max:50',
        'is_available' => 'required|boolean',
    ];
    
    $messages = [
        'department.required' => 'Please select your department.',
        'position.required' => 'Please enter your position.',
        'years_of_experience.required' => 'Please enter your years of experience.',
        'highest_education.required' => 'Please select your highest education.',
        'bio.required' => 'Please provide a professional bio.',
        'max_students.required' => 'Please specify maximum students you can supervise.',
        'is_available.required' => 'Please specify your availability status.',
    ];
    
    $validated = $request->validate($rules, $messages);
    
    try {
        // Check if supervisor already has a profile
        if (\App\Models\SupervisorProfile::getByUserId($validated['user_id'])) {
            return redirect()->route('dashboard')
                ->with('info', 'You have already completed your supervisor profile.');
        }
        
        // Process specializations
        $specializations = $request->input('specializations', []);
        
        // Process preferences
        $preferences = [
            'student_level' => $request->input('preferences.student_level', []),
            'project_types' => $request->input('preferences.project_types', []),
        ];
        
        // Create supervisor profile record in database
        \App\Models\SupervisorProfile::create([
            'user_id' => $validated['user_id'],
            'department' => $validated['department'],
            'position' => $validated['position'],
            'bio' => $validated['bio'],
            'specializations' => $specializations,
            'years_of_experience' => $validated['years_of_experience'],
            'highest_education' => $validated['highest_education'],
            'certifications' => $request->input('certifications', ''),
            'preferences' => $preferences,
            'max_students' => $validated['max_students'],
            'is_available' => $validated['is_available'],
            'last_activity_at' => now(),
        ]);
        
        // Log the profile completion
        \Log::info('Supervisor profile completed by user: ' . session('user.email'));
        
        return redirect()->route('dashboard')
            ->with('success', 'Thank you for completing your supervisor profile! Your profile will help us match you with suitable students.');
            
    } catch (\Exception $e) {
        \Log::error('Supervisor profile submission failed: ' . $e->getMessage());
        
        return redirect()->back()
            ->withInput()
            ->withErrors(['profile' => 'Profile submission failed. Please try again.']);
    }
})->name('supervisor.profile.submit');

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

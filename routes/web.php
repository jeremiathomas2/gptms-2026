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
        
        // Get user role safely - handle missing roles table
        $userRole = 'user';
        try {
            $userRole = $user->roles->first()->name ?? 'user';
        } catch (\Exception $e) {
            // Roles table doesn't exist, use default role based on email or registration number
            if (strpos($user->email, 'admin') !== false) {
                $userRole = 'admin';
            } elseif (strpos($user->email, 'university') !== false || strpos($user->registration_number, 'SUP_') === 0) {
                $userRole = 'supervisor';
            } elseif (strpos($user->email, 'student') !== false || strpos($user->registration_number, 'STU_') === 0) {
                $userRole = 'student';
            }
        }
        
        // Successful login - create proper session
        $request->session()->put('user', [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'registration_number' => $user->registration_number,
            'role' => $userRole,
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

// Survey routes (protected by auth middleware for testing)
Route::middleware(['auth', 'survey.check'])->group(function () {
    Route::get('/survey', function () {
        return view('auth.survey');
    })->name('survey');

    Route::post('/survey', function (Illuminate\Http\Request $request) {
        // Check if user is a student
        if (session('user.role') !== 'student') {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Survey is only accessible to students.'
                ], 403);
            }
            return redirect()->route('dashboard')->with('info', 'Survey is only accessible to students.');
        }
        
        // Debug: Log received data
        \Log::info('Survey submission data:', $request->all());
        \Log::info('Experience level received:', $request->input('experience_level'));
        \Log::info('Project type received:', $request->input('project_type'));
        \Log::info('Project duration received:', $request->input('project_duration'));
        
        // Get user ID from session if not provided
        $userId = $request->input('user_id') ?: session('user.id');
        
        // If still no user ID, return error
        if (!$userId) {
            \Log::error('No user ID found in survey submission', [
                'request_data' => $request->all(),
                'session_data' => session()->all()
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User authentication error. Please log in again.'
                ], 401);
            }
            
            return redirect()->route('login')->with('error', 'Please log in again to submit the survey.');
        }
        
        // Add user ID to request data for validation
        $request->merge(['user_id' => $userId]);
        
        // Validate survey data
        $rules = [
            'user_id' => 'required|integer',
            'experience_level' => 'required|in:beginner,intermediate,advanced',
            'project_type' => 'required|in:individual,team,both',
            'project_duration' => 'required|in:short,medium,long',
            'skills' => 'nullable|array',
            'skills.programming' => 'nullable|array',
            'skills.web' => 'nullable|array',
            'interests' => 'nullable|array',
            'goals' => 'nullable|string|max:5000'
        ];
    
    $messages = [
        'user_id.required' => 'User ID is required.',
        'experience_level.required' => 'Experience level is required.',
        'experience_level.in' => 'Please select a valid experience level.',
        'project_type.required' => 'Project type preference is required.',
        'project_type.in' => 'Please select a valid project type.',
        'project_duration.required' => 'Project duration preference is required.',
        'project_duration.in' => 'Please select a valid project duration.',
        'skills.array' => 'Skills data must be in array format.',
        'interests.array' => 'Interests data must be in array format.',
        'goals.string' => 'Goals must be text.',
        'goals.max' => 'Goals cannot exceed 5000 characters.'
    ];
    
    try {
        $validated = $request->validate($rules, $messages);
        
        // Check if user already completed survey
        if (\App\Models\StudentSkillsSurvey::isCompletedByUser($validated['user_id'])) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'You have already completed the skills survey.',
                    'redirect' => route('dashboard')
                ]);
            }
            return redirect()->route('dashboard')
                ->with('info', 'You have already completed the skills survey.');
        }
        
        // Process skills data
        $skills = [
            'programming' => $request->input('skills.programming', []),
            'web' => $request->input('skills.web', [])
        ];
        
        // Process interests
        $interests = $request->input('interests', []);
        
        // Debug: Log processed data
        \Log::info('Processed skills data:', $skills);
        \Log::info('Processed interests data:', $interests);
        \Log::info('Creating survey with data:', [
            'user_id' => $validated['user_id'],
            'experience_level' => $validated['experience_level'],
            'project_type' => $validated['project_type'],
            'project_duration' => $validated['project_duration'],
            'goals' => $request->input('goals', ''),
        ]);
        
        // Create survey record in database
        try {
            $survey = \App\Models\Survey::create([
                'user_id' => $validated['user_id'],
                'name' => session('user.name') ?? 'Student',
                'skills_data' => [
                    'skills' => $skills,
                    'experience_level' => $validated['experience_level'],
                    'interests' => $interests,
                    'project_type' => $validated['project_type'],
                    'project_duration' => $validated['project_duration'],
                    'goals' => $request->input('goals', ''),
                ],
                'completed' => true,
            ]);
            \Log::info('Survey created successfully with ID: ' . $survey->id);
        } catch (\Exception $e) {
            \Log::error('Failed to create survey record: ' . $e->getMessage());
            throw $e;
        }
        
        // Mark survey as completed in session
        session(['survey_completed' => true]);
        
        // Log the survey completion
        \Log::info('Survey completed by user: ' . session('user.email'));
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => 'Thank you for completing the skills survey! Your responses will help us provide personalized recommendations.',
                'redirect' => route('dashboard'),
                'survey_id' => $survey->id
            ]);
        }
        
        return redirect()->route('dashboard')
            ->with('success', 'Thank you for completing the skills survey! Your responses will help us provide personalized recommendations.');
            
    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Survey validation failed: ' . $e->getMessage());
        \Log::error('Validation errors:', $e->errors());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => false, 
                'message' => 'Validation failed. Please complete all required fields.',
                'errors' => $e->errors()
            ], 422);
        }
        throw $e;
    } catch (\Illuminate\Database\QueryException $e) {
        \Log::error('Database error in survey submission: ' . $e->getMessage());
        \Log::error('SQL State: ' . $e->getCode());
        \Log::error('Bindings: ' . json_encode($e->getBindings()));
        
        if ($request->ajax()) {
            return response()->json([
                'success' => false, 
                'message' => 'Database error occurred. Please try again later.'
            ], 500);
        }
        
        return redirect()->back()
            ->withInput()
            ->withErrors(['survey' => 'Database error occurred. Please try again later.']);
    } catch (\Exception $e) {
        \Log::error('Survey submission failed: ' . $e->getMessage());
        \Log::error('Exception trace: ' . $e->getTraceAsString());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => false, 
                'message' => 'Server error occurred. Please try again later.',
                'debug_info' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
        
        return redirect()->back()
            ->withInput()
            ->withErrors(['survey' => 'Server error occurred. Please try again later.']);
    }
})->name('survey.submit');
}); // Close student middleware group

// Supervisor profile routes (protected by supervisor middleware)
Route::middleware('supervisor')->group(function () {
    Route::get('/supervisor-profile', function () {
    
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
}); // Close supervisor middleware group

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

// Admin routes (protected by auth and admin middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        // Get admin statistics
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_groups' => \App\Models\Group::count(),
            'total_projects' => \App\Models\Project::count(),
            'active_sessions' => \App\Models\User::where('updated_at', '>', now()->subHours(24))->count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    })->name('admin.dashboard');

    // Admin user management
    Route::get('/admin/users', function () {
        $users = \App\Models\User::with('roles')->get();
        return view('admin.users', compact('users'));
    })->name('admin.users');

    Route::post('/admin/users/{id}/role', function ($id, Illuminate\Http\Request $request) {
        $user = \App\Models\User::findOrFail($id);
        $role = $request->input('role');
        
        // Remove all existing roles
        $user->roles()->detach();
        
        // Assign new role
        $user->assignRole($role);
        
        return redirect()->back()->with('success', 'User role updated successfully!');
    })->name('admin.users.update_role');

    Route::post('/admin/users/{id}/toggle', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        $currentStatus = $user->status ? $user->status : 'active';
        $user->status = $currentStatus === 'active' ? 'inactive' : 'active';
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully!'
        ]);
    })->name('admin.users.toggle');
    
    // Additional user management routes
    Route::post('/admin/users/{id}/reset-password', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        
        // Generate temporary password
        $tempPassword = \Str::random(10);
        $user->password = \Hash::make($tempPassword);
        $user->save();
        
        // Log the password reset
        \Log::info('Password reset for user: ' . $user->id . ' by admin');
        
        return response()->json([
            'success' => true,
            'message' => "Password reset successfully. Temporary password: {$tempPassword}"
        ]);
    })->name('admin.users.reset-password');
    
    Route::get('/admin/users/export', function (Illuminate\Http\Request $request) {
        $query = \App\Models\User::with('roles');
        
        // Apply filters based on request parameters
        if ($request->has('status')) {
            $statuses = $request->query('status');
            if (!is_array($statuses)) {
                $statuses = [$statuses];
            }
            $query->whereIn('status', $statuses);
        }
        
        if ($request->has('role')) {
            $roles = $request->query('role');
            if (!is_array($roles)) {
                $roles = [$roles];
            }
            $query->whereHas('roles', function($q) use ($roles) {
                $q->whereIn('name', $roles);
            });
        }
        
        $users = $query->get();
        
        $csv = "Name,Email,Role,Status,Phone,Created At\n";
        foreach ($users as $user) {
            $roleName = $user->roles->first() ? $user->roles->first()->name : 'N/A';
            $status = $user->status ? $user->status : 'active';
            $phone = $user->phone ? $user->phone : 'N/A';
            $csv .= "{$user->name},{$user->email},{$roleName},{$status},{$phone},{$user->created_at->format('Y-m-d')}\n";
        }
        
        $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    })->name('admin.users.export');
    
    Route::post('/admin/users/import', function (Illuminate\Http\Request $request) {
        if (!$request->hasFile('csv_file')) {
            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ]);
        }
        
        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        
        // Process CSV import (simplified version)
        $imported = 0;
        $failed = 0;
        
        if (($handle = fopen($path, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                try {
                    // Skip header row
                    if ($data[0] === 'Name') continue;
                    
                    $user = \App\Models\User::create([
                        'name' => $data[0] ?? '',
                        'email' => $data[1] ?? '',
                        'password' => \Hash::make('password123'),
                        'phone' => $data[4] ?? null,
                        'status' => $data[3] ?? 'active'
                    ]);
                    
                    // Assign role if specified
                    if (!empty($data[2])) {
                        $user->assignRole($data[2]);
                    }
                    
                    $imported++;
                } catch (\Exception $e) {
                    $failed++;
                }
            }
            fclose($handle);
        }
        
        return response()->json([
            'success' => true,
            'message' => "Import completed: {$imported} users imported, {$failed} failed"
        ]);
    })->name('admin.users.import');

    // Admin system settings
    Route::get('/admin/settings', function () {
        // Check if user has settings permission
        if (!\App\Helpers\PermissionHelper::hasPermission('settings')) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }
        return view('admin.settings');
    })->name('admin.settings');

    Route::post('/admin/settings', function (Illuminate\Http\Request $request) {
        // Check if user has settings permission
        if (!\App\Helpers\PermissionHelper::hasPermission('settings')) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }
        
        // Handle system settings updates
        $settings = $request->except(['_token', '_method', 'permissions']);
        
        // Store regular settings in cache
        foreach ($settings as $key => $value) {
            \Cache::put('admin.settings.' . $key, $value);
        }
        
        // Handle permissions separately
        if ($request->has('permissions')) {
            foreach ($request->permissions as $role => $permissions) {
                \App\Helpers\PermissionHelper::saveRolePermissions($role, $permissions);
            }
        }
        
        return redirect()->back()->with('success', 'Settings updated successfully!');
    })->name('admin.settings.update');

    // Admin logs and monitoring
    Route::get('/admin/logs', function () {
        // Get recent activity logs with enhanced filtering
        $logs = \App\Services\ActivityLogger::getRecentActivities(100);
        
        return view('admin.logs', compact('logs'));
    })->name('admin.logs');

    // Group settings management
    Route::get('/admin/group-settings', [App\Http\Controllers\Admin\GroupSettingsController::class, 'index'])->name('admin.group-settings');
    Route::post('/admin/group-settings', [App\Http\Controllers\Admin\GroupSettingsController::class, 'update'])->name('admin.group-settings.update');
    Route::post('/admin/create-groups', [App\Http\Controllers\Admin\GroupSettingsController::class, 'createGroups'])->name('admin.create-groups');
    Route::get('/admin/countdown-status', [App\Http\Controllers\Admin\GroupSettingsController::class, 'countdownStatus'])->name('admin.countdown-status');
    
    // Admin groups management
    Route::get('/admin/groups', [App\Http\Controllers\Admin\GroupSettingsController::class, 'groups'])->name('admin.groups');
    Route::get('/admin/groups/{id}/details', [App\Http\Controllers\Admin\GroupSettingsController::class, 'groupDetails'])->name('admin.groups.details');
});

// Authenticated routes
Route::middleware(['auth', 'role.switch'])->group(function () {
    Route::get('/dashboard', function () {
        $settings = \App\Models\GroupSettings::getCurrent();
        $groups = \App\Models\Group::with('members')->latest()->get();
        
        // Check if user has completed survey
        $surveyCompleted = false;
        
        // Debug: Log all session data
        \Log::info('Dashboard session debug:', [
            'all_session' => session()->all(),
            'user_session' => session('user'),
            'session_id' => session()->getId()
        ]);
        
        if (session('user.role') === 'student' && session('user.id')) {
            $userId = session('user.id');
            
            // Enhanced debugging - check each step
            \Log::info('=== DASHBOARD SURVEY DEBUG START ===');
            \Log::info('User ID from session: ' . $userId);
            \Log::info('User role from session: ' . session('user.role'));
            
            // Step 1: Check if survey record exists
            $surveyExists = \App\Models\StudentSkillsSurvey::where('user_id', $userId)->exists();
            \Log::info('Survey record exists (raw query): ' . ($surveyExists ? 'TRUE' : 'FALSE'));
            
            // Step 2: Check using model method with multiple fallbacks
            $surveyCompleted = \App\Models\StudentSkillsSurvey::isCompletedByUser($userId);
            
            // Additional safety check - if model method fails, use direct query
            if ($surveyCompleted === null || $surveyCompleted === false) {
                $surveyCompleted = \App\Models\StudentSkillsSurvey::where('user_id', $userId)->exists();
            }
            \Log::info('Survey completed (model method): ' . ($surveyCompleted ? 'TRUE' : 'FALSE'));
            
            // Step 3: Verify the model method is working correctly
            $directCheck = \App\Models\StudentSkillsSurvey::where('user_id', $userId)->first();
            \Log::info('Direct survey record check:', [
                'record_found' => $directCheck ? 'YES' : 'NO',
                'record_data' => $directCheck ? json_encode($directCheck->toArray()) : 'null'
            ]);
            
            // Step 4: Final verification
            $finalCheck = \App\Models\StudentSkillsSurvey::where('user_id', $userId)->exists();
            \Log::info('Final verification check: ' . ($finalCheck ? 'TRUE' : 'FALSE'));
            
            \Log::info('=== DASHBOARD SURVEY DEBUG END ===');
            \Log::info('Final surveyCompleted value passed to view: ' . ($surveyCompleted ? 'TRUE' : 'FALSE'));
        } else {
            \Log::info('Dashboard survey check skipped - user is not student or not logged in:', [
                'user_role' => session('user.role'),
                'user_id' => session('user.id'),
                'condition_met' => (session('user.role') === 'student' && session('user.id'))
            ]);
        }
        
        // Calculate real statistics
        $stats = [
            'total_groups' => \App\Models\Group::count(),
            'active_groups' => \App\Models\Group::where('status', 'active')->count(),
            'pending_groups' => \App\Models\Group::where('status', 'forming')->count(),
            'completed_groups' => \App\Models\Group::where('status', 'completed')->count(),
            
            'total_projects' => \App\Models\Project::count(),
            'active_projects' => \App\Models\Project::where('status', 'active')->count(),
            'completed_projects' => \App\Models\Project::where('status', 'completed')->count(),
            
            'total_students' => \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'student'); })->count(),
            'active_students' => \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'student'); })->where('status', 'active')->count(),
            'inactive_students' => \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'student'); })->where('status', 'inactive')->count(),
            
            'completion_rate' => 6.1, // Fixed value for completion rate
            'on_time_delivery' => 85.2, // Fixed value for on-time delivery
        ];
        
        // Calculate growth percentages (using fixed values for now)
        $stats['groups_growth'] = 12.5;
        $stats['projects_growth'] = 8.3;
        $stats['students_growth'] = 15.7;
        $stats['completion_growth'] = 6.1;
        
        return view('dashboard.index', compact('settings', 'groups', 'surveyCompleted', 'stats'));
    })->name('dashboard');
});

// Groups routes
    Route::get('/groups', function () {
        return view('groups.index');
    })->name('groups.all');

    Route::get('/groups/my', function () {
        $user = \App\Models\User::find(session('user.id'));
        $userGroups = [];
        
        if ($user) {
            $userGroups = \App\Models\GroupMember::where('user_id', $user->id)
                ->with('group')
                ->get()
                ->pluck('group');
        }
        
        return view('groups.my', compact('userGroups'));
    })->name('groups.my');

    Route::get('/groups/{id}', function ($id) {
        $group = \App\Models\Group::with('members.user')->findOrFail($id);
        return view('groups.show', compact('group'));
    })->name('groups.show');

    // API routes (no auth middleware for debugging)
    Route::get('/api/auth-check', function () {
        $userId = null;
        $userName = null;
        $authMethod = 'none';
        
        // Method 1: Try standard Laravel Auth
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;
            $userName = $user->name ?? null;
            $authMethod = 'laravel_auth';
        }
        // Method 2: Try session-based user data
        elseif (session('user') && isset(session('user')['id'])) {
            $sessionUser = session('user');
            $userId = $sessionUser['id'];
            $userName = $sessionUser['name'] ?? null;
            $authMethod = 'session_user';
        }
        // Method 3: Try session user_id directly
        elseif (session('user_id')) {
            $userId = session('user_id');
            $authMethod = 'session_user_id';
        }
        
        return response()->json([
            'authenticated' => $userId ? true : false,
            'user_id' => $userId,
            'user_name' => $userName,
            'auth_method' => $authMethod,
            'session_id' => session()->getId(),
            'session_data' => session()->all()
        ]);
    });

    // Survey routes
    Route::middleware('auth')->group(function () {
        Route::get('/survey', function () {
            return view('survey.index');
        })->name('survey.index');
        Route::post('/survey/store', [App\Http\Controllers\Api\StudentSkillsSurveyController::class, 'store'])->name('survey.store');
        Route::get('/survey/api', [App\Http\Controllers\Api\StudentSkillsSurveyController::class, 'show'])->name('survey.show');
        Route::get('/survey/check', [App\Http\Controllers\Api\StudentSkillsSurveyController::class, 'check'])->name('survey.check');
    });

    // Skills routes
    Route::middleware('auth')->group(function () {
        Route::get('/skills', function () {
            return view('skills.index');
        })->name('skills.index');
        Route::get('/skills/api', [App\Http\Controllers\Api\StudentSkillsController::class, 'index'])->name('skills.api');
        Route::post('/skills/save', [App\Http\Controllers\Api\StudentSkillsController::class, 'save'])->name('skills.save');
    });

    Route::get('/groups/create', function () {
        return view('groups.create');
    })->name('groups.create');

    Route::get('/groups/requests', function () {
        return view('groups.requests');
    })->name('groups.requests');

    Route::middleware(['auth', 'role:admin,supervisor'])->group(function () {
        Route::get('/groups/analytics', function () {
            return view('groups.analytics');
        })->name('groups.analytics');
    });

    // Users management routes (protected by permission middleware)
    Route::middleware(['auth'])->group(function () {
        Route::get('/users', function () {
            // Check if user has users permission
            if (!\App\Helpers\PermissionHelper::hasPermission('users')) {
                return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
            }
            
            // Fetch users from database with their roles
            $users = \App\Models\User::with('roles')->get();
            
            return view('users.index', compact('users'));
        })->name('users');

        // User view route
        Route::get('/users/{id}', function ($id) {
            // Check if user is logged in
            if (!session('user.logged_in')) {
                return redirect()->route('login')->with('error', 'Please login to view user details.');
            }
            
            try {
                // Get user from database
                $user = \App\Models\User::with('roles')->findOrFail($id);
                
                return view('users.show', compact('user'));
                
            } catch (\Exception $e) {
                \Log::error('User view failed: ' . $e->getMessage());
                
                return redirect()->route('users')->with('error', 'User not found.');
            }
        })->name('users.show');

        // User edit route
        Route::get('/users/{id}/edit', function ($id) {
            // Check if user is logged in
            if (!session('user.logged_in')) {
                return redirect()->route('login')->with('error', 'Please login to edit users.');
            }
            
            try {
                // Get user from database
                $user = \App\Models\User::with('roles')->findOrFail($id);
                
                // Get all available roles
                $roles = \Spatie\Permission\Models\Role::all();
                
                return view('users.edit', compact('user', 'roles'));
                
            } catch (\Exception $e) {
                \Log::error('User edit page failed: ' . $e->getMessage());
                
                return redirect()->route('users')->with('error', 'User not found.');
            }
        })->name('users.edit');

        // User update route
        Route::put('/users/{id}', function ($id, Illuminate\Http\Request $request) {
            // Check if user is logged in
            if (!session('user.logged_in')) {
                return redirect()->route('login')->with('error', 'Please login to update users.');
            }
            
            try {
                // Get user from database
                $user = \App\Models\User::findOrFail($id);
                
                // Validate input
                $validated = $request->validate([
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email,' . $id,
                    'registration_number' => 'nullable|string|unique:users,registration_number,' . $id,
                    'phone' => 'nullable|string|max:20',
                    'gender' => 'nullable|in:male,female,other,prefer_not_to_say',
                    'status' => 'required|in:active,inactive,suspended',
                    'role' => 'required|string|exists:roles,name',
                    'password' => 'nullable|string|min:6|confirmed',
                ]);
                
                // Update user information
                $updateData = [
                    'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'gender' => $validated['gender'] ?? null,
                    'status' => $validated['status'],
                ];
                
                // Only update registration_number if provided (not null)
                if (isset($validated['registration_number'])) {
                    $updateData['registration_number'] = $validated['registration_number'];
                }
                
                // Log update data for debugging
                \Log::info('User update data: ' . json_encode($updateData));
                \Log::info('User before update: ' . json_encode($user->toArray()));
                
                $result = $user->update($updateData);
                
                // Log result for debugging
                \Log::info('User update result: ' . ($result ? 'success' : 'failed'));
                \Log::info('User after update: ' . json_encode($user->fresh()->toArray()));
                
                // Update password if provided
                if (!empty($validated['password'])) {
                    $user->password = \Hash::make($validated['password']);
                    $user->save();
                }
                
                // Update role
                $user->syncRoles([$validated['role']]);
                
                // Log user update
                \Log::info('User updated: ' . $user->id . ' by ' . session('user.id'));
                
                return redirect()->route('users')->with('success', 'User updated successfully!');
                
            } catch (\Illuminate\Validation\ValidationException $e) {
                return redirect()->back()
                    ->withErrors($e->errors())
                    ->withInput();
            } catch (\Illuminate\Database\QueryException $e) {
                \Log::error('Database error during user update: ' . $e->getMessage());
                
                return redirect()->back()
                    ->with('error', 'Database error occurred. Please try again.')
                    ->withInput();
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                \Log::error('User not found during update: ' . $e->getMessage());
                
                return redirect()->route('users')->with('error', 'User not found.');
            } catch (\Exception $e) {
                \Log::error('User update failed: ' . $e->getMessage());
                
                return redirect()->back()
                    ->with('error', 'Failed to update user. Please try again.')
                    ->withInput();
            }
        })->name('users.update');

    // Clear notifications route
    Route::post('/clear-notifications', function () {
        session()->forget(['success', 'error']);
        return response()->json(['success' => true]);
    })->name('notifications.clear');

    // User delete route
    Route::delete('/users/{id}', function ($id) {
        try {
            // Get user from database
            $user = \App\Models\User::findOrFail($id);
            
            // Prevent self-deletion
            if ($user->id == session('user.id')) {
                return redirect()->route('users')->with('error', 'You cannot delete your own account.');
            }
            
            // Log the user deletion
            \Log::info('User deleted: ' . $user->email . ' by ' . session('user.email'));
            
            // Delete user (this will also delete related records due to foreign key constraints)
            $user->delete();
            
            return redirect()->route('users')->with('success', 'User deleted successfully!');
            
        } catch (\Exception $e) {
            \Log::error('User deletion failed: ' . $e->getMessage());
            
            return redirect()->route('users')->with('error', 'User deletion failed. Please try again.');
        }
    })->name('users.delete');

    });

    // Projects routes
    Route::get('/projects', function () {
        // Check if user has projects permission
        if (!\App\Helpers\PermissionHelper::hasPermission('projects')) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }
        return view('projects.index');
    })->name('projects');

    // Analytics routes
    Route::get('/analytics', function () {
        // Check if user has analytics permission
        if (!\App\Helpers\PermissionHelper::hasPermission('analytics')) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }
        return view('analytics.index');
    })->name('analytics');

    // Reports routes
    Route::get('/reports', function () {
        // Check if user has reports permission
        if (!\App\Helpers\PermissionHelper::hasPermission('reports')) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }
        return view('reports.index');
    })->name('reports');

    // Messages routes
    Route::get('/messages', function () {
        // Check if user has messages permission
        if (!\App\Helpers\PermissionHelper::hasPermission('messages')) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }
        return view('messages.index');
    })->name('messages');

    // Profile routes
    Route::get('/profile', function () {
        // Check if user is logged in
        if (!session('user.logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to access your profile.');
        }
        
        // Get user data from database
        $user = \App\Models\User::find(session('user.id'));
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found.');
        }
        
        // Get additional profile data based on role
        $profileData = null;
        $skillsData = null;
        
        if ($user->hasRole('student')) {
            $skillsData = \App\Models\StudentSkillsSurvey::where('user_id', $user->id)->first();
        } elseif ($user->hasRole('supervisor')) {
            $profileData = \App\Models\SupervisorProfile::where('user_id', $user->id)->first();
        }
        
        return view('profile.index', compact('user', 'profileData', 'skillsData'));
    })->name('profile');

    Route::post('/profile', function (Illuminate\Http\Request $request) {
        // Check if user is logged in
        if (!session('user.logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to update your profile.');
        }
        
        // Validate profile update data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
        ], [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
        ]);
        
        try {
            // Get user from database
            $user = \App\Models\User::find(session('user.id'));
            if (!$user) {
                return redirect()->route('login')->with('error', 'User not found.');
            }
            
            // Update user profile
            $user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'updated_at' => now(),
            ]);
            
            // Update session data
            session([
                'user.first_name' => $validated['first_name'],
                'user.last_name' => $validated['last_name'],
            ]);
            
            return redirect()->route('profile')->with('success', 'Profile updated successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Profile update failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update profile. Please try again.')
                ->withInput();
        }
    })->name('profile.update');

    // Profile export route
    Route::get('/profile/export', function () {
        // Check if user is logged in
        if (!session('user.logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to export your profile.');
        }
        
        // Get user data from database
        $user = \App\Models\User::find(session('user.id'));
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        // Get additional profile data based on role
        $profileData = null;
        $skillsData = null;
        
        if ($user->hasRole('student')) {
            $skillsData = \App\Models\StudentSkillsSurvey::where('user_id', $user->id)->first();
        } elseif ($user->hasRole('supervisor')) {
            $profileData = \App\Models\SupervisorProfile::where('user_id', $user->id)->first();
        }
        
        // Generate PDF content
        $pdfContent = \App\Helpers\ProfileExportHelper::generateProfilePDF($user, $profileData, $skillsData);
        
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="profile_' . date('Y-m-d') . '.pdf"');
    })->name('profile.export');

    // Project Management routes
    Route::get('/kanban', function () {
        // Check if user is logged in
        if (!session('user.logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to access kanban board.');
        }
        
        return view('project-management.kanban');
    })->name('kanban');

    Route::get('/gantt', function () {
        // Check if user is logged in
        if (!session('user.logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to access gantt chart.');
        }
        
        return view('project-management.gantt');
    })->name('gantt');

    // Settings routes
    Route::get('/settings', function () {
        // Check if user is logged in
        if (!session('user.logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to access settings.');
        }
        
        return view('settings.index');
    })->name('settings');

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

    // Import routes
    Route::post('/import/students', function (Illuminate\Http\Request $request) {
        // Check if user is admin
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        try {
            $jsonData = $request->input('data');
            
            if (!$jsonData) {
                return response()->json(['error' => 'No data provided'], 400);
            }
            
            $data = json_decode($jsonData, true);
            
            if (!$data || !is_array($data)) {
                return response()->json(['error' => 'Invalid JSON data'], 400);
            }
            
            // Get headers from first row
            $headers = array_keys($data[0] ?? []);
            
            // Validate required headers for students
            $requiredHeaders = ['first_name', 'last_name', 'email', 'registration_number'];
            foreach ($requiredHeaders as $header) {
                if (!in_array($header, $headers)) {
                    return response()->json(['error' => "Missing required column: $header"], 400);
                }
            }
            
            $importedCount = 0;
            $errors = [];
            
            foreach ($data as $index => $row) {
                try {
                    // Validate required fields
                    if (empty($row['first_name']) || empty($row['last_name']) || 
                        empty($row['email']) || empty($row['registration_number'])) {
                        $errors[] = "Row " . ($index + 1) . ": Missing required fields";
                        continue;
                    }
                    
                    // Validate email format
                    if (!filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Row " . ($index + 1) . ": Invalid email format";
                        continue;
                    }
                    
                    // Check if email already exists
                    if (\App\Models\User::where('email', $row['email'])->exists()) {
                        $errors[] = "Row " . ($index + 1) . ": Email already exists";
                        continue;
                    }
                    
                    // Check if registration number already exists
                    if (\App\Models\User::where('registration_number', $row['registration_number'])->exists()) {
                        $errors[] = "Row " . ($index + 1) . ": Registration number already exists";
                        continue;
                    }
                    
                    // Create student user
                    $user = new \App\Models\User();
                    $user->first_name = $row['first_name'];
                    $user->last_name = $row['last_name'];
                    $user->name = $row['first_name'] . ' ' . $row['last_name'];
                    $user->email = $row['email'];
                    $user->registration_number = $row['registration_number'];
                    $user->phone = $row['phone'] ?? null;
                    $user->gender = $row['gender'] ?? null;
                    $user->status = 'active';
                    $user->password = \Hash::make('password123'); // Default password
                    $user->save();
                    
                    // Assign student role
                    $user->assignRole('student');
                    
                    $importedCount++;
                    
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 1) . ": " . $e->getMessage();
                }
            }
            
            $response = [
                'success' => true,
                'imported' => $importedCount,
                'errors' => $errors
            ];
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Import failed: ' . $e->getMessage()], 500);
        }
    })->name('import.students');

    Route::post('/import/supervisors', function (Illuminate\Http\Request $request) {
        // Check if user is admin
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        try {
            $jsonData = $request->input('data');
            
            if (!$jsonData) {
                return response()->json(['error' => 'No data provided'], 400);
            }
            
            $data = json_decode($jsonData, true);
            
            if (!$data || !is_array($data)) {
                return response()->json(['error' => 'Invalid JSON data'], 400);
            }
            
            // Get headers from first row
            $headers = array_keys($data[0] ?? []);
            
            // Validate required headers for supervisors
            $requiredHeaders = ['first_name', 'last_name', 'email'];
            foreach ($requiredHeaders as $header) {
                if (!in_array($header, $headers)) {
                    return response()->json(['error' => "Missing required column: $header"], 400);
                }
            }
            
            $importedCount = 0;
            $errors = [];
            
            foreach ($data as $index => $row) {
                try {
                    // Validate required fields
                    if (empty($row['first_name']) || empty($row['last_name']) || 
                        empty($row['email'])) {
                        $errors[] = "Row " . ($index + 1) . ": Missing required fields";
                        continue;
                    }
                    
                    // Validate email format
                    if (!filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Row " . ($index + 1) . ": Invalid email format";
                        continue;
                    }
                    
                    // Check if email already exists
                    if (\App\Models\User::where('email', $row['email'])->exists()) {
                        $errors[] = "Row " . ($index + 1) . ": Email already exists";
                        continue;
                    }
                    
                    // Create supervisor user
                    $user = new \App\Models\User();
                    $user->first_name = $row['first_name'];
                    $user->last_name = $row['last_name'];
                    $user->name = $row['first_name'] . ' ' . $row['last_name'];
                    $user->email = $row['email'];
                    $user->phone = $row['phone'] ?? null;
                    $user->gender = $row['gender'] ?? null;
                    $user->status = 'active';
                    $user->password = \Hash::make('password123'); // Default password
                    $user->save();
                    
                    // Assign supervisor role
                    $user->assignRole('supervisor');
                    
                    $importedCount++;
                    
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 1) . ": " . $e->getMessage();
                }
            }
            
            $response = [
                'success' => true,
                'imported' => $importedCount,
                'errors' => $errors
            ];
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Import failed: ' . $e->getMessage()], 500);
        }
    })->name('import.supervisors');

    Route::get('/export/users', function (Illuminate\Http\Request $request) {
        // Check if user is admin
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        try {
            // Get users with their roles
            $users = \App\Models\User::with('roles')->get();
            
            // Prepare CSV data
            $csvData = [];
            $csvData[] = ['Name', 'Email', 'Role', 'Status'];
            
            foreach ($users as $user) {
                $role = $user->roles->first()->name ?? 'user';
                $csvData[] = [
                    $user->name,
                    $user->email,
                    ucfirst($role),
                    ucfirst($user->status)
                ];
            }
            
            // Create CSV content
            $csvContent = '';
            foreach ($csvData as $row) {
                $csvContent .= '"' . implode('","', array_map('addslashes', $row)) . '"' . "\n";
            }
            
            // Create response
            $response = response($csvContent, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="users_export_' . date('Y-m-d') . '.csv"',
            ]);
            
            return $response;
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Export failed: ' . $e->getMessage()], 500);
        }
    })->name('export.users');

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

// Fallback route (must be last) - only redirect unknown routes to login for guest users
Route::get('/{path?}', function () {
    return redirect()->route('login');
})->where('path', '.*')->middleware('guest');

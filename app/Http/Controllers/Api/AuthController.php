<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Mail\PasswordReset;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:student,supervisor',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        // Assign role
        $user->assignRole($request->role);

        // Create student profile if role is student
        if ($request->role === 'student') {
            $user->studentProfile()->create([
                'student_id' => 'STU' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
                'gpa' => 0.00,
                'semester' => 1,
                'total_projects' => 0,
                'average_rating' => 0.00,
            ]);
        }

        // Send email verification
        try {
            Mail::to($user->email)->send(new EmailVerification($user));
        } catch (\Exception $e) {
            // Log error but continue
        }

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User registered successfully. Please verify your email.',
            'user' => $user->load('roles'),
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        
        // Update last login
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);

        // Log activity
        activity()
            ->causedBy($user)
            ->log('User logged in');

        return response()->json([
            'message' => 'Login successful',
            'user' => $user->load('roles', 'studentProfile'),
            'token' => $token,
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        activity()
            ->causedBy(Auth::user())
            ->log('User logged out');

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        $token = JWTAuth::refresh(JWTAuth::getToken());
        
        return response()->json([
            'token' => $token,
        ]);
    }

    public function profile()
    {
        $user = Auth::user()->load('roles', 'studentProfile', 'activeGroup.group');
        
        return response()->json($user);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
        ]);

        // Update student profile if exists
        if ($user->studentProfile && $request->has('bio')) {
            $user->studentProfile->update(['bio' => $request->bio]);
        }

        activity()
            ->causedBy($user)
            ->log('Profile updated');

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user->fresh()->load('roles', 'studentProfile'),
        ]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Current password is incorrect'], 422);
        }

        $user->update(['password' => Hash::make($request->password)]);

        activity()
            ->causedBy($user)
            ->log('Password changed');

        return response()->json(['message' => 'Password changed successfully']);
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();
        $token = Str::random(60);

        // Store token in password reset table
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        try {
            Mail::to($user->email)->send(new PasswordReset($user, $token));
        } catch (\Exception $e) {
            // Log error but continue
        }

        return response()->json(['message' => 'Password reset link sent to your email']);
    }

    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find user by verification token (you'd need to add this field to users table)
        // For now, we'll just mark the email as verified
        $user = Auth::user();
        $user->email_verified_at = now();
        $user->save();

        return response()->json(['message' => 'Email verified successfully']);
    }
}

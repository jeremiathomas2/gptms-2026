@extends('layouts.app-login')

@section('title', 'Login - GPTFMS')

@section('content')
<div class="h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md">
        <!-- Login Card -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-4 sm:p-6 lg:p-8 form-container fade-in scale-in">
            <!-- Header -->
            <div class="text-center mb-8 fade-in-slow">
                <div class="mx-auto h-12 w-12 bg-blue-600 rounded-lg flex items-center justify-center mb-6">
                    <span class="text-white font-bold text-xl">G</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Sign in to your account
                </h2>
                <p class="text-sm text-gray-600">
                    Or
                    <a href="#" onclick="toggleRegister()" class="font-medium text-blue-600 hover:text-blue-500 hover-fade">
                        create a new account
                    </a>
                </p>
            </div>

        <!-- Login Form -->
        <form class="mt-8 space-y-6" action="/login" method="POST">
            @csrf
            <input type="hidden" name="form_type" value="login">
            
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <div class="text-sm">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="space-y-4">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email address
                    </label>
                    <div class="mt-1 relative">
                        <input id="email" name="email" type="email" required
                               value="{{ old('email') }}"
                               class="form-input appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                               placeholder="Enter your email">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0V9a2 2 0 10-4 0v3a2 2 0 104 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1 relative">
                        <input id="password" name="password" type="password" required
                               class="form-input appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                               placeholder="Enter your password">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePassword('password')" class="text-gray-400 hover:text-gray-600">
                                <svg id="password-eye" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="button" onclick="submitLoginForm()" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                        </span>
                        Sign in
                    </button>
                </div>
            </div>
        </form>

            </div>
        <!-- End Login Card -->

    <!-- Registration Form (Hidden by default) -->
    <div id="register-form" class="max-w-md w-full hidden">
        <!-- Registration Card -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-4 sm:p-6 lg:p-8 form-container">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Create your account
                </h2>
                <p class="text-sm text-gray-600">
                    Or
                    <a href="#" onclick="toggleRegister()" class="font-medium text-blue-600 hover:text-blue-500">
                        sign in to your existing account
                    </a>
                </p>
            </div>

        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            <input type="hidden" name="form_type" value="register">
            
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <div class="text-sm">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="space-y-4">
                <!-- Name -->
                <div>
                    <label for="register-name" class="block text-sm font-medium text-gray-700">
                        Full Name
                    </label>
                    <input id="name" name="name" type="text" required
                           value="{{ old('name') }}"
                           class="form-input mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                           placeholder="Enter your full name">
                </div>

                <!-- Email -->
                <div>
                    <label for="register-email" class="block text-sm font-medium text-gray-700">
                        Email address
                    </label>
                    <input id="register-email" name="email" type="email" required
                           value="{{ old('email') }}"
                           class="form-input mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                           placeholder="Enter your email">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">
                        Role
                    </label>
                    <select id="role" name="role" required
                            class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm">
                        <option value="student">Student</option>
                        <option value="supervisor">Supervisor</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Password -->
                <div>
                    <label for="register-password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1 relative">
                        <input id="register-password" name="password" type="password" required
                               class="form-input appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                               placeholder="Create a password">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePassword('register-password')" class="text-gray-400 hover:text-gray-600">
                                <svg id="register-password-eye" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="register-confirm-password" class="block text-sm font-medium text-gray-700">
                        Confirm Password
                    </label>
                    <div class="mt-1 relative">
                        <input id="register-confirm-password" name="password_confirmation" type="password" required
                               class="form-input appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                               placeholder="Confirm your password">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePassword('register-confirm-password')" class="text-gray-400 hover:text-gray-600">
                                <svg id="register-confirm-password-eye" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </span>
                        Create Account
                    </button>
                </div>
            </div>
        </form>
        </div>
        <!-- End Registration Card -->
    </div>
</div>

<script>
// Aggressive form submission handler
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('form[method="POST"]');
    if (loginForm) {
        // Force the correct action
        loginForm.setAttribute('action', '/login');
        console.log('Login form action forced to:', loginForm.getAttribute('action'));
        
        // Intercept form submission
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Create a new form with correct action
            const newForm = document.createElement('form');
            newForm.method = 'POST';
            newForm.action = '/login';
            
            // Copy all form data
            const formData = new FormData(loginForm);
            for (let [key, value] of formData.entries()) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                newForm.appendChild(input);
            }
            
            // Add CSRF token if missing
            if (!formData.has('_token')) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = '_token';
                input.value = csrfToken;
                newForm.appendChild(input);
            }
            
            console.log('Submitting form to:', newForm.action);
            document.body.appendChild(newForm);
            newForm.submit();
        });
    }
});

function submitLoginForm() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Create form data
    const formData = new FormData();
    formData.append('_token', csrfToken);
    formData.append('form_type', 'login');
    formData.append('email', email);
    formData.append('password', password);
    
    // Submit using fetch to ensure correct URL
    fetch('/login', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    }).then(response => {
        if (response.ok) {
            // Login successful, redirect to dashboard
            window.location.href = '/dashboard';
        } else if (response.redirected) {
            // Handle redirect
            window.location.href = response.url;
        } else {
            // Handle error response
            return response.text();
        }
    }).then(html => {
        if (html) {
            // If we get HTML back, it means there was an error
            document.documentElement.innerHTML = html;
        }
    }).catch(error => {
        console.error('Login error:', error);
        // Show error message
        alert('Login failed. Please try again.');
    });
}

function toggleRegister() {
    const loginForm = document.querySelector('.max-w-md:first-child');
    const registerForm = document.getElementById('register-form');
    
    if (registerForm.classList.contains('hidden')) {
        loginForm.classList.add('hidden');
        registerForm.classList.remove('hidden');
    } else {
        registerForm.classList.add('hidden');
        loginForm.classList.remove('hidden');
    }
}

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-2.707 3.829m0 0L21 21"/>
        `;
    } else {
        field.type = 'password';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
    }
}

</script>
@endsection

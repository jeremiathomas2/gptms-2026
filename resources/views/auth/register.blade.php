@extends('layouts.app-login')

@section('title', 'Register - GPTFMS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-8">
    <div class="w-full max-w-md">
        <!-- Register Card -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-4 sm:p-6 lg:p-8 form-container">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-12 w-12 bg-blue-600 rounded-lg flex items-center justify-center mb-6">
                    <span class="text-white font-bold text-xl">G</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Create your account
                </h2>
                <p class="text-sm text-gray-600">
                    Or
                    <a href="/login" class="font-medium text-blue-600 hover:text-blue-500">
                        sign in to your existing account
                    </a>
                </p>
            </div>

        <!-- Register Form -->
        <form class="mt-8 space-y-6" action="/register" method="POST">
            @csrf
            <input type="hidden" name="form_type" value="register">
            
            <!-- Role Selection with Switch -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    User Type *
                </label>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <input type="radio" id="student" name="role" value="student" checked class="sr-only peer" required>
                        <label for="student" class="flex items-center px-4 py-2 bg-gray-100 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:bg-blue-600 peer-checked:border-blue-600 peer-checked:text-white hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span class="font-medium">Student</span>
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="supervisor" name="role" value="supervisor" class="sr-only peer" required>
                        <label for="supervisor" class="flex items-center px-4 py-2 bg-gray-100 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:bg-blue-600 peer-checked:border-blue-600 peer-checked:text-white hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                            <span class="font-medium">Supervisor</span>
                        </label>
                    </div>
                </div>
                <p id="role-description" class="mt-2 text-xs text-gray-500">
                    Students can join groups and participate in projects.
                </p>
            </div>

            <!-- Name Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                        First Name *
                    </label>
                    <input id="first_name" name="first_name" type="text" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter your first name">
                </div>
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Last Name *
                    </label>
                    <input id="last_name" name="last_name" type="text" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter your last name">
                </div>
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address *
                </label>
                <input id="email" name="email" type="email" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Enter your email address">
            </div>

            <!-- Phone Field -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                    Phone Number *
                </label>
                <input id="phone" name="phone" type="tel" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Enter your phone number">
            </div>

            <!-- Registration Number Field -->
            <div>
                <label for="registration_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Registration Number *
                </label>
                <input id="registration_number" name="registration_number" type="text" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Enter your registration number">
                <p class="mt-1 text-xs text-gray-500">
                    Your unique registration or student ID number.
                </p>
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>
                <input id="password" name="password" type="password" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Create a password">
            </div>

            <!-- Confirm Password Field -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirm Password
                </label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Confirm your password">
            </div>

            <!-- Terms and Conditions -->
            <div class="flex items-center">
                <input id="terms" name="terms" type="checkbox" required
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-sm text-gray-700">
                    I agree to the 
                    <a href="#" class="text-blue-600 hover:text-blue-500">Terms and Conditions</a>
                    and 
                    <a href="#" class="text-blue-600 hover:text-blue-500">Privacy Policy</a>
                </label>
            </div>

            <!-- Success Messages -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </h3>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Please fix the following errors:
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Submit Button -->
            <div>
                <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    Create Account
                </button>
            </div>

                    </form>
    </div>
</div>

<script>
// Role switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const studentRadio = document.getElementById('student');
    const supervisorRadio = document.getElementById('supervisor');
    const registrationNumberField = document.getElementById('registration_number').closest('div');
    const roleDescription = document.getElementById('role-description');
    
    function toggleRegistrationNumber() {
        if (supervisorRadio.checked) {
            // Hide registration number for supervisor
            registrationNumberField.style.display = 'none';
            roleDescription.textContent = 'Supervisors can create and manage groups and projects.';
        } else {
            // Show registration number for student
            registrationNumberField.style.display = 'block';
            roleDescription.textContent = 'Students can join groups and participate in projects.';
        }
    }
    
    // Add event listeners
    studentRadio.addEventListener('change', toggleRegistrationNumber);
    supervisorRadio.addEventListener('change', toggleRegistrationNumber);
    
    // Initialize on page load
    toggleRegistrationNumber();
});

// Enhanced form validation for GPTFMS system
document.querySelector('form').addEventListener('submit', function(e) {
    const firstName = document.getElementById('first_name').value.trim();
    const lastName = document.getElementById('last_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const registrationNumber = document.getElementById('registration_number').value.trim();
    const role = document.getElementById('role').value;
    const password = document.getElementById('password').value;
    const passwordConfirmation = document.getElementById('password_confirmation').value;
    const terms = document.getElementById('terms').checked;
    
    // First name validation
    if (firstName.length < 2) {
        e.preventDefault();
        showError('First name must be at least 2 characters long.');
        return false;
    }
    
    if (firstName.length > 255) {
        e.preventDefault();
        showError('First name cannot exceed 255 characters.');
        return false;
    }
    
    // Last name validation
    if (lastName.length < 2) {
        e.preventDefault();
        showError('Last name must be at least 2 characters long.');
        return false;
    }
    
    if (lastName.length > 255) {
        e.preventDefault();
        showError('Last name cannot exceed 255 characters.');
        return false;
    }
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        showError('Please provide a valid email address.');
        return false;
    }
    
    // Phone validation
    if (phone.length < 10) {
        e.preventDefault();
        showError('Phone number must be at least 10 characters long.');
        return false;
    }
    
    if (phone.length > 20) {
        e.preventDefault();
        showError('Phone number cannot exceed 20 characters.');
        return false;
    }
    
    // Registration number validation (only for students)
    const isStudent = document.getElementById('student').checked;
    if (isStudent) {
        if (!registrationNumber || registrationNumber.length < 3) {
            e.preventDefault();
            showError('Registration number must be at least 3 characters long.');
            return false;
        }
        
        if (registrationNumber.length > 50) {
            e.preventDefault();
            showError('Registration number cannot exceed 50 characters.');
            return false;
        }
    }
    
    // Role validation
    if (!role || (role !== 'student' && role !== 'supervisor')) {
        e.preventDefault();
        showError('Please select your user type.');
        return false;
    }
    
    // Password validation
    if (password.length < 8) {
        e.preventDefault();
        showError('Password must be at least 8 characters long.');
        return false;
    }
    
    if (password !== passwordConfirmation) {
        e.preventDefault();
        showError('Password confirmation does not match.');
        return false;
    }
    
    // Terms validation
    if (!terms) {
        e.preventDefault();
        showError('You must accept the terms and conditions.');
        return false;
    }
    
    return true;
});

// Show error message function
function showError(message) {
    // Remove any existing error alerts
    const existingAlerts = document.querySelectorAll('.alert-error');
    existingAlerts.forEach(alert => alert.remove());
    
    // Create error alert
    const errorDiv = document.createElement('div');
    errorDiv.className = 'alert-error bg-red-50 border border-red-200 rounded-lg p-4 mb-6';
    errorDiv.innerHTML = `
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">
                    ${message}
                </h3>
            </div>
        </div>
    `;
    
    // Insert before the form
    const form = document.querySelector('form');
    form.parentNode.insertBefore(errorDiv, form);
    
    // Scroll to top to show error
    window.scrollTo({ top: 0, behavior: 'smooth' });
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        errorDiv.remove();
    }, 5000);
}

// Real-time validation feedback
document.getElementById('password_confirmation').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmation = this.value;
    
    if (confirmation && password !== confirmation) {
        this.classList.add('border-red-500');
        this.classList.remove('border-green-500');
    } else if (confirmation && password === confirmation) {
        this.classList.add('border-green-500');
        this.classList.remove('border-red-500');
    } else {
        this.classList.remove('border-red-500', 'border-green-500');
    }
});
</script>
@endsection

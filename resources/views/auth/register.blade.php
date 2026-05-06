@extends('layouts.app-login')

@section('title', 'Register - GPTFMS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-8">
    <div class="w-full max-w-md">
        <!-- Register Card -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-4 sm:p-6 lg:p-8">
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
                
                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        User Type *
                    </label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="radio" id="student" name="role" value="student" checked class="sr-only peer" required>
                            <label for="student" class="flex items-center px-4 py-2 bg-gray-100 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:bg-blue-600 peer-checked:border-blue-600 peer-checked:text-white hover:bg-gray-200 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <span class="font-medium">Student</span>
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="supervisor" name="role" value="supervisor" class="sr-only peer" required>
                            <label for="supervisor" class="flex items-center px-4 py-2 bg-gray-100 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:bg-blue-600 peer-checked:border-blue-600 peer-checked:text-white hover:bg-gray-200 transition-all duration-200">
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

                <!-- Gender Field -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                        Gender *
                    </label>
                    <select id="gender" name="gender" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select your gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <!-- Registration Number Field - controlled by JavaScript -->
                <div id="registration-number-wrapper"></div>

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
                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                        I agree to the <a href="#" class="text-blue-600 hover:text-blue-500">Terms and Conditions</a>
                    </label>
                </div>

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
</div>

<style>
/* Add transitions for user type selection buttons */
label[for="student"],
label[for="supervisor"] {
    transition: all 0.3s ease;
    transform-origin: center;
}

label[for="student"]:hover,
label[for="supervisor"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const studentRadio = document.getElementById('student');
    const supervisorRadio = document.getElementById('supervisor');
    const roleDescription = document.getElementById('role-description');
    const registrationWrapper = document.getElementById('registration-number-wrapper');
    
    console.log('Initializing registration form');
    
    if (studentRadio && supervisorRadio && roleDescription && registrationWrapper) {
        
        function updateRegistrationField() {
            console.log('Updating registration field');
            console.log('Student checked:', studentRadio.checked);
            console.log('Supervisor checked:', supervisorRadio.checked);
            
            if (studentRadio.checked) {
                // Show registration number field for student
                registrationWrapper.innerHTML = `
                    <div class="mb-4">
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
                `;
                roleDescription.textContent = 'Students can join groups and participate in projects.';
                console.log('Registration field added for student');
            } else {
                // Hide registration number field for supervisor
                registrationWrapper.innerHTML = '';
                roleDescription.textContent = 'Supervisors can create and manage groups and projects.';
                console.log('Registration field removed for supervisor');
            }
        }
        
        // Handle radio button changes
        studentRadio.addEventListener('change', updateRegistrationField);
        supervisorRadio.addEventListener('change', updateRegistrationField);
        
        // Handle label clicks
        const studentLabel = document.querySelector('label[for="student"]');
        const supervisorLabel = document.querySelector('label[for="supervisor"]');
        
        if (studentLabel) {
            studentLabel.addEventListener('click', function(e) {
                e.preventDefault();
                studentRadio.checked = true;
                supervisorRadio.checked = false;
                updateRegistrationField();
            });
        }
        
        if (supervisorLabel) {
            supervisorLabel.addEventListener('click', function(e) {
                e.preventDefault();
                supervisorRadio.checked = true;
                studentRadio.checked = false;
                updateRegistrationField();
            });
        }
        
        // Initialize on page load
        updateRegistrationField();
        console.log('Registration form initialized successfully');
        
    } else {
        console.error('Required elements not found');
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const firstName = document.getElementById('first_name').value.trim();
    const lastName = document.getElementById('last_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const password = document.getElementById('password').value;
    const passwordConfirmation = document.getElementById('password_confirmation').value;
    const terms = document.getElementById('terms').checked;
    const selectedRole = document.querySelector('input[name="role"]:checked');
    
    // Basic validations
    if (firstName.length < 2) {
        e.preventDefault();
        alert('First name must be at least 2 characters long.');
        return false;
    }
    
    if (lastName.length < 2) {
        e.preventDefault();
        alert('Last name must be at least 2 characters long.');
        return false;
    }
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Please provide a valid email address.');
        return false;
    }
    
    if (phone.length < 10) {
        e.preventDefault();
        alert('Phone number must be at least 10 characters long.');
        return false;
    }
    
    // Registration number validation for students
    if (selectedRole && selectedRole.value === 'student') {
        const registrationNumber = document.getElementById('registration_number');
        if (!registrationNumber || !registrationNumber.value.trim()) {
            e.preventDefault();
            alert('Registration number is required for students.');
            return false;
        }
    }
    
    if (password.length < 8) {
        e.preventDefault();
        alert('Password must be at least 8 characters long.');
        return false;
    }
    
    if (password !== passwordConfirmation) {
        e.preventDefault();
        alert('Password confirmation does not match.');
        return false;
    }
    
    if (!terms) {
        e.preventDefault();
        alert('You must agree to the terms and conditions.');
        return false;
    }
    
    return true;
});
</script>

@endsection

@extends('layouts.app')

@section('title', 'Student Skills Survey - GPTFMS')

@section('content')
<!-- Authentication Status Check -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check authentication status when page loads
    fetch('/api/auth-check', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        console.log('Auth check result:', data);
        if (!data.authenticated) {
            console.error('User not authenticated on survey page');
        }
    })
    .catch(error => {
        console.error('Auth check failed:', error);
    });
});
</script>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Survey Header -->
        <div class="text-center mb-8">
            <div class="mx-auto h-16 w-16 bg-blue-600 rounded-lg flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Skills & Preferences Survey</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Help us create the perfect groups for you! This survey helps us understand your skills, experience, and preferences to match you with the best team members.
            </p>
        </div>

        <!-- Survey Form -->
        <form id="surveyForm" class="bg-white rounded-lg shadow-lg p-8">
            @csrf
            <input type="hidden" name="form_type" value="survey">
            
            <!-- Skills Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    Technical Skills
                </h2>
                <p class="text-gray-600 mb-4">Select all skills you're comfortable with (select at least one):</p>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="skills[]" value="PHP" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">PHP</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="skills[]" value="JavaScript" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">JavaScript</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="skills[]" value="Python" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">Python</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="skills[]" value="Java" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">Java</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="skills[]" value="React" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">React</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="skills[]" value="Vue.js" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">Vue.js</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="skills[]" value="Node.js" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">Node.js</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="skills[]" value="MySQL" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">MySQL</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="skills[]" value="MongoDB" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">MongoDB</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="skills[]" value="HTML/CSS" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">HTML/CSS</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="skills[]" value="Git" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">Git</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="skills[]" value="Docker" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">Docker</span>
                    </label>
                </div>
            </div>

            <!-- Experience Level -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Experience Level
                </h2>
                <p class="text-gray-600 mb-4">How would you rate your overall programming experience?</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="radio" name="experience_level" value="beginner" class="mr-3 text-blue-600" required>
                        <div>
                            <span class="block font-medium text-gray-900">Beginner</span>
                            <span class="block text-sm text-gray-500">Just starting out</span>
                        </div>
                    </label>
                    <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="radio" name="experience_level" value="intermediate" class="mr-3 text-blue-600" required>
                        <div>
                            <span class="block font-medium text-gray-900">Intermediate</span>
                            <span class="block text-sm text-gray-500">Some experience</span>
                        </div>
                    </label>
                    <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="radio" name="experience_level" value="advanced" class="mr-3 text-blue-600" required>
                        <div>
                            <span class="block font-medium text-gray-900">Advanced</span>
                            <span class="block text-sm text-gray-500">Experienced developer</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Interests Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    Project Interests
                </h2>
                <p class="text-gray-600 mb-4">What types of projects interest you most? (select at least one):</p>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="interests[]" value="Web Development" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">Web Development</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="interests[]" value="Mobile Apps" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">Mobile Apps</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="interests[]" value="Data Science" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">Data Science</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="interests[]" value="Machine Learning" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">Machine Learning</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="interests[]" value="Game Development" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">Game Development</span>
                    </label>
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                        <input type="checkbox" name="interests[]" value="UI/UX Design" class="mr-3 text-blue-600">
                        <span class="text-sm font-medium">UI/UX Design</span>
                    </label>
                </div>
            </div>

            <!-- Project Preferences -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Project Preferences
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Team Size</label>
                        <select name="project_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Select preference</option>
                            <option value="individual">Individual projects</option>
                            <option value="team">Team projects</option>
                            <option value="both">Both individual and team</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Project Duration</label>
                        <select name="project_duration" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Select preference</option>
                            <option value="short">Short projects (1-2 weeks)</option>
                            <option value="medium">Medium projects (3-6 weeks)</option>
                            <option value="long">Long projects (7+ weeks)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Goals Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138 3.42 3.42 0 001.946-.806z"/>
                    </svg>
                    Your Goals
                </h2>
                <p class="text-gray-600 mb-4">What do you hope to achieve through this project? (required)</p>
                <textarea name="goals" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tell us about your learning goals, career aspirations, or what you'd like to accomplish..." required></textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Submit Survey</span>
                </button>
            </div>
        </form>

        <!-- Success Message (hidden by default) -->
        <div id="successMessage" class="hidden bg-green-50 border border-green-200 rounded-lg p-6 text-center">
            <svg class="w-16 h-16 text-green-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-semibold text-green-900 mb-2">Survey Completed Successfully!</h3>
            <p class="text-green-700 mb-4">Thank you for completing the survey. Your responses will help us create the perfect groups for you.</p>
            <a href="/dashboard" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                Go to Dashboard
            </a>
        </div>
    </div>
</div>

<script>
document.getElementById('surveyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Collect form data properly
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    // Convert FormData to JSON object
    const data = {
        skills: [],
        experience_level: formData.get('experience_level'),
        interests: [],
        project_type: formData.get('project_type'),
        project_duration: formData.get('project_duration'),
        goals: formData.get('goals')
    };
    
    // Collect skills from checkboxes
    const skillCheckboxes = document.querySelectorAll('input[name="skills[]"]:checked');
    skillCheckboxes.forEach(checkbox => {
        data.skills.push(checkbox.value);
    });
    
    // Collect interests from checkboxes
    const interestCheckboxes = document.querySelectorAll('input[name="interests[]"]:checked');
    interestCheckboxes.forEach(checkbox => {
        data.interests.push(checkbox.value);
    });
    
    // Validate required fields
    if (data.skills.length === 0) {
        alert('Please select at least one skill.');
        return;
    }
    if (!data.experience_level) {
        alert('Please select your experience level.');
        return;
    }
    if (data.interests.length === 0) {
        alert('Please select at least one area of interest.');
        return;
    }
    if (!data.project_type) {
        alert('Please select your preferred project type.');
        return;
    }
    if (!data.project_duration) {
        alert('Please select your preferred project duration.');
        return;
    }
    if (!data.goals || data.goals.trim() === '') {
        alert('Please describe your goals.');
        return;
    }
    
    // Show loading state
    submitButton.disabled = true;
    submitButton.innerHTML = '<svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Submitting...';
    
    console.log('Submitting survey data:', data);
    
    // Check for CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    console.log('CSRF Token check:', {
        token: csrfToken ? 'present' : 'missing',
        tokenLength: csrfToken ? csrfToken.length : 0
    });
    
    // Check current URL and authentication status
    console.log('Authentication check:', {
        currentUrl: window.location.href,
        pathname: window.location.pathname,
        timestamp: new Date().toISOString()
    });
    
    fetch('/survey/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data),
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Hide form and show success message
            document.getElementById('surveyForm').classList.add('hidden');
            document.getElementById('successMessage').classList.remove('hidden');
        } else {
            // Show error message with validation details if available
            let errorMessage = 'Error: ' + (data.message || 'Failed to submit survey');
            if (data.errors) {
                Object.keys(data.errors).forEach(field => {
                    errorMessage += '\n' + field + ': ' + data.errors[field].join(', ');
                });
            }
            console.error('Survey submission failed:', errorMessage);
            alert(errorMessage);
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        console.error('Error details:', {
            message: error.message,
            stack: error.stack
        });
        alert('An error occurred while submitting the survey. Please try again.');
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    });
});
</script>
@endsection

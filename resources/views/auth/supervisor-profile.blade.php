@extends('layouts.app-login')

@section('title', 'Supervisor Profile - GPTFMS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-8">
    <div class="w-full max-w-4xl">
        <!-- Supervisor Profile Card -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6 sm:p-8 lg:p-10">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-12 w-12 bg-green-600 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Complete Your Supervisor Profile
                </h2>
                <p class="text-sm text-gray-600">
                    Help us understand your expertise and preferences to match you with suitable students
                </p>
            </div>

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Profile Completion</span>
                    <span class="text-sm font-medium text-gray-700" id="progress-text">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full transition-all duration-300" id="progress-bar" style="width: 0%"></div>
                </div>
            </div>

            <!-- Profile Form -->
            <form id="supervisor-profile-form" class="space-y-8" action="/supervisor-profile" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ session('user.id') ?? '' }}">
                
                <!-- Professional Information -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Professional Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Department *</label>
                            <select name="department" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                <option value="">Select department</option>
                                <option value="computer_science">Computer Science</option>
                                <option value="information_technology">Information Technology</option>
                                <option value="software_engineering">Software Engineering</option>
                                <option value="data_science">Data Science</option>
                                <option value="cybersecurity">Cybersecurity</option>
                                <option value="artificial_intelligence">Artificial Intelligence</option>
                                <option value="web_development">Web Development</option>
                                <option value="mobile_development">Mobile Development</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Position *</label>
                            <input type="text" name="position" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                   placeholder="e.g., Senior Lecturer, Professor, Industry Expert">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Years of Experience *</label>
                            <input type="number" name="years_of_experience" min="0" max="50" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                   placeholder="Number of years">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Highest Education *</label>
                            <select name="highest_education" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                <option value="">Select education level</option>
                                <option value="bachelor">Bachelor's Degree</option>
                                <option value="master">Master's Degree</option>
                                <option value="phd">PhD/Doctorate</option>
                                <option value="postdoc">Postdoctoral</option>
                                <option value="professional">Professional Certification</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Specializations -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                        Areas of Specialization
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="specializations[]" value="web_development" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="text-sm">Web Development</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="specializations[]" value="mobile_apps" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="text-sm">Mobile Applications</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="specializations[]" value="data_science" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="text-sm">Data Science & Analytics</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="specializations[]" value="machine_learning" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="text-sm">Machine Learning & AI</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="specializations[]" value="cloud_computing" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="text-sm">Cloud Computing</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="specializations[]" value="cybersecurity" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="text-sm">Cybersecurity</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="specializations[]" value="database_systems" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="text-sm">Database Systems</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="specializations[]" value="software_architecture" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="text-sm">Software Architecture</span>
                        </label>
                    </div>
                </div>

                <!-- Bio and Preferences -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        About You & Preferences
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Professional Bio *</label>
                            <textarea name="bio" rows="4" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                      placeholder="Tell us about your professional background, research interests, and teaching philosophy..."></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Certifications (optional)</label>
                            <input type="text" name="certifications"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                   placeholder="e.g., PMP, AWS Certified, Scrum Master">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Maximum Students to Supervise *</label>
                                <input type="number" name="max_students" min="1" max="50" value="10" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Availability Status *</label>
                                <select name="is_available" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                    <option value="1">Available for Supervision</option>
                                    <option value="0">Currently Unavailable</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Student Preferences -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Student Preferences
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Student Level</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="preferences[student_level][]" value="beginner" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <span class="text-sm">Beginner Level Students</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="preferences[student_level][]" value="intermediate" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <span class="text-sm">Intermediate Level Students</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="preferences[student_level][]" value="advanced" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <span class="text-sm">Advanced Level Students</span>
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Project Types You Prefer</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="preferences[project_types][]" value="research" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <span class="text-sm">Research Projects</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="preferences[project_types][]" value="development" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <span class="text-sm">Development Projects</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="preferences[project_types][]" value="design" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <span class="text-sm">Design Projects</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="preferences[project_types][]" value="innovation" class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <span class="text-sm">Innovation/Startup Projects</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="saveProgress()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Save Progress
                    </button>
                    <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center">
                        <span>Complete Profile</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Progress tracking
function updateProgress() {
    const form = document.getElementById('supervisor-profile-form');
    const totalFields = form.querySelectorAll('input[required], select[required], textarea[required]').length;
    const filledFields = form.querySelectorAll('input[required]:checked, input[required]:not([value=""]), select[required]:not([value=""]), textarea[required]:not([value=""])').length;
    const progress = Math.round((filledFields / totalFields) * 100);
    
    document.getElementById('progress-bar').style.width = progress + '%';
    document.getElementById('progress-text').textContent = progress + '%';
}

// Add event listeners for progress tracking
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('supervisor-profile-form');
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('change', updateProgress);
        input.addEventListener('input', updateProgress);
    });
    
    // Initial progress update
    updateProgress();
});

// Save progress function
function saveProgress() {
    const formData = new FormData(document.getElementById('supervisor-profile-form'));
    const data = {};
    
    for (let [key, value] of formData.entries()) {
        if (!data[key]) {
            data[key] = value;
        } else if (Array.isArray(data[key])) {
            data[key].push(value);
        } else {
            data[key] = [data[key], value];
        }
    }
    
    localStorage.setItem('supervisorProfileProgress', JSON.stringify(data));
    
    // Show success message
    const button = event.target;
    const originalText = button.textContent;
    button.textContent = 'Progress Saved!';
    button.classList.add('bg-green-600', 'text-white');
    
    setTimeout(() => {
        button.textContent = originalText;
        button.classList.remove('bg-green-600', 'text-white');
    }, 2000);
}

// Load saved progress on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedProgress = localStorage.getItem('supervisorProfileProgress');
    if (savedProgress) {
        const data = JSON.parse(savedProgress);
        const form = document.getElementById('supervisor-profile-form');
        
        // Restore form data
        Object.keys(data).forEach(key => {
            if (Array.isArray(data[key])) {
                data[key].forEach(value => {
                    const checkbox = form.querySelector(`input[name="${key}[]"][value="${value}"]`);
                    if (checkbox) checkbox.checked = true;
                });
            } else {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) {
                    if (input.type === 'radio' || input.type === 'checkbox') {
                        input.checked = true;
                    } else {
                        input.value = data[key];
                    }
                }
            }
        });
        
        updateProgress();
    }
});
</script>
@endsection

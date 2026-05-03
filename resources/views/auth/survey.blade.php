@extends('layouts.app-login')

@section('title', 'Skills Survey - GPTFMS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-8">
    <div class="w-full max-w-4xl">
        <!-- Survey Card -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6 sm:p-8 lg:p-10">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-12 w-12 bg-blue-600 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Skills Assessment Survey
                </h2>
                <p class="text-sm text-gray-600">
                    Help us understand your skills and interests to provide personalized recommendations
                </p>
            </div>

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Progress</span>
                    <span class="text-sm font-medium text-gray-700" id="progress-text">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" id="progress-bar" style="width: 0%"></div>
                </div>
            </div>

            <!-- Survey Form -->
            <form id="survey-form" class="space-y-8" action="/survey" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ session('user.id') ?? '' }}">
                
                <!-- Technical Skills Section -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                        Technical Skills
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="skill-field">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Programming Languages</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="skills[programming][]" value="javascript" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">JavaScript</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="skills[programming][]" value="python" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Python</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="skills[programming][]" value="java" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Java</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="skills[programming][]" value="php" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">PHP</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="skills[programming][]" value="csharp" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">C#</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="skill-field">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Web Technologies</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="skills[web][]" value="html" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">HTML/CSS</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="skills[web][]" value="react" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">React</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="skills[web][]" value="vue" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Vue.js</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="skills[web][]" value="angular" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Angular</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="skills[web][]" value="laravel" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Laravel</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Experience Level -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Experience Level
                    </h3>
                    <div class="space-y-3">
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="experience_level" value="beginner" class="mr-3 text-blue-600 focus:ring-blue-500" required>
                            <div>
                                <span class="font-medium text-gray-900">Beginner</span>
                                <p class="text-sm text-gray-600">Just starting out, learning the basics</p>
                            </div>
                        </label>
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="experience_level" value="intermediate" class="mr-3 text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="font-medium text-gray-900">Intermediate</span>
                                <p class="text-sm text-gray-600">Comfortable with basic concepts and some advanced topics</p>
                            </div>
                        </label>
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="experience_level" value="advanced" class="mr-3 text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="font-medium text-gray-900">Advanced</span>
                                <p class="text-sm text-gray-600">Experienced with complex projects and concepts</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Areas of Interest -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        Areas of Interest
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="interests[]" value="web_development" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm">Web Development</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="interests[]" value="mobile_development" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm">Mobile Development</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="interests[]" value="data_science" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm">Data Science</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="interests[]" value="machine_learning" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm">Machine Learning</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="interests[]" value="ui_ux_design" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm">UI/UX Design</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="interests[]" value="cloud_computing" class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm">Cloud Computing</span>
                        </label>
                    </div>
                </div>

                <!-- Project Preferences -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Project Preferences
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Project Type</label>
                            <select name="project_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">Select project type</option>
                                <option value="individual">Individual Projects</option>
                                <option value="team">Team Projects</option>
                                <option value="both">Both Individual and Team</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Project Duration Preference</label>
                            <select name="project_duration" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">Select duration</option>
                                <option value="short">Short-term (1-2 weeks)</option>
                                <option value="medium">Medium-term (1-2 months)</option>
                                <option value="long">Long-term (3+ months)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Additional Information
                    </h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tell us about your goals (optional)</label>
                        <textarea name="goals" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="What do you hope to achieve through this program?"></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="saveProgress()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Save Progress
                    </button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                        <span>Complete Survey</span>
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
    const form = document.getElementById('survey-form');
    const totalFields = form.querySelectorAll('input[required], select[required]').length;
    const filledFields = form.querySelectorAll('input[required]:checked, select[required]:not([value=""])').length;
    const progress = Math.round((filledFields / totalFields) * 100);
    
    document.getElementById('progress-bar').style.width = progress + '%';
    document.getElementById('progress-text').textContent = progress + '%';
}

// Add event listeners for progress tracking
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('survey-form');
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
    const formData = new FormData(document.getElementById('survey-form'));
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
    
    localStorage.setItem('surveyProgress', JSON.stringify(data));
    
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
    const savedProgress = localStorage.getItem('surveyProgress');
    if (savedProgress) {
        const data = JSON.parse(savedProgress);
        const form = document.getElementById('survey-form');
        
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

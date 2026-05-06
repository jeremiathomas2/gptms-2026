@extends('layouts.app')

@section('title', 'Manage Skills - GPTFMS')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Skills Header -->
        <div class="text-center mb-8">
            <div class="mx-auto h-16 w-16 bg-purple-600 rounded-lg flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Manage Your Skills</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Add or update your technical skills to help us match you with the perfect project opportunities.
            </p>
        </div>

        <!-- Current Skills Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Your Current Skills
            </h2>
            
            <div id="currentSkills" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                <!-- Skills will be loaded here via JavaScript -->
            </div>
            
            <div class="mt-4 flex justify-between items-center">
                <p class="text-sm text-gray-500">
                    <span id="skillCount">0</span> skills added
                </p>
                <button onclick="addNewSkill()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0l-3-3m3 3l3-3"/>
                    </svg>
                    <span>Add New Skill</span>
                </button>
            </div>
        </div>

        <!-- Add Skills Section -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Available Skills to Add
            </h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 cursor-pointer">
                    <input type="checkbox" value="PHP" class="mr-3 text-purple-600 skill-checkbox">
                    <span class="text-sm font-medium">PHP</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 cursor-pointer">
                    <input type="checkbox" value="JavaScript" class="mr-3 text-purple-600 skill-checkbox">
                    <span class="text-sm font-medium">JavaScript</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 cursor-pointer">
                    <input type="checkbox" value="Python" class="mr-3 text-purple-600 skill-checkbox">
                    <span class="text-sm font-medium">Python</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 cursor-pointer">
                    <input type="checkbox" value="Java" class="mr-3 text-purple-600 skill-checkbox">
                    <span class="text-sm font-medium">Java</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 cursor-pointer">
                    <input type="checkbox" value="React" class="mr-3 text-purple-600 skill-checkbox">
                    <span class="text-sm font-medium">React</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 cursor-pointer">
                    <input type="checkbox" value="Vue.js" class="mr-3 text-purple-600 skill-checkbox">
                    <span class="text-sm font-medium">Vue.js</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 cursor-pointer">
                    <input type="checkbox" value="Node.js" class="mr-3 text-purple-600 skill-checkbox">
                    <span class="text-sm font-medium">Node.js</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 cursor-pointer">
                    <input type="checkbox" value="MySQL" class="mr-3 text-purple-600 skill-checkbox">
                    <span class="text-sm font-medium">MySQL</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 cursor-pointer">
                    <input type="checkbox" value="MongoDB" class="mr-3 text-purple-600 skill-checkbox">
                    <span class="text-sm font-medium">MongoDB</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 cursor-pointer">
                    <input type="checkbox" value="HTML/CSS" class="mr-3 text-purple-600 skill-checkbox">
                    <span class="text-sm font-medium">HTML/CSS</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 cursor-pointer">
                    <input type="checkbox" value="Git" class="mr-3 text-purple-600 skill-checkbox">
                    <span class="text-sm font-medium">Git</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 cursor-pointer">
                    <input type="checkbox" value="Docker" class="mr-3 text-purple-600 skill-checkbox">
                    <span class="text-sm font-medium">Docker</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 cursor-pointer">
                    <input type="checkbox" value="AWS" class="mr-3 text-purple-600 skill-checkbox">
                    <span class="text-sm font-medium">AWS</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 cursor-pointer">
                    <input type="checkbox" value="TypeScript" class="mr-3 text-purple-600 skill-checkbox">
                    <span class="text-sm font-medium">TypeScript</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-purple-50 cursor-pointer">
                    <input type="checkbox" value="GraphQL" class="mr-3 text-purple-600 skill-checkbox">
                    <span class="text-sm font-medium">GraphQL</span>
                </label>
            </div>
            
            <div class="mt-6 flex justify-center">
                <button onclick="saveSkills()" class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Save Skills</span>
                </button>
            </div>
        </div>

        <!-- Success Message (hidden by default) -->
        <div id="successMessage" class="hidden bg-green-50 border border-green-200 rounded-lg p-6 text-center">
            <svg class="w-16 h-16 text-green-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-semibold text-green-900 mb-2">Skills Updated Successfully!</h3>
            <p class="text-green-700 mb-4">Your skills have been saved and will be used for project matching.</p>
            <a href="/dashboard" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                Back to Dashboard
            </a>
        </div>
    </div>
</div>

<script>
let currentSkills = [];

// Load current skills on page load
document.addEventListener('DOMContentLoaded', function() {
    loadCurrentSkills();
});

function loadCurrentSkills() {
    fetch('/skills/api', {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            currentSkills = data.skills || [];
            displayCurrentSkills();
            updateSkillCheckboxes();
        }
    })
    .catch(error => {
        console.error('Error loading skills:', error);
    });
}

function displayCurrentSkills() {
    const container = document.getElementById('currentSkills');
    const skillCount = document.getElementById('skillCount');
    
    container.innerHTML = '';
    
    if (currentSkills.length === 0) {
        container.innerHTML = '<p class="text-gray-500 col-span-full text-center py-8">No skills added yet. Select skills from the list below to get started.</p>';
        skillCount.textContent = '0';
        return;
    }
    
    currentSkills.forEach((skill, index) => {
        const skillElement = document.createElement('div');
        skillElement.className = 'bg-purple-100 border border-purple-200 rounded-lg p-3 flex items-center justify-between';
        skillElement.innerHTML = `
            <span class="text-sm font-medium text-purple-900">${skill}</span>
            <button onclick="removeSkill(${index})" class="text-red-600 hover:text-red-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;
        container.appendChild(skillElement);
    });
    
    skillCount.textContent = currentSkills.length;
}

function updateSkillCheckboxes() {
    const checkboxes = document.querySelectorAll('.skill-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = currentSkills.includes(checkbox.value);
    });
}

function addNewSkill() {
    const checkboxes = document.querySelectorAll('.skill-checkbox:checked');
    const newSkills = Array.from(checkboxes).map(cb => cb.value);
    
    // Add new skills to current skills (avoid duplicates)
    newSkills.forEach(skill => {
        if (!currentSkills.includes(skill)) {
            currentSkills.push(skill);
        }
    });
    
    displayCurrentSkills();
    updateSkillCheckboxes();
}

function removeSkill(index) {
    currentSkills.splice(index, 1);
    displayCurrentSkills();
    updateSkillCheckboxes();
}

function saveSkills() {
    // Validate that at least one skill is selected
    if (currentSkills.length === 0) {
        alert('Please select at least one skill before saving.');
        return;
    }
    
    const submitButton = document.querySelector('button[onclick="saveSkills()"]');
    const originalText = submitButton.innerHTML;
    
    // Show loading state
    submitButton.disabled = true;
    submitButton.innerHTML = '<svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';
    
    fetch('/skills/save', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            skills: currentSkills
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hide form and show success message
            document.querySelector('.bg-white.rounded-lg.shadow-lg').classList.add('hidden');
            document.getElementById('successMessage').classList.remove('hidden');
        } else {
            // Show error message with validation details if available
            let errorMessage = 'Error: ' + (data.message || 'Failed to save skills');
            if (data.errors && data.errors.skills) {
                errorMessage += '\nSkills validation: ' + data.errors.skills.join(', ');
            }
            alert(errorMessage);
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving skills. Please try again.');
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    });
}
</script>
@endsection

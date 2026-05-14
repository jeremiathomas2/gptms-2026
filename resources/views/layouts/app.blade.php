<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="theme-color" content="#3B82F6">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GPTFMS - Group Project Team Formation and Management System')</title>
    
    <!-- Phoenix Template Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Phoenix Template Icon Fonts -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Local CSS and JS Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional CSS for layout-specific styles -->
    <style>
        .sidebar-transition {
            transition: width 0.3s ease, margin-left 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.02);
            transition: transform 0.2s ease;
        }
        
        /* Responsive Design Enhancements */
        @media (max-width: 640px) {
            .main-content {
                padding: 1rem;
            }
            
            .sidebar-collapsed {
                margin-left: 4rem !important;
            }
            
            .sidebar-expanded {
                margin-left: 0 !important;
            }
            
            .mobile-hidden {
                display: none !important;
            }
            
            .mobile-full {
                width: 100% !important;
                max-width: 100% !important;
            }
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr !important;
                gap: 1rem;
            }
            
            .form-grid {
                grid-template-columns: 1fr !important;
            }
            
            .button-group {
                flex-direction: column !important;
                gap: 0.5rem;
            }
        }
        
        @media (max-width: 1024px) {
            .lg-grid-2 {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            
            .lg-grid-3 {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
        
        /* Touch-friendly interactions */
        @media (hover: none) and (pointer: coarse) {
            .sidebar-link {
                padding: 1rem;
                min-height: 3rem;
            }
            
            .btn {
                min-height: 2.5rem;
                padding: 0.75rem 1rem;
            }
            
            .form-input {
                min-height: 2.5rem;
                font-size: 16px; /* Prevents zoom on iOS */
            }
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .auto-dark {
                background-color: #1f2937;
                color: #f9fafb;
            }
        }
        
        /* Print styles */
        @media print {
            .no-print {
                display: none !important;
            }
            
            .print-full {
                width: 100% !important;
            }
        }
        
        /* Fade animations for authenticated pages */
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .fade-in-down {
            animation: fadeInDown 0.6s ease-out forwards;
        }
        
        .fade-in-left {
            animation: fadeInLeft 0.6s ease-out forwards;
        }
        
        .fade-in-right {
            animation: fadeInRight 0.6s ease-out forwards;
        }
        
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        .stagger-5 { animation-delay: 0.5s; }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div id="app" class="flex h-screen">
        @include('layouts.sidebar')
        
        <div class="flex-1 flex flex-col {{ request()->cookie('sidebar_open') == 'false' ? 'ml-16' : 'ml-64' }} sidebar-transition main-content" id="main-content">
            @include('layouts.header')
            
            <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-auto w-full" id="main-content-area">
                <div class="w-full max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <!-- Survey Completion Popup -->
    @if(isset($showSurveyPopup) && $showSurveyPopup && session('user.role') === 'student' && !$surveyCompleted)
        <div id="survey-popup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full mx-4 transform transition-all">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Complete Your Skills Survey</h3>
                    <p class="text-gray-600 mb-6">
                        {{ $studentName }}, please complete filling Your skills to help us better understand your abilities and provide you with personalized learning experiences.
                    </p>
                    
                    @if(session('user.role') === 'student' && !$surveyCompleted)
                        <div class="flex space-x-3">
                            <button onclick="completeSurvey({{ $surveyId }})" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Complete Survey
                            </button>
                        </div>
                    @endif
                        <button onclick="closeSurveyPopup()" class="flex-1 bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                            Later
                        </button>
                    </div>
                    
                    <p class="text-xs text-gray-500 mt-4">
                        You can complete this survey anytime from your profile settings.
                    </p>
                </div>
            </div>
        </div>
        
        <script>
            function closeSurveyPopup() {
                const popup = document.getElementById('survey-popup');
                if (popup) {
                    popup.remove();
                }
            }
            
            function completeSurvey(surveyId) {
                // Redirect to survey page or open survey modal
                window.location.href = '/survey/' + surveyId;
            }
            
            // Auto-close popup after 10 seconds if no action taken
            setTimeout(function() {
                closeSurveyPopup();
            }, 10000);
        </script>
    @endif
    
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>
</html>

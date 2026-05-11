<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GPTFMS - Group Project Team Formation and Management System')</title>
    
    <!-- Phoenix Template Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Phoenix Template Icon Fonts -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css'])
    
    <!-- Custom CSS -->
    <style>
        /* Custom styles to match React UI */
        .sidebar-transition {
            transition: width 0.3s ease, margin-left 0.3s ease;
        }
        
        .hover-scale:hover {
            transform: scale(1.02);
            transition: transform 0.2s ease;
        }
        
        .dropdown-enter {
            animation: slideDown 0.2s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .spinner {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Icon styles */
        .icon-sm { width: 16px; height: 16px; }
        .icon-md { width: 20px; height: 20px; }
        .icon-lg { width: 24px; height: 24px; }
        .icon-xl { width: 32px; height: 32px; }
        
        /* Responsive form styles */
        @media (max-width: 640px) {
            .form-container {
                max-height: 90vh;
                overflow-y: auto;
            }
            
            .form-input {
                font-size: 16px; /* Prevent zoom on iOS */
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div id="app" class="flex h-screen">
        <div class="flex-1 flex flex-col">
            @include('layouts.header-login')
            
            <main class="flex-1 overflow-auto">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    
    <!-- Custom Scripts -->
    @stack('scripts')
</body>
</html>

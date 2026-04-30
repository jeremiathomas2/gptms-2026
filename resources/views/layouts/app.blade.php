<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GPTFMS - Group Project Team Formation and Management System')</title>
    
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
    </style>
</head>
<body class="bg-gray-50">
    <div id="app" class="flex h-screen fade-in">
        @include('layouts.sidebar')
        
        <div class="flex-1 flex flex-col {{ request()->cookie('sidebar_open') == 'false' ? 'ml-16' : 'ml-64' }} sidebar-transition">
            @include('layouts.header')
            
            <main class="flex-1 p-8 overflow-auto page-transition">
                <div class="fade-in-slow">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>
</html>

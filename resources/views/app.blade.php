<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GPTFMS - Group Project Team Formation and Management System</title>
    
    <!-- Vite CSS Assets -->
    @vite(['resources/js/index.css'])
    
    <!-- Vite JavaScript Assets -->
    @vite(['resources/js/main.jsx'])
    
    <!-- Additional Meta Tags -->
    <meta name="description" content="Group Project Team Formation and Management System">
    <meta name="author" content="GPTFMS Team">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>
<body class="bg-gray-50">
    <div id="app">
        <!-- Initial content to show if React doesn't load -->
        <div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; background-color: #f9fafb;">
            <div style="text-align: center;">
                <h1 style="color: #1f2937; margin-bottom: 1rem;">GPTFMS Loading...</h1>
                <p style="color: #6b7280;">If you see this, the HTML is loading but React may not be mounting.</p>
            </div>
        </div>
    </div>
</body>
</html>

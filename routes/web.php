<?php

use Illuminate\Support\Facades\Route;

// Serve the React app for all routes (SPA routing)
Route::get('/{path?}', function () {
    return view('app');
})->where('path', '.*');

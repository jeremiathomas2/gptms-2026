<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

try {
    echo "Creating default users...\n";
    
    // Clear existing users
    DB::table('users')->delete();
    echo "Cleared existing users\n";
    
    // Create Admin user
    $admin = User::create([
        'first_name' => 'Admin',
        'last_name' => 'User',
        'email' => 'admin@gptfms.com',
        'password' => Hash::make('password'),
        'registration_number' => 'ADMIN_001',
        'phone' => '+1234567890',
        'bio' => 'System Administrator',
        'status' => 'active',
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    // Create Supervisor user
    $supervisor = User::create([
        'first_name' => 'John',
        'last_name' => 'Smith',
        'email' => 'john.smith@university.edu',
        'password' => Hash::make('password'),
        'registration_number' => 'SUP_002',
        'phone' => '+1234567891',
        'bio' => 'Experienced supervisor with expertise in software development and project management.',
        'status' => 'active',
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    // Create Student user
    $student = User::create([
        'first_name' => 'Alice',
        'last_name' => 'Wilson',
        'email' => 'alice.wilson@student.edu',
        'password' => Hash::make('password'),
        'registration_number' => 'STU_003',
        'phone' => '+1234567892',
        'bio' => 'Computer Science student interested in web development and machine learning.',
        'status' => 'active',
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    echo "✅ Users created successfully!\n";
    echo "📧 Admin: admin@gptfms.com (password: password)\n";
    echo "👨‍🏫 Supervisor: john.smith@university.edu (password: password)\n";
    echo "👩‍🎓 Student: alice.wilson@student.edu (password: password)\n";
    
} catch (Exception $e) {
    echo "❌ Error creating users: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

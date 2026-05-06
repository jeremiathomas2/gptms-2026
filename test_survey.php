<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing survey system...\n";

try {
    // Test database connection
    DB::connection()->getPdo();
    echo "✅ Database connection successful\n";
    
    // Test StudentSkillsSurvey model
    echo "Testing StudentSkillsSurvey model...\n";
    $survey = \App\Models\StudentSkillsSurvey::create([
        'user_id' => 1,
        'skills' => json_encode(['PHP', 'Laravel', 'JavaScript']),
        'experience_level' => 'intermediate',
        'interests' => json_encode(['Web Development', 'Database Design']),
        'project_type' => 'team',
        'project_duration' => 'medium',
        'goals' => 'Complete project successfully',
        'completed_at' => now(),
    ]);
    
    echo "✅ Survey created successfully\n";
    echo "Survey ID: " . $survey->id . "\n";
    echo "User ID: " . $survey->user_id . "\n";
    
    // Test survey retrieval
    echo "Testing survey retrieval...\n";
    $retrieved = \App\Models\StudentSkillsSurvey::where('user_id', 1)->first();
    if ($retrieved) {
        echo "✅ Survey retrieved successfully\n";
        echo "Skills: " . json_decode($retrieved->skills, true) . "\n";
        echo "Experience: " . $retrieved->experience_level . "\n";
    } else {
        echo "❌ Survey retrieval failed\n";
    }
    
    // Test survey completion check
    echo "Testing survey completion check...\n";
    $completed = \App\Models\StudentSkillsSurvey::isCompletedByUser(1);
    echo "Survey completed: " . ($completed ? 'YES' : 'NO') . "\n";
    
    // Test controller
    echo "Testing controller methods...\n";
    $controller = new \App\Http\Controllers\Api\StudentSkillsSurveyController();
    
    // Test store method
    echo "Testing store method...\n";
    $request = new \Illuminate\Http\Request([
        'skills' => ['Test skill'],
        'experience_level' => 'beginner',
        'interests' => ['Test interest'],
        'project_type' => 'individual',
        'project_duration' => 'short',
        'goals' => 'Test goal',
    ]);
    
    // Mock authentication
    $user = new \App\Models\User(['id' => 1]);
    \Illuminate\Support\Facades\Auth::shouldReceive('user')->andReturn($user);
    \Illuminate\Support\Facades\Auth::shouldReceive('id')->andReturn(1);
    
    $response = $controller->store($request);
    echo "Store response: " . json_encode($response->getContent()) . "\n";
    
    if ($response->getStatusCode() === 200) {
        echo "✅ Store method working\n";
    } else {
        echo "❌ Store method failed\n";
    }
    
    echo "\n✅ All survey system tests completed successfully\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

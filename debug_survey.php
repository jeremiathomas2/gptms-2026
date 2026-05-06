<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Debugging survey controller...\n";

// Test with simple string skills first
echo "Test 1: Simple string skills\n";
$request1 = new \Illuminate\Http\Request([
    'skills' => 'PHP,Laravel,JavaScript',
    'experience_level' => 'intermediate',
    'interests' => 'Web Development',
    'project_type' => 'individual',
    'project_duration' => 'short',
    'goals' => 'Test goals',
]);

$controller = new \App\Http\Controllers\Api\StudentSkillsSurveyController();

// Mock authentication
$user = new \App\Models\User(['id' => 1]);
\Illuminate\Support\Facades\Auth::shouldReceive('id')->andReturn(1);

try {
    $response1 = $controller->store($request1);
    echo "Response 1: " . json_encode($response1->getContent()) . "\n";
    echo "Status: " . ($response1->getStatusCode() === 200 ? "SUCCESS" : "FAILED") . "\n\n";
} catch (Exception $e) {
    echo "Error 1: " . $e->getMessage() . "\n";
}

// Test with array skills second
echo "\nTest 2: Array skills\n";
$request2 = new \Illuminate\Http\Request([
    'skills' => ['PHP', 'Laravel', 'JavaScript'],
    'experience_level' => 'advanced',
    'interests' => ['Web Development', 'Database Design'],
    'project_type' => 'team',
    'project_duration' => 'medium',
    'goals' => 'Team goals',
]);

try {
    $response2 = $controller->store($request2);
    echo "Response 2: " . json_encode($response2->getContent()) . "\n";
    echo "Status: " . ($response2->getStatusCode() === 200 ? "SUCCESS" : "FAILED") . "\n\n";
} catch (Exception $e) {
    echo "Error 2: " . $e->getMessage() . "\n";
}

echo "\nDebugging completed\n";

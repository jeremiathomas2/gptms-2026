<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking database connection...\n";
try {
    DB::connection()->getPdo();
    echo "✅ Database connected successfully\n";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\nChecking StudentSkillsSurvey table structure...\n";
$schema = DB::select('DESCRIBE student_skills_survey');
foreach ($schema as $column) {
    echo $column->Field . ': ' . $column->Type . "\n";
}

echo "\nChecking for existing survey data...\n";
$count = DB::table('student_skills_survey')->count();
echo "Total survey records: " . $count . "\n";

if ($count > 0) {
    echo "\nSample survey record:\n";
    $sample = DB::table('student_skills_survey')->first();
    if ($sample) {
        echo "User ID: " . $sample->user_id . "\n";
        echo "Skills: " . json_encode($sample->skills) . "\n";
        echo "Experience: " . $sample->experience_level . "\n";
        echo "Completed: " . ($sample->completed_at ? $sample->completed_at->format('Y-m-d H:i:s') : 'NULL') . "\n";
    }
}

echo "\n✅ Survey system check completed\n";

<?php

namespace App\Console\Commands;

use App\Services\ActivityLogger;
use Illuminate\Console\Command;

class CleanupActivityLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity:cleanup {--days=90 : Number of days to keep logs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old activity logs to maintain database performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $daysToKeep = $this->option('days');
        
        $this->info("Starting activity log cleanup...");
        $this->info("Keeping logs from the last {$daysToKeep} days");
        
        try {
            $deletedCount = ActivityLogger::cleanup($daysToKeep);
            
            $this->info("✅ Cleanup completed successfully!");
            $this->info("📊 Deleted {$deletedCount} old activity log entries");
            
            // Log the cleanup action
            ActivityLogger::logSystemEvent('cleanup', "Activity log cleanup completed", [
                'deleted_count' => $deletedCount,
                'days_kept' => $daysToKeep,
                'cleanup_date' => now()->toISOString(),
            ]);
            
        } catch (\Exception $e) {
            $this->error("❌ Cleanup failed: " . $e->getMessage());
            
            // Log the error
            ActivityLogger::logSystemEvent('cleanup_error', "Activity log cleanup failed", [
                'error' => $e->getMessage(),
                'days_kept' => $daysToKeep,
                'cleanup_date' => now()->toISOString(),
            ]);
            
            return 1;
        }
        
        return 0;
    }
}

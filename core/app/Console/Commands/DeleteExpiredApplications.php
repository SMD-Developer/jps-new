<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Application;

class DeleteExpiredApplications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'applications:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Change this value for testing
        $timeAgo = \Carbon\Carbon::now()->subHours(2); // For testing
        // $timeAgo = \Carbon\Carbon::now()->subDays(2); // For production
        
        $deletedCount = \App\Models\Application::where('status', 'approved')
            ->where('updated_at', '<=', $timeAgo)
            ->whereDoesntHave('payment')
            ->delete();

        $this->info("Deleted {$deletedCount} expired application(s).");
        
        return 0;
    }
}

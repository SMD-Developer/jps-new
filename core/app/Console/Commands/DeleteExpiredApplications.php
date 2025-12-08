<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Application;
use Carbon\Carbon;

class DeleteExpiredApplications extends Command
{
    protected $signature = 'applications:delete-expired';
    protected $description = 'Delete approved applications without payment after 2 days';

    public function handle()
    {
        $twoDaysAgo = Carbon::now()->subDays(2);
        $deletedCount = Application::where('status', 'approved')
            ->where('updated_at', '<=', $twoDaysAgo) 
            ->whereDoesntHave('payment') 
            ->delete();

        $this->info("Deleted {$deletedCount} expired applications.");
        
        return 0;
    }
}
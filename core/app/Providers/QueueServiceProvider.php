<?php

namespace App\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class QueueServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Queue::failing(function (JobFailed $event) {
            Log::error($event->exception);
        });

        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('queue:work --stop-when-empty --timeout=0')->everyMinute()->withoutOverlapping(10);
            $schedule->command('queue:restart')->hourly();
        });
    }
}

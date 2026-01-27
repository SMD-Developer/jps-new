<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
        'App\Console\Commands\SendRecurringInvoicesCommand',
		'App\Console\Commands\CheckFPXPaymentStatus',
		'App\Console\Commands\DeleteExpiredApplications', 
        //\Torann\Currency\Console\Update::class

	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('inspire')->hourly();
        $schedule->command('invoicer:recurring-invoices')->dailyAt('00:00');
		$schedule->command('fpx:check-status')
             ->everyFiveMinutes()
             ->runInBackground();

	    $schedule->command('applications:delete-expired')->everyMinute();
	}
}

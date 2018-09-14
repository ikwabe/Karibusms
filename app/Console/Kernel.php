<?php

namespace App\Console;

use DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
	Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {

	$schedule->call(function () {
	    // DB::table('recent_users')->delete();
	    DB::table('log')->insert([
		'ip_address' => '142.124.22.25',
		'agent' => 'cron',
		'latitude' => 1,
		'longtude' => 2,
		'page' => 'manpage'
	    ]);
	})->everyMinute();
//		->withoutOverlapping()
//		->appendOutputTo('storage/logs/cron_job_status.txt');
	$schedule->call(function () {
	    // Runs once a week on Monday at 06:00...
	    
	})->weekly()->mondays()->at('06:00');
    }

}

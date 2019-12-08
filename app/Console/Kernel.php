<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;
use Mail;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
            //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            $emails = DB::select(' select * from emails where status=0 limit 10');
            foreach ($emails as $mail) {
                $email=$mail->email;
                $subject=$mail->subject;
                $attachment=$mail->attachment;
                $client = DB::table('client')->where('email', $mail->email)->first();
                 Mail::send('admin.email_template', ['content' => $mail->content, 'client' => $client], function ($m) use ($email, $subject, $attachment) {
                            $m->from('info@karibusms.com', 'karibuSMS');
                            $m->to($email)->subject($subject);
                            $attachment == null ? '' : $m->attach($attachment);
                        });
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

}

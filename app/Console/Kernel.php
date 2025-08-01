<?php

namespace App\Console;

use App\Http\Controllers\System\CronController;
use App\Http\Controllers\System\UploadFirebaseController;
use App\Models\Reference;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $cron = new CronController();
//            $cron->send_event_certificate();
            $cron->send_qr_email();
//            $fb = new UploadFirebaseController();
//            $fb->uploadDocument();
//            $fb->uploadPostImage();
            $cron->send_abstract_email();
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

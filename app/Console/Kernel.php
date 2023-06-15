<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;
use App\Mail\Testmail;
use App\Jobs\SendReportJob;
use Carbon\Carbon;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ComplaintAutoTransfer::class,

        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->everyMinute();
        // $schedule->call(function () {
        //     Mail::to('rahul.modi@neologicx.com')->send(new Testmail());
        // })->everyMinute();

        // $now = Carbon::now();
        // $month = $now->format('F');
        // $year = $now->format('yy');

        // $fourthFridayMonthly = new Carbon('10 ' . $month . ' ' . $year);

        // $schedule->job(new SendReportJob)->weekly()->mondays()->at('13:00');
         $schedule->job(new SendReportJob)->dailyAt('13:00');	
         $schedule->command('ComplaintAutoTransfer:cron --force')->dailyAt('00:00');	

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

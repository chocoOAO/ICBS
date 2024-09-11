<?php

namespace App\Console;

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

    protected $commands = [
        \App\Console\Commands\ChickenImportRemind::class,
        \App\Console\Commands\FetchWeightData::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('commands:chickenimports-remind')->dailyAt('13:00');
        $schedule->command('fetch:weightdata')->dailyAt('13:48');
        $schedule->command('fetch:weightdata')->dailyAt('21:00');
    }
    /**
     * Register the commands for the application.
     *
     * 
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\BackupDatabase::class,
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule)
    {
        $schedule->command('backup:database')
            ->dailyAt('10:00') // Runs every day at 10 AM
            ->sendOutputTo(storage_path('logs/backup.log'));
        
        $schedule->command('backup:database')
            ->dailyAt('17:00') // Runs every day at 5 PM
            ->sendOutputTo(storage_path('logs/backup.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

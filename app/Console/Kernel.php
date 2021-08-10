<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        \Laravel\Passport\Console\InstallCommand::class,
        \Laravel\Passport\Console\KeysCommand::class,
        \Laravel\Passport\Console\ClientCommand::class,
        \Stancl\Tenancy\Commands\Install::class,
        \Stancl\Tenancy\Commands\Migrate::class,
        \Stancl\Tenancy\Commands\Seed::class,
        \Qirolab\Theme\Commands\MakeThemeCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('backup:run')->daily();
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

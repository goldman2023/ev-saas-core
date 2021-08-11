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

        // For some very weird reason some commands from few packages are not added to artisan even though there is no error in code nor in logs
        // They also seem properly resolved through package ServiceProviders, but still...they are not visible when running: php artisan list
        // Examples: php artisan octane:{start:install:stop...etc} or php artisan sail:{install, publish} are returning following error pattern:
        // "There are no commands defined in the octane/sail namespace"
        // This should work out of the box since we are using laravel 8+...I don't know what's the problem tbh
        // I'm adding these commands manually here because they are not added to artisan for whatever reason...

        // Octane
        \Laravel\Octane\Commands\InstallCommand::class,
        \Laravel\Octane\Commands\ReloadCommand::class,
        \Laravel\Octane\Commands\StartCommand::class,
        \Laravel\Octane\Commands\StartRoadRunnerCommand::class,
        \Laravel\Octane\Commands\StartSwooleCommand::class,
        \Laravel\Octane\Commands\StatusCommand::class,
        \Laravel\Octane\Commands\StopCommand::class,

        // Sail
        \Laravel\Sail\Console\InstallCommand::class,
        \Laravel\Sail\Console\PublishCommand::class,
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

<?php

namespace App\Console;

use App\Models\Config;
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
        Commands\UserCreate::class,
        Commands\DataInit::class,
        Commands\DataFix::class,
        Schedules\EnemyGenerate::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command("enemy:generate")
            ->cron('*/10 * * * * *');
    }
}

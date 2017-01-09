<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\UserCreate::class,
        Commands\DataInit::class,
        Commands\DataFix::class,
        Commands\DatabseCreate::class,

        Schedules\EnemyGenerate::class,
        Schedules\StaffGenerate::class,

        Commands\Test::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command("enemy:generate")
            ->cron('*/10 * * * * *');
    }
}

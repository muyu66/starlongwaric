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
        Commands\DatabseDrop::class,

        Schedules\EnemyGenerate::class,
        Schedules\StaffGenerate::class,
        Schedules\EventGenerate::class,
        Schedules\Commander::class,

        Commands\Test::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command("enemy:generate")
            ->cron('*/10 * * * * *');

        $schedule->command("staff:generate")
            ->cron('*/10 * * * * *');

        $schedule->command("event:generate")
            ->cron('*/1 * * * * *');

        $schedule->command("event:commander")
            ->cron('0 */2 * * * *');
    }
}

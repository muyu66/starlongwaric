<?php

namespace App\Console\Schedules;

use App\Http\Controllers\EventController;
use App\Models\Config;
use App\Models\Fleet;
use App\Models\User;
use Illuminate\Console\Command;

class EventGenerate extends Command
{
    protected $signature = 'event:generate';
    protected $description = 'generate some event';

    public function handle()
    {
        $amount = Fleet::where('alive', 1)->count();

        $ctl = new EventController();
        foreach (g_yields(rand($amount, $amount * 3)) as $i) {
            $ctl->generate();
        }
    }
}

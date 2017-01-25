<?php

namespace App\Console\Schedules;

use App\Http\Logics\FleetEventLogic;
use App\Models\Fleet;
use Illuminate\Console\Command;

class EventGenerate extends Command
{
    protected $signature = 'event:generate {amount?}';
    protected $description = 'generate some event';

    public function handle()
    {
        $amount = $this->argument('amount') ? : Fleet::alive()->count();

        $loc = new FleetEventLogic();
        foreach (g_yields(rand($amount, $amount * 2)) as $i) {
            $loc->generate();
        }
    }
}

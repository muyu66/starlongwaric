<?php

namespace App\Console\Schedules;

use App\Http\Controllers\EventController;
use App\Models\Config;
use Illuminate\Console\Command;

class EventGenerate extends Command
{
    protected $signature = 'event:generate {amount?}';
    protected $description = 'generate some event';

    public function handle()
    {
        $amount = $this->argument('amount') ? : Config::getDb('event_generate_amount');

        $ctl = new EventController();
        foreach (g_yields($amount) as $i) {
            $ctl->generate();
        }
    }
}

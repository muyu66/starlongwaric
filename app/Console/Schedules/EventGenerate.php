<?php

namespace App\Console\Schedules;

use App\Http\Controllers\EventController;
use App\Models\Fleet;
use Illuminate\Console\Command;

class EventGenerate extends Command
{
    protected $signature = 'event:generate {amount?}';
    protected $description = 'generate some event';

    public function handle()
    {
        $amount = $this->argument('amount') ? : Fleet::alive()->count();

        $ctl = new EventController();
        foreach (g_yields(rand($amount, $amount * 2)) as $i) {
            $ctl->loc()->generate();
        }
    }
}

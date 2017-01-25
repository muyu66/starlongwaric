<?php

namespace App\Console\Schedules;

use App\Http\Logics\FleetEventLogic;
use App\Models\Event;
use Illuminate\Console\Command;

class Commander extends Command
{
    protected $signature = 'event:commander';
    protected $description = 'generate some event';

    public function handle()
    {
        $models = Event::commander()->get();

        $loc = new FleetEventLogic();

        foreach ($models as $model) {
            $loc->resolve($model, $model->commander, rand(0, 1), $model->fleet_id);
        }
    }
}

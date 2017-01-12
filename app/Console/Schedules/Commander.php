<?php

namespace App\Console\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EventController;
use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class Commander extends Command
{
    protected $signature = 'event:commander';
    protected $description = 'generate some event';

    public function handle()
    {
        $models = Event::commander()->get();

        $ctl = new EventController();

        foreach ($models as $model) {
            $ctl->postResolve(new Request(), $model->id, rand(0, 1), $model->fleet_id);
        }
    }
}

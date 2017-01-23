<?php

namespace App\Console\Commands;

use App\Events\FleetCreateEvent;
use App\Events\FleetDeleteEvent;
use App\Models\Fleet;
use Illuminate\Console\Command;

class Test extends Command
{
    protected $signature = 'test';
    protected $description = 'test';

    public function handle()
    {
//        \Event::fire(new FleetCreateEvent(Fleet::create(), '肯泰罗4444', 2));
//        $a = Fleet::find(12);
//        \Event::fire(new FleetDeleteEvent($a->id));


//        $model = Event::belong(2)
//            ->where('status', 0)
//            ->with(['standard', 'staff'])
//            ->findOrFail(550);
//        $params['fleet_id'] = 2;
//
//        \Event::fire(new TaskEvent($model, 1, $params));


//        $c = new Message();
//        $c->pushMessageFunc(1, 2, 1);
//        $c->pushMessage(1, 2, 'hallp');
    }
}

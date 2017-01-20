<?php

namespace App\Console\Commands;

use App\Events\TaskEvent;
use App\Http\Components\Message;
use App\Http\Controllers\FleetController;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Artisan;
use Illuminate\Http\Request;
use Auth;

class Test extends Command
{
    protected $signature = 'test';
    protected $description = 'test';

    public function handle()
    {
        $model = Event::belong(2)
            ->where('status', 0)
            ->with(['standard', 'staff'])
            ->findOrFail(550);
        $params['fleet_id'] = 2;

        \Event::fire(new TaskEvent($model, 1, $params));


//        $c = new Message();
//        $c->pushMessageFunc(1, 2, 1);
//        $c->pushMessage(1, 2, 'hallp');
    }
}

<?php

namespace App\Console\Commands;

use App\Http\Components\Message;
use App\Http\Controllers\FleetController;
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
        $c = new Message();
        $c->pushMessageFunc(1, 2, 1);
        $c->pushMessage(1, 2, 'hallp');
    }
}

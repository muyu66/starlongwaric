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
//        $a = ['a' => '1', 'b' => '2'];
//        $a = g_array_del($a, '2');
//        dump($a);
//        $a = g_array_del($a, '2');
//
//        dump($a);
        $c = new Message();
        $c->pushMessageFunc(1, 2, 1);
//        $c->pushMessage(1, 2, 'hallp');
    }
}

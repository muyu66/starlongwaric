<?php

namespace App\Console\Commands;

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
        dump('1111');
    }
}

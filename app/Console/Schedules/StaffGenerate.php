<?php

namespace App\Console\Schedules;

use App\Http\Controllers\StaffController;
use App\Models\Config;
use Illuminate\Console\Command;

class StaffGenerate extends Command
{

    protected $signature = 'staff:generate {amount?}';
    protected $description = 'generate some staff';

    public function handle()
    {
        $amount = $this->argument('amount') ? : Config::getDb('staff_generate_amount');
        for ($i = 0; $i < $amount; $i++) {
            $ctl = new StaffController();
            $ctl->createStaff(0); // 0代表未受雇用
        }
    }
}

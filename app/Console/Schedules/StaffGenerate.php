<?php

namespace App\Console\Schedules;

use App\Http\Controllers\StaffController;
use App\Models\Fleet;
use Illuminate\Console\Command;

class StaffGenerate extends Command
{

    protected $signature = 'staff:generate {amount?}';
    protected $description = 'generate some staff';

    public function handle()
    {
        $amount = $this->argument('amount') ? : Fleet::where('alive', 1)->count();

        foreach (g_yields(rand($amount, $amount * 3)) as $i) {
            $ctl = new StaffController();
            $ctl->createStaff(0); // 0代表未受雇用
        }
    }
}

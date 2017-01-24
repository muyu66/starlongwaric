<?php

namespace App\Console\Schedules;

use App\Http\Logics\EnemyLogic;
use App\Models\Fleet;
use Faker\Factory;
use Illuminate\Console\Command;

class EnemyGenerate extends Command
{
    protected $signature = 'enemy:generate {amount?}';
    protected $description = 'generate some enemies';

    public function handle()
    {
        $faker = Factory::create('zh_CN');

        $amount = $this->argument('amount') ? : Fleet::where('alive', 1)->count();

        $loc = new EnemyLogic();

        foreach (g_yields(rand($amount, $amount * 20)) as $i) {
            $loc->create($faker->name);
        }
    }
}

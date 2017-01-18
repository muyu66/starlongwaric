<?php

namespace App\Console\Schedules;

use App\Models\Enemy;
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

        foreach (g_yields(rand($amount, $amount * 10)) as $i) {
            $model = new Enemy();
            $model->rank_id = rand(1, 10);
            $model->name = $faker->name;
            $model->staff = rand(1, 10);
            $model->union_id = 0;
            $model->planet_id = 0;
            $model->gold = rand(10, 400);
            $model->fuel = rand(10, 100);
            $model->power = rand(1000, 10000);
            $model->save();
        }
    }
}

<?php

namespace App\Console\Schedules;

use App\Models\Config;
use App\Models\Enemy;
use Faker\Factory;
use Illuminate\Console\Command;

class EnemyGenerate extends Command
{
    protected $signature = 'enemy:generate {amount?}';
    protected $description = 'generate some enemies';

    public function handle()
    {
        $faker = Factory::create('zh_CN');

        $amount = $this->argument('amount') ? : Config::getDb('enemy_generate_amount');
        for ($i = 0; $i < $amount; $i++) {
            $model = new Enemy();
            $model->rank_id = rand(1, 10);
            $model->name = $faker->name;
            $model->staff = rand(1, 10);
            $model->union_id = 0;
            $model->plenet_id = 0;
            $model->gold = rand(10, 400);
            $model->fuel = rand(10, 100);
            $model->power = rand(1000, 10000);
            $model->save();
        }
    }
}

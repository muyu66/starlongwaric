<?php

namespace App\Console\Schedules;

use App\Models\Config;
use App\Models\Staff;
use Faker\Factory;
use Illuminate\Console\Command;

class StaffGenerate extends Command
{
    protected $signature = 'staff:generate {amount?}';
    protected $description = 'generate some staff';

    public function handle()
    {
        $faker = Factory::create('en_US');

        $amount = $this->argument('amount') ? : Config::getDb('staff_generate_amount');
        for ($i = 0; $i < $amount; $i++) {
            $model = new Staff();
            $model->boss_id = 0;
            $model->is_hero = 0;
            $model->name = $faker->name;
            $model->desc = '一个普通船员';
            $model->character = rand(0, 2);
            $model->job = rand(0, 3);
            $model->job_ability = rand(20, 70);
            $model->is_commander = 0;
            $model->intelligence = rand(20, 70);
            $model->loyalty = rand(50, 90);
            $model->save();
        }
    }
}

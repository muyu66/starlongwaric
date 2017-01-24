<?php

namespace App\Http\Logics;

use App\Models\Staff;
use Faker\Factory;

class StaffLogic extends Logic
{
    /**
     *
     *
     * @param $fleet_id
     * @param int $is_commander
     * @param int $level 1-5, level 越高, 数值可能越高
     * @return Staff
     * @author Zhou Yu
     */
    public function create($fleet_id, $is_commander = 0, $level = 0)
    {
        switch ($level) {
            case 1:
                $level_name = '初级';
                break;
            case 2:
                $level_name = '中级';
                break;
            case 3:
                $level_name = '高级';
                break;
            case 4:
                $level_name = '特级';
                break;
            case 5:
                $level_name = '王者级';
                break;
            default:
                $level_name = '普通';
        }

        $faker = Factory::create('en_US');
        $level = $level ? : rand(1, 5);

        $model = new Staff();
        $model->boss_id = $fleet_id;
        $model->is_hero = 0;
        $model->name = $faker->name;
        $model->desc = "一个{$level_name}船员";
        $model->character = rand(0, 2);
        $model->job = rand(0, 3);
        $model->job_ability = $level * rand(5, 10) + rand(5, 20);
        $model->is_commander = $is_commander;
        $model->intelligence = $level * rand(5, 10) + rand(5, 20);
        $model->loyalty = $level * rand(5, 10) + rand(20, 40);
        $model->save();

        return $model;
    }
}

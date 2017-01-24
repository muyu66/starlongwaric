<?php

namespace App\Http\Logics;

use App\Models\Enemy;

class EnemyLogic extends Logic
{
    public function create($name)
    {
        $model = new Enemy();
        $model->rank_id = rand(1, 5);
        $model->name = $name;
        $model->staff = rand(1, 8);
        $model->union_id = 1;
        $model->planet_id = 1;
        $model->gold = rand(10, 500);
        $model->fuel = rand(10, 100);
        $model->power = $model->gold * 20;
        $model->save();
    }

    public function getRandoms($my_power)
    {
        /**
         * 循环搜寻匹配战斗力的敌人
         */
        $min = 0.5;
        $max = 1.5;
        $result = Enemy::whereBetween('power', [$my_power * $min, $my_power * $max])
            ->get();
        while (! count($result)) {
            $min = $min - 0.1;
            $max = $max + 0.1;
            $result = Enemy::whereBetween('power', [$my_power * $min, $my_power * $max])
                ->get();
        }

        return $result;
    }

    public function getRandom($my_power)
    {
        return $this->getRandoms($my_power)->random();
    }
}

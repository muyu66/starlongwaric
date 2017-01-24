<?php

namespace App\Http\Logics;

use App\Models\Enemy;

class EnemyLogic extends Logic
{
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

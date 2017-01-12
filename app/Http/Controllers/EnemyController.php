<?php

namespace App\Http\Controllers;

use App\Models\Enemy;

class EnemyController extends Controller
{
    public function index()
    {
        return Enemy::get();
    }

    public function show($id)
    {
        return Enemy::where('id', $id)->first();
    }

    public function randoms($my_power)
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

    public function random($my_power)
    {
        return $this->randoms($my_power)->random();
    }
}

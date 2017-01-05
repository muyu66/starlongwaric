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

    public function getRandoms()
    {
        $ctl = new FleetController();
        $my = $ctl->show($this->getFleetId());

        /**
         * 循环搜寻匹配战斗力的敌人
         */
        $min = 0.5;
        $max = 1.5;
        $result = Enemy::whereBetween('power', [$my->power * $min, $my->power * $max])
            ->get();
        while (! count($result)) {
            $min = $min - 0.1;
            $max = $max + 0.1;
            $result = Enemy::whereBetween('power', [$my->power * $min, $my->power * $max])
                ->get();
        }

        return $result;
    }

    public function getRandom()
    {
        return $this->getRandoms()->random();
    }
}

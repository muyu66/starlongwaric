<?php

namespace App\Http\Controllers;

use App\Models\Enemy;

class FightController extends Controller
{
    private function randomEnemy($power)
    {
        return Enemy::whereBetween('power', [$power * 0.5, $power * 1.5])
            ->get()
            ->random();
    }

    public function postEnemy($enemy_id)
    {

    }

    private function booty()
    {

    }

    private function calc()
    {

    }
}

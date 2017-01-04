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
        return Enemy::where('id', $id)->get();
    }

    public function getRandom($fleet_id)
    {
        $ctl = new FleetController();
        $my = $ctl->show($fleet_id);
        return Enemy::whereBetween('power', [$my->power * 0.5, $my->power * 1.5])
            ->get()
            ->random();
    }
}

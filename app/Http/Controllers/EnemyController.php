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
}

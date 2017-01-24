<?php

namespace App\Http\Controllers;

use App\Models\Enemy;
use Illuminate\Http\Request;

class EnemyController extends Controller implements RestFulInterface
{
    public function index()
    {
        return Enemy::get();
    }

    public function show($id)
    {
        return Enemy::findOrFail($id);
    }

    public function store(Request $request)
    {

    }
}

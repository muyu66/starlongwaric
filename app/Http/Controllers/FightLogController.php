<?php

namespace App\Http\Controllers;

use App\Models\FightLog;
use Illuminate\Http\Request;

class FightLogController extends Controller
{
    public function index()
    {
        return FightLog::get();
    }

    public function show($id)
    {
        return FightLog::where('id', $id)->get();
    }

    public function record($my, $enemy, $result, Array $booty)
    {
        $model = new FightLog();
        $model->my_id = $my->id;
        $model->enemy_id = $enemy->id;
        $model->my_power = $my->power;
        $model->enemy_power = $enemy->power;
        $model->result = $result;
        $model->booty = $booty;
        $model->save();
    }
}

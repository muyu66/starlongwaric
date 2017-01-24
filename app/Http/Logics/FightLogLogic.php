<?php

namespace App\Http\Logics;

use App\Models\FightLog;

class FightLogLogic extends Logic
{
    public function create($my, $enemy, $result, Array $booty)
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

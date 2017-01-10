<?php

namespace App\Http\Controllers;

use App\Models\FightLog;

class FightLogController extends Controller
{
    /**
     * 查看玩家所有攻击的记录
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @author Zhou Yu
     */
    public function index()
    {
        return FightLog::where('my_id', $this->getFleetId())
            ->orWhere('enemy_id', $this->getFleetId())
            ->with('enemy')
            ->get();
    }

    /**
     * 查看 主动攻击 或 被动攻击 的记录
     *
     * @param string $my_or_enemy
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @author Zhou Yu
     */
    public function show($my_or_enemy = 'my')
    {
        if ($my_or_enemy == 'my') {
            return FightLog::where('my_id', $this->getFleetId())
                ->with('enemy')
                ->get();
        } else {
            return FightLog::where('enemy_id', $this->getFleetId())
                ->with('enemy')
                ->get();
        }
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

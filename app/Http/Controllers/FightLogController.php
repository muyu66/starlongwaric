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
            ->orderBy('updated_at', 'desc')
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
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            return FightLog::where('enemy_id', $this->getFleetId())
                ->with('enemy')
                ->orderBy('updated_at', 'desc')
                ->get();
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Enemy;
use App\Models\Fleet;

class FightController extends Controller
{
    /**
     * @description 战斗主函数
     * @param $fleet_id
     * @return int [-1失败,0平局,1战胜]
     * @author Zhou Yu
     */
    public function postEnemy($fleet_id)
    {
        $ctl = new FleetController();
        $ctl_enemy = new EnemyController();

        // 得到我的数据
        $my = $ctl->show($fleet_id);
        // 得到敌人数据
        $enemy = $ctl_enemy->getRandom($fleet_id);
        // 得到战斗结果
        $result_int = $this->calc($my, $enemy);
        // 得到战利品数据
        $booty = $this->booty($result_int, $my, $enemy);
        // 汇总记录数据
        $this->log($my, $enemy, $result_int, $booty);
        return $result_int;
    }

    private function log($my, $enemy, $result_int, $booty)
    {
        $model = new FightLogController();
        $model->record($my, $enemy, $result_int, $booty);
    }

    /**
     * @description 处理战利品
     * @param $result
     * @param Fleet $my
     * @param Enemy $enemy
     * @return string
     * @author Zhou Yu
     */
    private function booty($result, Fleet $my, Enemy $enemy)
    {
        $algorithm = function ($win, $lost) {
            $gold = $lost->gold * 0.2;
            $fuel = $lost->fuel * 0.2;
            $lost->gold = $lost->gold - $gold;
            $lost->fuel = $lost->fuel - $fuel;
            $lost->save();
            $win->gold = $win->gold + $gold;
            $win->fuel = $win->fuel + $fuel;
            $win->save();
            return ['gold' => $gold, 'fuel' => $fuel];
        };

        switch ($result) {
            case -1:
                return $algorithm($my, $enemy);
            case 0:
                return ['gold' => 0, 'fuel' => 0];
            case 1:
                return $algorithm($enemy, $my);
        }
    }

    /**
     * @description 战斗力比较
     * @param $my
     * @param $enemy
     * @return int
     * @author Zhou Yu
     */
    private function calc($my, $enemy)
    {
        return $my->power <=> $enemy->power;
    }
}

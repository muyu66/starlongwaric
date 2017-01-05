<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Exception;

class FightController extends Controller
{
    /**
     * @description 战斗主函数
     * @author Zhou Yu
     */
    public function postEnemy()
    {
        $my = new FleetController();
        $enemy = new EnemyController();

        // 得到我的数据
        $my = $my->show($this->getFleetId());

        // 得到敌人数据，随机遇敌
        $enemy = $enemy->getRandom();

        // 得到战斗结果
        $result_int = $this->calc($my, $enemy);

        // 得到战利品数据
        $booty = $this->booty($result_int, $my, $enemy);

        // 汇总记录数据
        $ctl = new FightLogController();
        $ctl->record($my, $enemy, $result_int, $booty);
    }

    /**
     * 处理战利品
     *
     * @param int $result 战斗结果
     * @param Model $my
     * @param Model $enemy
     * @return array|mixed
     * @throws Exception
     * @author Zhou Yu
     */
    public function booty(int $result, Model $my, Model $enemy)
    {
        /**
         * @description 作为其后的算法闭包
         * @param Model $win
         * @param Model $lost
         * @return array
         * @author Zhou Yu
         */
        $algorithm = function (Model $win, Model $lost) {

            // TODO Model 会 穿透 闭包

            $gold = round($lost->gold * 0.2);
            $fuel = round($lost->fuel * 0.2);
            $lost->gold = $lost->gold - $gold;
            $lost->fuel = $lost->fuel - $fuel;
            $win->gold = $win->gold + $gold;
            $win->fuel = $win->fuel + $fuel;
            $lost->save();
            $win->save();
            return ['gold' => $gold, 'fuel' => $fuel];
        };

        switch ($result) {
            case -1:
                return $algorithm($enemy, $my);
            case 0:
                return ['gold' => 0, 'fuel' => 0];
            case 1:
                return $algorithm($my, $enemy);
            default:
                throw new Exception('战斗结果异常');
        }
    }

    /**
     * 战斗力比较
     *
     * @param Model $my
     * @param Model $enemy
     * @return int
     * @author Zhou Yu
     */
    public function calc(Model $my, Model $enemy)
    {
        return $my->power <=> $enemy->power;
    }
}

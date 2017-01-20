<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Exception;

class FightController extends Controller
{
    /**
     * 战斗主函数
     *
     * @param Model $my
     * @author Zhou Yu
     */
    public function fight(Model $my)
    {
        // 得到敌人数据，随机遇敌
        $enemy = new EnemyController();
        $enemy = $enemy->random($my->power);

        // 得到战斗结果
        $result_int = $this->calc($my, $enemy);

        // 战斗损失, 维修值扣除
        $this->calcBody($result_int, $my->id);

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

    public function calcBody($result_int, $my_id)
    {
        $ctl = new FleetBodyController();
        $bodies = $ctl->index($my_id);

        switch ($result_int) {
            case -1:
                foreach ($bodies as $body) {
                    $ctl->randomDamage($body, rand(4, 8));
                }
                break;
            case 0:
                foreach ($bodies as $body) {
                    $ctl->randomDamage($body, rand(2, 4));
                }
                break;
            case 1:
                foreach ($bodies as $body) {
                    $ctl->randomDamage($body, rand(0, 2));
                }
                break;
            default:
                throw new Exception('战斗结果异常');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Events\FleetDeleteEvent;
use App\Models\Enemy;
use App\Models\Fleet;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Event;

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
        $enemy = $enemy->loc()->getRandom($my->power);

        // 得到战斗结果
        $result_int = $this->calc($my, $enemy);

        // 战斗损失, 维修值扣除
        $this->calcBody($result_int, $my->id);

        // 如果战斗胜利, 则增加战功
        $this->calcContribution($result_int, $my->id, $enemy->id);

        // 得到战利品数据
        $booty = $this->booty($result_int, $my, $enemy);

        // 汇总记录数据
        $ctl = new FightLogController();
        $ctl->loc()->create($my, $enemy, $result_int, $booty);

        // 检查维修值, 如果都为0, 则舰队报废
        $this->checkAlive($my->id);
    }

    public function checkAlive($my_id)
    {
        $ctl = new FleetBodyController();
        $bodies = $ctl->loc()->index($my_id);

        /**
         * 如果维修值有一项不为0, 则不算阵亡
         */
        foreach ($bodies as $body) {
            if ($body->health > 0) {
                return true;
            }
        }
        Event::fire(new FleetDeleteEvent($my_id));
        return true;
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
        $bodies = $ctl->loc()->index($my_id);

        switch ($result_int) {
            case -1:
                foreach ($bodies as $body) {
                    $ctl->loc()->randomDamage($body, rand(4, 8));
                }
                break;
            case 0:
                foreach ($bodies as $body) {
                    $ctl->loc()->randomDamage($body, rand(2, 4));
                }
                break;
            case 1:
                foreach ($bodies as $body) {
                    $ctl->loc()->randomDamage($body, rand(0, 2));
                }
                break;
            default:
                throw new Exception('战斗结果异常');
        }
    }

    /**
     * 战胜敌人, 则获取敌人全部的战勋
     *
     * @param $result_int
     * @param $my_id
     * @param $enemy_id
     */
    public function calcContribution($result_int, $my_id, $enemy_id)
    {
        switch ($result_int) {
            case 1:
                $my = Fleet::findOrFail($my_id);
                $enemy = Enemy::findOrFail($enemy_id);
                $my->contribution += $enemy->contribution ? : 1;
                $my->save();
                break;
        }
    }
}

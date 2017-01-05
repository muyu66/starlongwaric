<?php

namespace App\Http\Controllers;

use App\Models\Enemy;
use App\Models\Fleet;
use Illuminate\Database\Eloquent\Model;
use Exception;

class FightController extends Controller
{
    /**
     * @description 战斗主函数
     * @param $fleet_id
     * @return int [-1失败,0平局,1战胜]
     * @author Zhou Yu
     */
    /**
     * @description
     * @return int
     * @author Zhou Yu
     */
    public function postEnemy()
    {
        $my = new FleetController();
        $enemy = new EnemyController();

        // 得到我的数据
        $my = $my->show();

        // 得到敌人数据，随机遇敌
        $enemy = $enemy->getRandom();

        // 得到战斗结果
        $result_int = $this->calc($my, $enemy);

        // 得到战利品数据
        $booty = $this->booty($result_int, $my, $enemy);

        // 汇总记录数据
        $this->log($my, $enemy, $result_int, $booty);

        return $result_int;
    }

    public function log(Fleet $my, Enemy $enemy, $result_int, $booty)
    {
        $model = new FightLogController();
        $model->record($my, $enemy, $result_int, $booty);
    }

    /**
     * @description 处理战利品
     * @param int $result 战斗结果
     * @param Fleet $my
     * @param Enemy $enemy
     * @return string
     * @author Zhou Yu
     */
    /**
     * @description
     * @param $result
     * @param Fleet $my
     * @param Enemy $enemy
     * @return array|mixed
     * @throws Exception
     * @author Zhou Yu
     */
    public function booty($result, Fleet $my, Enemy $enemy)
    {
        /**
         * 战斗力不会保存到数据库里
         */
        unset($my->power);

        /**
         * @description 作为其后的算法闭包
         * @param Model $win
         * @param Model $lost
         * @return array
         * @author Zhou Yu
         */
        $algorithm = function (Model $win, Model $lost) {
            $gold = $lost->gold * 0.2;
            $fuel = $lost->fuel * 0.2;
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
     * @description 战斗力比较
     * @param $my
     * @param $enemy
     * @return int
     * @author Zhou Yu
     */
    private function calc(Fleet $my, Enemy $enemy)
    {
        return $my->power <=> $enemy->power;
    }
}

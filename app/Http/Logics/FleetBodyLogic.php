<?php

namespace App\Http\Logics;

use App\Models\FleetBody;

class FleetBodyLogic extends Logic
{
    /**
     * @description 单件修复算法
     * @param $fleet_body
     * @param $fleet
     * @param $fleet_body_widget
     * @param $amount
     * @param $gold_is_empty
     * @author Zhou Yu
     */
    public function fix(&$fleet_body, &$fleet, $fleet_body_widget, &$amount, &$gold_is_empty)
    {
        foreach (g_yields(100 - $fleet_body->health) as $i) {
            if ($fleet->gold <= $fleet_body_widget->per_fee) {
                $gold_is_empty = 1;
                continue 1;
            }
            $fleet->gold -= $fleet_body_widget->per_fee;
            $fleet_body->health += 1;
            $amount++;
        }
    }

    /**
     * 根据级别, 随机减少维修值
     *
     * @param FleetBody $model
     * @param $value
     */
    public function randomDamage(FleetBody $model, $value)
    {
        $model->health = $model->health - $value >= 0 ? $model->health - $value : 0;
        $model->save();
    }
}

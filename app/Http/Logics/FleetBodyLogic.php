<?php

namespace App\Http\Logics;

use App\Models\Fleet;
use App\Models\FleetBody;
use App\Models\FleetBodyWidget;

class FleetBodyLogic extends Logic
{
    public function index($fleet_id)
    {
        return FleetBody::belong($fleet_id)->with('widget')->get();
    }

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

    public function createCopy($fleet_id)
    {
        $copies = FleetBodyWidget::get();
        foreach ($copies as $copy) {
            $body = new FleetBody();
            $body->fleet_id = $fleet_id;
            $body->widget_id = $copy->id;
            $body->health = 100;
            $body->save();
        }
    }

    public function store(Fleet $fleet, $ids)
    {
        if (is_string($ids)) {
            $ids = [$ids];
        }

        $results = [];

        foreach ($ids as $id) {
            $fleet_body = FleetBody::belong($fleet->id)->findOrFail($id);

            // 获取源数据
            $fleet_body_widget = FleetBodyWidget::where('id', $fleet_body->widget_id)->firstOrFail();

            if ($fleet_body->health == 100) {
                $results[] = ['id' => $id, 'fix' => 0, 'gold' => 0];
            } else {
                // 维修过的健康度数量
                $amount = 0;

                // 标记 - 玩家是否资金耗尽
                $gold_is_empty = 0;

                /**
                 * 动态更改了以下的变量
                 * $fleet_body, $fleet, $amount, $gold_is_empty
                 */
                $this->fix($fleet_body, $fleet, $fleet_body_widget, $amount, $gold_is_empty);

                $fleet->save();

                $fleet_body->save();

                $results[] = [
                    'id' => $id, 'fix' => $amount,
                    'gold' => $amount * $fleet_body_widget->per_fee,
                    'gold_is_empty' => $gold_is_empty,
                ];
            }
        }
        return $results;
    }
}

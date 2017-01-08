<?php

namespace App\Http\Controllers;

use App\Models\FleetBody;
use App\Models\FleetBodyWidget;
use Illuminate\Http\Request;

class FleetBodyController extends Controller
{
    public function index()
    {
        return FleetBody::belong($this->getFleetId())->with('widget')->get();
    }

    /**
     * waiting
     *
     * @param $id
     * @return mixed
     * @author Zhou Yu
     */
    public function show($id)
    {
        return FleetBody::belong($this->getFleetId())->where('id', $id)->firstOrFail();
    }

    /**
     * @description 单件修复
     * @param Request $request
     * @param null $id
     * @return array
     * @author Zhou Yu
     */
    public function store(Request $request, $id = null)
    {
        // 组件 ID
        $fleet_body_id = $request->input('id') ? : $id;

        // 获取现数据
        $fleet_body = $this->show($fleet_body_id);

        // 获取源数据
        $fleet_body_widget = FleetBodyWidget::where('id', $fleet_body->widget_id)->firstOrFail();

        $fleet = $this->getFleet();

        if ($fleet_body->health == 100) {
            return ['id' => $fleet_body_id, 'fix' => 0, 'gold' => 0];
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

            return [
                'id' => $fleet_body_id, 'fix' => $amount,
                'gold' => $amount * $fleet_body_widget->per_fee,
                'gold_is_empty' => $gold_is_empty,
            ];
        }
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
     * 全部修复
     *
     * @return array
     * @author Zhou Yu
     */
    public function postAll()
    {
        $result = [];
        $models = FleetBody::belong($this->getFleetId())->get();
        foreach ($models as $model) {
            $result[] = $this->store(new Request(), $model->id);
        }
        return $result;
    }
}
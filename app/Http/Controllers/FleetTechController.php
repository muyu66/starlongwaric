<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\FleetTech;
use App\Models\FleetTechTech;
use Illuminate\Http\Request;

class FleetTechController extends Controller
{
    public function index()
    {
        return FleetTech::belong($this->getFleetId())->get();
    }

    /**
     *
     *
     * @param $id
     * @return mixed
     * @author Zhou Yu
     */
    public function show($id)
    {
        return FleetTech::belong($this->getFleetId())->where('id', $id)->firstOrFail();
    }

    /**
     * @description 单件升级
     * @param Request $request
     * @param null $id
     * @param int $num
     * @return array
     * @author Zhou Yu
     */
    public function store(Request $request, $id = null, $num = 1)
    {
        $fleet_tech_id = $request->input('id') ? : $id;
        $num = $request->input('num') ? : $num;

        // 获取现数据
        $fleet_tech = $this->show($fleet_tech_id);

        // 获取源数据
        $fleet_tech_tech = FleetTechTech::where('id', $fleet_tech->tech_id)->firstOrFail();

        $fleet = $this->getFleet();

        if ($fleet_tech->level == Config::getDb('tech_limit')) {
            return ['id' => $fleet_tech_id, 'update' => 0, 'gold' => 0];
        } else {
            // 维修过的健康度数量
            $amount = 0;

            // 标记 - 玩家是否资金耗尽
            $gold_is_empty = 0;

            // 标记 - 科技等级是否达到上限
            $level_is_max = 0;

            $this->update(
                $fleet_tech, $fleet, $fleet_tech_tech, $amount,
                $gold_is_empty, $level_is_max, $num
            );

            $fleet->save();

            $fleet_tech->save();

            return [
                'id' => $fleet_tech_id, 'update' => $amount,
                'gold' => $amount * $fleet_tech_tech->per_fee,
                'gold_is_empty' => $gold_is_empty,
                'level_is_max' => $level_is_max,
            ];
        }
    }

    /**
     * 单件升级算法
     *
     * @param $fleet_tech
     * @param $fleet
     * @param $fleet_tech_tech
     * @param $amount
     * @param $gold_is_empty
     * @param $level_is_max
     * @param $num
     * @author Zhou Yu
     */
    public function update(&$fleet_tech, &$fleet, $fleet_tech_tech, &$amount,
                           &$gold_is_empty, &$level_is_max, $num)
    {
        foreach (g_yields($num) as $i) {
            if ($fleet->gold <= $fleet_tech_tech->per_fee) {
                $gold_is_empty = 1;
                continue 1;
            }
            if ($fleet_tech->level >= Config::getDb('tech_limit')) {
                $level_is_max = 1;
                continue 1;
            }
            $fleet->gold -= $fleet_tech_tech->per_fee;
            $fleet_tech->level += 1;
            $amount++;
        }
    }

    /**
     * 全部升级
     *
     * @param Request $request
     * @return array
     * @author Zhou Yu
     */
    public function postAll(Request $request)
    {
        $num = $request->input('num');
        $result = [];
        $models = FleetTech::self($this->getFleetId())->get();
        foreach ($models as $model) {
            $result[] = $this->store(new Request(), $model->id, $num);
        }
        return $result;
    }
}
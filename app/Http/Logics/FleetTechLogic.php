<?php

namespace App\Http\Logics;

use App\Models\Config;
use App\Models\Fleet;
use App\Models\FleetTech;
use App\Models\FleetTechTech;

class FleetTechLogic extends Logic
{
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

    public function createCopy($fleet_id)
    {
        $copies = FleetTechTech::get();
        foreach ($copies as $copy) {
            $body = new FleetTech();
            $body->fleet_id = $fleet_id;
            $body->tech_id = $copy->id;
            $body->level = 0;
            $body->save();
        }
    }

    public function store(Fleet $fleet, $ids, $num = 1)
    {
        if (is_string($ids)) {
            $ids = [$ids];
        }

        $results = [];

        foreach ($ids as $id) {
            // 获取现数据
            $fleet_tech = FleetTech::belong($fleet->id)->findOrFail($id);

            // 获取源数据
            $fleet_tech_tech = FleetTechTech::where('id', $fleet_tech->tech_id)->firstOrFail();

            if ($fleet_tech->level == Config::getDb('tech_limit')) {
                $results[] = ['id' => $id, 'update' => 0, 'gold' => 0];
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

                $results[] = [
                    'id' => $id, 'update' => $amount,
                    'gold' => $amount * $fleet_tech_tech->per_fee,
                    'gold_is_empty' => $gold_is_empty,
                    'level_is_max' => $level_is_max,
                ];
            }
        }
        return $results;
    }
}

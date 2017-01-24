<?php

namespace App\Http\Logics;

use App\Models\Config;

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
}

<?php

namespace App\Http\Logics;

use App\Models\FleetBody;
use App\Models\FleetTech;

class FleetPowerLogic extends Logic
{
    public function power($fleet_id)
    {
        return array_sum([
            $this->calc(
                FleetBody::getWith(FleetBody::STANDARD, $fleet_id), FleetBody::class
            ),
            $this->calc(
                FleetTech::getWith(FleetTech::STANDARD, $fleet_id), FleetTech::class
            ),
        ]);
    }

    /**
     * @description 计算战斗力
     * @param $models
     * @param $class FleetBody|FleetTech
     * @return int
     * @author Zhou Yu
     */
    private function calc($models, $class)
    {
        $num = $class::POWER_NUM;
        $item = $class::POWER_ITEM;
        $per = $class::POWER_PER;

        $power = 0;
        foreach ($models as $model) {
            $power += $model->$num * $model->$item->$per;
        }
        return $power;
    }
}

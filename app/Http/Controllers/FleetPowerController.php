<?php

namespace App\Http\Controllers;

use App\Models\FleetBody;
use App\Models\FleetTech;

class FleetPowerController extends Controller
{
    public function power()
    {
        return array_sum([
            $this->calc(FleetBody::getWith('widget', $this->getFleetId()), FleetBody::class),
            $this->calc(FleetTech::getWith('tech', $this->getFleetId()), FleetTech::class),
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
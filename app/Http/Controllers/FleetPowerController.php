<?php

namespace App\Http\Controllers;

use App\Models\FleetBody;
use App\Models\FleetTech;

class FleetPowerController extends Controller
{
    public function power($fleet_id)
    {
        return array_sum([
            $this->calc(FleetBody::getWith('widget', $fleet_id), FleetBody::class),
            $this->calc(FleetTech::getWith('tech', $fleet_id), FleetTech::class),
        ]);
    }

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
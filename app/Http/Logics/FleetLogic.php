<?php

namespace App\Http\Logics;

use App\Http\Controllers\FleetPowerController;
use App\Models\Fleet;

class FleetLogic extends Logic
{
    public function updateFleetPower(Fleet $fleet)
    {
        $power = new FleetPowerController();
        $fleet->power = $power->power();
        $fleet->save();
        return $fleet;
    }
}

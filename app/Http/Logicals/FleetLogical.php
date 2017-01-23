<?php

namespace App\Http\Logicals;

use App\Http\Controllers\FleetPowerController;
use App\Models\Fleet;

class FleetLogical extends Logical
{
    public function updateFleetPower(Fleet $fleet)
    {
        $power = new FleetPowerController();
        $fleet->power = $power->power();
        $fleet->save();
        return $fleet;
    }
}

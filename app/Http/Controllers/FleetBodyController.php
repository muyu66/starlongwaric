<?php

namespace App\Http\Controllers;

use App\Models\FleetBody;

class FleetBodyController extends Controller
{
    public function getBody($fleet_id)
    {
        return FleetBody::where('fleet_id', $fleet_id)->get();
    }

    public function postFixBody($widget_id)
    {

    }
}
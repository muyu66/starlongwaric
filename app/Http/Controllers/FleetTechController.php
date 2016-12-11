<?php

namespace App\Http\Controllers;

use App\Models\FleetTech;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FleetTechController extends Controller
{
    public function getTech($fleet_id)
    {
        return FleetTech::where('fleet_id', $fleet_id)->get();
    }

    /**
     * @description 提升科技等级
     * @param $tech_id
     * @author Zhou Yu
     */
    public function postUpTech($tech_id)
    {

    }
}
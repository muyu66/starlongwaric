<?php

namespace App\Http\Controllers;

use App\Models\FleetTech;
use Illuminate\Http\Request;

class FleetTechController extends Controller
{
    public function index($fleet_id)
    {
        return FleetTech::belong($fleet_id)->with('tech')->get();
    }

    public function show($fleet_id, $id)
    {
        return FleetTech::belong($fleet_id)->findOrFail($id);
    }

    public function store(Request $request)
    {
        $ids = $request->input('id');
        $num = $request->input('num');
        $this->storeAll($ids, FleetTech::class);

        $this->loc()->store($this->getFleet(), $ids, $num);
    }
}
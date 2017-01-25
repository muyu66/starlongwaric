<?php

namespace App\Http\Controllers;

use App\Models\FleetBody;
use Illuminate\Http\Request;

class FleetBodyController extends Controller implements RestFulChildInterface
{
    public function index($fleet_id)
    {
        return FleetBody::belong($fleet_id)->with('widget')->get();
    }

    public function show($fleet_id, $id)
    {
        return FleetBody::belong($fleet_id)->findOrFail($id);
    }

    public function store(Request $request)
    {
        // 组件 ID
        $ids = $request->input('id');
        $this->storeAll($ids, FleetBody::class);

        $this->loc()->store($this->getFleet(), $ids);
    }
}

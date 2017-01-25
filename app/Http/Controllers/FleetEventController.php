<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class FleetEventController extends Controller implements RestFulChildInterface
{
    public function index($fleet_id)
    {
        $this->showMe($fleet_id);

        return Event::belong($fleet_id)
            ->with(['standard', 'staff'])
            ->orderByRaw('`status` asc, `updated_at` desc')
            ->paginate(g_get_paginate_count());
    }

    public function show($fleet_id, $status)
    {
        $this->showMe($fleet_id);

        return Event::belong($fleet_id)
            ->where('status', $status)
            ->with(['standard', 'staff'])
            ->orderByRaw('`status` asc, `updated_at` desc')
            ->paginate(g_get_paginate_count());
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        $choose = $request->input('choose');

        $model = Event::belong($this->getFleetId())
            ->where('status', 0)
            ->where('id', $id)
            ->with(['standard', 'staff'])
            ->firstOrFail();

        $this->loc()->resolve($model, 0, $choose, $this->getFleetId());
    }
}

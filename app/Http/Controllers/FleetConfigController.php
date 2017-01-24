<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\FleetConfig;
use Illuminate\Http\Request;

class FleetConfigController extends Controller
{
    public function index()
    {
        return FleetConfig::belong($this->getFleetId())->first();
    }

    public function show($key)
    {
        $model = $this->index();
        $configs = $model->configs;
        foreach ($configs as $k => $v) {
            if ($k === $key) {
                return [$k => $v];
            }
        }
        throw new ApiException(40402);
    }

    public function postCommanderStyle(Request $request)
    {
        $this->loc()->check($request->all());

        $style = $request->input('style');

        $model = FleetConfig::firstOrNew([
            'fleet_id' => $this->getFleetId(),
        ]);

        $configs = $model->configs;
        $model->configs = g_add_or_update($configs, 'commander_style', $style);
        $model->save();

        return $model;
    }
}

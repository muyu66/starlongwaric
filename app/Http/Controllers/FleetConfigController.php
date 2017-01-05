<?php

namespace App\Http\Controllers;

use App\Models\FleetConfig;
use Illuminate\Http\Request;
use Exception;

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
        throw new Exception('this config is not found', 404);
    }

    public function postPlayTime(Request $request)
    {
        $minute = $request->input('minute') ? : 60;

        $model = FleetConfig::firstOrNew([
            'fleet_id' => $this->getFleetId(),
        ]);

        $configs = $model->configs;
        $model->configs = g_add_or_update($configs, 'play_time', $minute);
        $model->save();

        return $model;
    }
}

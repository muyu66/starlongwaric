<?php

namespace App\Http\Controllers;

use App\Models\FleetConfig;
use Illuminate\Http\Request;

class FleetConfigController extends Controller
{
    public function index()
    {
        return FleetConfig::self($this->fleet_id)->first();
    }

    public function show($key)
    {
        $model = FleetConfig::self($this->fleet_id)->first();
        foreach ($model->configs as $config) {
            return [$key => $config[$key]];
        }
    }

    public function postUpdatePlayTime(Request $request)
    {
        $minute = $request->input('minute') ? : 60;
        if (!$this->fleet_id) {
            // 请求参数错误
            abort(400);
        }
        $model = FleetConfig::firstOrNew([
            'fleet_id' => $this->fleet_id,
        ]);
        $configs = $model->configs;
        if (!$configs) {
            $configs[] = ['play_time' => $minute];
        } else {
            foreach ($configs as &$config) {
                $config['play_time'] = $minute;
            }
        }
        $model->configs = $configs;
        $model->save();
    }
}
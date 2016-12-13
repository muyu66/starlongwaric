<?php

namespace App\Console\Commands;

use App\Http\Controllers\AuthController;
use App\Models\Config;
use App\Models\FleetBodyWidget;
use App\Models\FleetTechTech;
use Illuminate\Console\Command;

class DataInit extends Command
{
    protected $signature = 'data:init {widget?}';
    protected $description = 'init some data';

    public function handle()
    {
        $widget = $this->argument('widget') ? : 'all';
        $this->$widget();
    }

    private function all()
    {
        $this->config();

        $this->fleetBodyWidget();
        $this->fleetTechTech();
    }

    private function config()
    {
        $model = Config::firstOrNew([
            'key' => 'enemy_generate_amount',
        ]);
        $model->value = g_loadData('enemy_generate_amount');
        $model->save();
    }

    private function fleetBodyWidget()
    {
        foreach (g_loadData(__FUNCTION__) as $item) {
            $model = FleetBodyWidget::firstOrNew([
                'name' => $item['name'],
            ]);
            $model->desc = $item['desc'];
            $model->per_fee = $item['per_fee'];
            $model->per_power = $item['per_power'];
            $model->save();
        }
    }

    private function fleetTechTech()
    {
        foreach (g_loadData(__FUNCTION__) as $item) {
            $model = FleetTechTech::firstOrNew([
                'name' => $item['name'],
            ]);
            $model->desc = $item['desc'];
            $model->per_fee = $item['per_fee'];
            $model->per_power = $item['per_power'];
            $model->save();
        }
    }

    public function __call($func, $args)
    {
        $this->all();
    }
}

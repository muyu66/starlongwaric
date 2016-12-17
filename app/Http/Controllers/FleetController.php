<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use App\Models\FleetBody;
use App\Models\FleetBodyWidget;
use App\Models\FleetTech;
use App\Models\FleetTechTech;
use Illuminate\Http\Request;
use Validator;
use Exception;

class FleetController extends Controller
{
    public function index()
    {
        $power = new FleetPowerController();

        $models = Fleet::getByUserId($this->user_id);
        foreach ($models as $model) {
            $model->power = $power->power($model->id);
        }
        return $models;
    }

    public function show($fleet_id)
    {
        $power = new FleetPowerController();

        $model = Fleet::findOrFailByUserId($fleet_id, $this->user_id);
        $model->power = $power->power($model->id);
        return $model->first();
    }

    public function store(Request $request)
    {
        $name = $request->input('name');

        $this->valid($request);

        $fleet = $this->createFleet($name);
        $this->createFleetBody($fleet->id);
        $this->createFleetTech($fleet->id);
    }

    private function valid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }
    }

    private function createFleet($name)
    {
        $fleet = new Fleet();
        $fleet->user_id = $this->user_id;
        $fleet->rank_id = 0;
        $fleet->name = $name;
        $fleet->staff = 2;
        $fleet->union_id = 0;
        $fleet->plenet_id = 0;
        $fleet->gold = 100;
        $fleet->fuel = 10;
        $fleet->save();
        return $fleet;
    }

    public function createFleetBody($fleet_id)
    {
        $copies = FleetBodyWidget::get();
        foreach ($copies as $copy) {
            $body = new FleetBody();
            $body->fleet_id = $fleet_id;
            $body->widget_id = $copy->id;
            $body->health = 100;
            $body->save();
        }
    }

    public function createFleetTech($fleet_id)
    {
        $copies = FleetTechTech::get();
        foreach ($copies as $copy) {
            $body = new FleetTech();
            $body->fleet_id = $fleet_id;
            $body->tech_id = $copy->id;
            $body->level = 0;
            $body->save();
        }
    }
}
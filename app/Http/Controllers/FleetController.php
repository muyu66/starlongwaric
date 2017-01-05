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
    /**
     * @description
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @author Zhou Yu
     */
    public function index()
    {
        $power = new FleetPowerController();

        $models = Fleet::getByUserId($this->getUserId());
        foreach ($models as $model) {
            $model->power = $power->power();
        }
        return $models;
    }

    /**
     * @description
     * @return Fleet
     * @author Zhou Yu
     */
    public function show()
    {
        $model = Fleet::where('user_id', $this->getUserId())->first();

        /**
         * 附加 战斗力
         */
        $power = new FleetPowerController();
        $model->power = $power->power();

        return $model;
    }

    public function store(Request $request, $name = null)
    {
        $name = $request->input('name') ? : $name;

        $this->valid($request->all() ? : ['name' => $name]);

        $fleet = $this->createFleet($name);
        $this->createFleetBody($fleet->id);
        $this->createFleetTech($fleet->id);
    }

    private function valid($array)
    {
        $validator = Validator::make($array, [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }
    }

    private function createFleet($name)
    {
        $fleet = new Fleet();
        $fleet->user_id = $this->getUserId();
        $fleet->rank_id = 0;
        $fleet->name = $name;
        $fleet->staff = 2;
        $fleet->union_id = 0;
        $fleet->plenet_id = 0;
        $fleet->gold = 100;
        $fleet->fuel = 10;
        $fleet->alive = 1;
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
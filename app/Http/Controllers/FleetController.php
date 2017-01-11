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
     * 返回所有(包括阵亡)的舰队
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @author Zhou Yu
     */
    public function index()
    {
        return Fleet::where('user_id', $this->getUserId())->get();
    }

    /**
     * 仅返回当前存活的舰队
     *
     * @return Fleet
     * @author Zhou Yu
     */
    public function show()
    {
        return Fleet::alive()->where('user_id', $this->getUserId())->first();
    }

    public function valid(Array $array)
    {
        $validator = Validator::make($array, [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages(), 422);
        }
    }

    public function store(Request $request, $name = null)
    {
        $name = $request->input('name') ? : $name;

        $this->valid(['name' => $name]);

        $fleet = $this->createFleet($name);
        $this->createFleetBody($fleet->id);
        $this->createFleetTech($fleet->id);
        $this->createFleetPower($fleet);
        $this->createFleetStaff($fleet->id);
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
        $fleet->power = 0;
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

    /**
     * 刷新战斗力
     *
     * @param Fleet $fleet
     * @return Fleet
     * @author Zhou Yu
     */
    public function createFleetPower(Fleet $fleet)
    {
        $power = new FleetPowerController();
        $fleet->power = $power->power();
        $fleet->save();
        return $fleet;
    }

    /**
     * 随机创建初始船员
     *
     * @param $fleet_id
     * @author Zhou Yu
     */
    public function createFleetStaff($fleet_id)
    {
        $ctl = new StaffController();
        $ctl->createStaff($fleet_id, 1);
        $ctl->createStaff($fleet_id);
    }
}
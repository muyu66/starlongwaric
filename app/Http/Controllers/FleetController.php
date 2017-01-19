<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\Config;
use App\Models\Fleet;
use App\Models\FleetBody;
use App\Models\FleetBodyWidget;
use App\Models\FleetTech;
use App\Models\FleetTechTech;
use Illuminate\Http\Request;
use Validator;

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
     * @return Fleet|\Illuminate\Database\Eloquent\Model|null|static
     */
    public function show()
    {
        $model = Fleet::alive()->where('user_id', $this->getUserId())->first();
        $model = $this->updateFleetPower($model);
        $model = $this->updateStaffCount($model);
        $model = $this->convertRank($model);
        $model = $this->convertPlanet($model);
        $model = $this->convertUnion($model);
        return $model;
    }

    public function valid(Array $array)
    {
        $validator = Validator::make($array, [
            'name' => 'required',
        ]);

        $this->validCore($validator);
    }

    public function store(Request $request, $name = null)
    {
        $name = $request->input('name') ? : $name;

        $this->valid(['name' => $name]);

        /**
         * 验证是否有已存在的舰队，有则禁止继续
         */
        $this->checkFleetAlive();

        $fleet = $this->createFleet($name);
        $this->createFleetBody($fleet->id);
        $this->createFleetTech($fleet->id);
        $this->updateFleetPower($fleet);
        $this->createFleetStaff($fleet->id);
    }

    private function checkFleetAlive()
    {
        $alive = Fleet::alive()->where('user_id', $this->getUserId())->count();
        if ($alive) {
            throw new ApiException(40501);
        }
    }

    private function createFleet($name)
    {
        $fleet = new Fleet();
        $fleet->user_id = $this->getUserId();
        $fleet->name = $name;
        $fleet->staff = 2;
        $fleet->union_id = 1;
        $fleet->planet_id = 1;
        $fleet->gold = 100;
        $fleet->fuel = 10;
        $fleet->alive = 1;
        $fleet->power = 0;
        $fleet->contribution = 0;
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

    /**
     * 刷新战斗力
     *
     * @param Fleet $fleet
     * @return Fleet
     * @author Zhou Yu
     */
    public function updateFleetPower(Fleet $fleet)
    {
        $power = new FleetPowerController();
        $fleet->power = $power->power();
        $fleet->save();
        return $fleet;
    }

    public function updateStaffCount(Fleet $fleet)
    {
        $ctl = new StaffController();
        $fleet->staff = $ctl->getCount($this->getFleetId());
        $fleet->save();
        return $fleet;
    }

    public function convertRank(Fleet $fleet)
    {
        $ctl = new MilitaryRankController();
        $fleet->rank = $ctl->getRank($fleet->contribution);
        return $fleet;
    }

    public function convertPlanet(Fleet $fleet)
    {
        $ctl = new PlanetController();
        $fleet->planet = $ctl->getName($fleet->planet_id);
        $fleet->planet_full = $ctl->getFullName($fleet->planet_id);
        return $fleet;
    }

    public function convertUnion(Fleet $fleet)
    {
        $ctl = new UnionController();
        $fleet->union = $ctl->show($fleet->union_id)->name;
        return $fleet;
    }
}

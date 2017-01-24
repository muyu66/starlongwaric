<?php

namespace App\Http\Logics;

use App\Events\FleetCreateEvent;
use App\Exceptions\ApiException;
use App\Http\Controllers\FleetPowerController;
use App\Http\Controllers\MilitaryRankController;
use App\Http\Controllers\PlanetController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UnionController;
use App\Models\Fleet;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Event;

class FleetLogic extends Logic
{
    public function check(Array $array)
    {
        $validator = Validator::make($array, [
            'name' => 'required',
        ]);

        $this->validCore($validator);
    }

    public function create($user_id, $name)
    {
        $this->check(['name' => $name]);

        // 验证是否有已存在的舰队，有则禁止继续
        $this->checkFleetAlive($user_id);

        Event::fire(new FleetCreateEvent(Fleet::create(), $name, $user_id));
    }

    private function checkFleetAlive($user_id)
    {
        $alive = Fleet::where('user_id', $user_id)->count();
        if ($alive) {
            throw new ApiException(40501);
        }
    }

    /**
     * 刷新战斗力
     *
     * @param Model $fleet
     * @return Model
     * @author Zhou Yu
     */
    public function updateFleetPower(Model $fleet)
    {
        $power = new FleetPowerController();
        $fleet->power = $power->power();
        return $fleet;
    }

    public function updateStaffCount(Model $fleet)
    {
        $ctl = new StaffController();
        $fleet->staff = $ctl->getCount($fleet->id);

        $fleet->save();

        return $fleet;
    }

    public function convertRank(Model $fleet)
    {
        $ctl = new MilitaryRankController();
        $fleet->rank = $ctl->loc()->getRank($fleet->contribution);
        return $fleet;
    }

    public function convertPlanet(Model $fleet)
    {
        $ctl = new PlanetController();
        $fleet->planet = $ctl->getName($fleet->planet_id);
        $fleet->planet_full = $ctl->getFullName($fleet->planet_id);
        return $fleet;
    }

    public function convertUnion(Model $fleet)
    {
        $ctl = new UnionController();
        $fleet->union = $ctl->show($fleet->union_id)->name;
        return $fleet;
    }
}

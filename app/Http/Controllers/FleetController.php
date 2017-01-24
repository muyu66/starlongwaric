<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use Illuminate\Http\Request;

class FleetController extends Controller implements RestFulInterface
{
    /**
     * 返回所有(包括阵亡)的舰队
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @author Zhou Yu
     */
    public function index()
    {
        return Fleet::withTrashed()->get();
    }

    public function show($id)
    {
        $this->showMe($id);

        $model = Fleet::withTrashed()->findOrFail($id);
        $model = $this->loc()->updateFleetPower($model);
        $model = $this->loc()->updateStaffCount($model); // 最终 save()
        $model = $this->loc()->convertRank($model);
        $model = $this->loc()->convertPlanet($model);
        $model = $this->loc()->convertUnion($model);
        return $model;
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $this->loc()->create($this->getUserId(), $name);
    }
}

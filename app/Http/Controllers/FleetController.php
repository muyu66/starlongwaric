<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use Illuminate\Http\Request;

class FleetController extends Controller
{
    public function postAdd(Request $request)
    {
        //todo 验证器
        $name = $request->input('name');

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
    }

    public function getInfo()
    {
        $fleets = Fleet::get();
        return $fleets->merge($this->getPower());
    }

    private function getPower()
    {
        return ['power' => 1111];
    }
}
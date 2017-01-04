<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\FleetTech;
use App\Models\FleetTechTech;
use Illuminate\Http\Request;

class FleetTechController extends Controller
{
    public function index()
    {
        return FleetTech::self($this->fleet_id)->get();
    }

    public function show($id)
    {
        return FleetTech::self($this->fleet_id)->where('id', $id)->firstOrFail();
    }

    /**
     * @description 单件升级
     * @param Request $request
     * @param null $id
     * @param int $num
     * @return array
     * @author Zhou Yu
     */
    public function store(Request $request, $id = null, $num = 1)
    {
        $id = $request->input('id') ? : $id;
        $num = $request->input('num') ? : $num;

        $ftt = FleetTechTech::where('id', $id)->firstOrFail();
        $fleet = $this->fleet;
        $ft = $this->show($id);

        if ($ft->level == Config::getDb('tech_limit')) {
            return ['id' => $id, 'update' => 0, 'gold' => 0];
        } else {
            $amount = 0;
            $gold_is_empty = 0;
            $level_is_max = 0;
            $this->update($ft, $fleet, $ftt, $amount, $gold_is_empty, $level_is_max, $num);
            $fleet->save();
            $ft->save();
            return [
                'id' => $id, 'update' => $amount,
                'gold' => $amount * $ftt->per_fee,
                'gold_is_empty' => $gold_is_empty,
                'level_is_max' => $level_is_max,
            ];
        }
    }

    /**
     * @description 单件升级算法
     * @param $ft
     * @param $fleet
     * @param $ftt
     * @param $amount
     * @param $gold_is_empty
     * @param $level_is_max
     * @param $num
     * @author Zhou Yu
     */
    private function update(&$ft, &$fleet, $ftt, &$amount, &$gold_is_empty, &$level_is_max, $num)
    {
        foreach (g_yields($num) as $i) {
            if ($fleet->gold <= $ftt->per_fee) {
                $gold_is_empty = 1;
                continue 1;
            }
            if ($ft->level >= Config::getDb('tech_limit')) {
                $level_is_max = 1;
                continue 1;
            }
            $fleet->gold -= $ftt->per_fee;
            $ft->level += 1;
            $amount++;
        }
    }

    /**
     * @description 全部升级
     * @param Request $request
     * @return array
     * @author Zhou Yu
     */
    public function postStoreAll(Request $request)
    {
        $num = $request->input('num');
        $result = [];
        $models = FleetTech::self($this->fleet_id)->get();
        foreach ($models as $model) {
            $result[] = $this->store(new Request(), $model->id, $num);
        }
        return $result;
    }
}
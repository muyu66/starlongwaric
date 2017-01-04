<?php

namespace App\Http\Controllers;

use App\Models\FleetBody;
use App\Models\FleetBodyWidget;
use Illuminate\Http\Request;

class FleetBodyController extends Controller
{
    public function index()
    {
        return FleetBody::self($this->fleet_id)->get();
    }

    public function show($id)
    {
        return FleetBody::self($this->fleet_id)->where('id', $id)->firstOrFail();
    }

    /**
     * @description 单件修复
     * @param Request $request
     * @param null $id
     * @return array
     * @author Zhou Yu
     */
    public function store(Request $request, $id = null)
    {
        $id = $request->input('id') ? : $id;

        $fbw = FleetBodyWidget::where('id', $id)->firstOrFail();
        $fleet = $this->fleet;
        $fb = $this->show($id);

        if ($fb->health == 100) {
            return ['id' => $id, 'fix' => 0, 'gold' => 0];
        } else {
            $amount = 0;
            $gold_is_empty = 0;
            $this->fix($fb, $fleet, $fbw, $amount, $gold_is_empty);
            $fleet->save();
            $fb->save();
            return [
                'id' => $id, 'fix' => $amount,
                'gold' => $amount * $fbw->per_fee,
                'gold_is_empty' => $gold_is_empty,
            ];
        }
    }

    /**
     * @description 单件修复算法
     * @param $fb
     * @param $fleet
     * @param $fbw
     * @param $amount
     * @param $gold_is_empty
     * @author Zhou Yu
     */
    private function fix(&$fb, &$fleet, $fbw, &$amount, &$gold_is_empty)
    {
        foreach (g_yields(100 - $fb->health) as $i) {
            if ($fleet->gold <= $fbw->per_fee) {
                $gold_is_empty = 1;
                continue 1;
            }
            $fleet->gold -= $fbw->per_fee;
            $fb->health += 1;
            $amount++;
        }
    }

    /**
     * @description 全部修复
     * @return array
     * @author Zhou Yu
     */
    public function postStoreAll()
    {
        $result = [];
        $models = FleetBody::self($this->fleet_id)->get();
        foreach ($models as $model) {
            $result[] = $this->store(new Request(), $model->id);
        }
        return $result;
    }
}
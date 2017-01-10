<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Faker\Factory;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function getMy()
    {
        return Staff::where('boss_id', $this->getFleetId())->get();
    }

    public function getMarket()
    {
        return Staff::where('boss_id', 0)->get();
    }

    /**
     * 任命指挥官
     * 指挥官: 在用户离线的情况下，根据自身的思考，帮玩家做出选择
     *
     * @param Request $request
     * @throws \Exception
     * @author Zhou Yu
     */
    public function postAppointCommander(Request $request)
    {
        $commander_id = $request->input('commander_id');

        /**
         * 找寻前任、现任指挥官
         */
        $old = Staff::where('boss_id', $this->getFleetId())
            ->where('is_commander', 1)
            ->first();
        $new = Staff::where('boss_id', $this->getFleetId())->findOrFail($commander_id);

        /**
         * 重复任命修正
         */
        if ($old->id == $new->id) {
            throw new \Exception('重复操作');
        }

        /**
         * 任命、卸任
         */
        $new->is_commander = 1;
        $new->save();
        $old->is_commander = 0;
        $old->save();
    }

    public function createStaff($fleet_id, $is_commander = 0)
    {
        $faker = Factory::create('en_US');

        $model = new Staff();
        $model->boss_id = $fleet_id;
        $model->is_hero = 0;
        $model->name = $faker->name;
        $model->desc = '一个普通船员';
        $model->character = rand(0, 2);
        $model->job = rand(0, 3);
        $model->job_ability = rand(20, 70);
        $model->is_commander = $is_commander;
        $model->intelligence = rand(20, 70);
        $model->loyalty = rand(50, 90);
        $model->save();

        return $model;
    }
}
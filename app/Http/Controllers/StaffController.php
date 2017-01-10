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
     * @author Zhou Yu
     */
    public function postAppointCommander(Request $request)
    {
        $commander_id = $request->input('commander_id');

        /**
         * 任命新任指挥官
         */
        $model = Staff::where('boss_id', $this->getFleetId())->findOrFail($commander_id);
        $model->is_commander = 1;
        $model->save();

        /**
         * 卸任现任指挥官
         */
        $model = Staff::where('boss_id', $this->getFleetId())
            ->where('is_commander', 1)
            ->first();
        $model->is_commander = 0;
        $model->save();
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
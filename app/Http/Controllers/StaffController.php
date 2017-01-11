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

    public function getMyCommander()
    {
        return Staff::where('boss_id', $this->getFleetId())
            ->where('is_commander', 1)
            ->first();
    }

    /**
     * 获取指定玩家的指挥官
     *
     * @param $fleet_id
     * @return Staff
     * @author Zhou Yu
     */
    public function commander($fleet_id)
    {
        return Staff::where('boss_id', $fleet_id)
            ->where('is_commander', 1)
            ->first();
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

    public function calcGold($id)
    {
        $model = Staff::findOrFail($id);
        return $model->is_hero * 10000 + $model->job_ability * $model->intelligence;
    }

    /**
     *
     *
     * @param $fleet_id
     * @param int $is_commander
     * @param int $level 1-5, level 越高, 数值可能越高
     * @return Staff
     * @author Zhou Yu
     */
    public function createStaff($fleet_id, $is_commander = 0, $level = 0)
    {
        switch ($level) {
            case 1:
                $level_name = '初级';
                break;
            case 2:
                $level_name = '中级';
                break;
            case 3:
                $level_name = '高级';
                break;
            case 4:
                $level_name = '特级';
                break;
            case 5:
                $level_name = '王者级';
                break;
            default:
                $level_name = '普通';
        }

        $faker = Factory::create('en_US');
        $level = $level ? : rand(1, 5);

        $model = new Staff();
        $model->boss_id = $fleet_id;
        $model->is_hero = 0;
        $model->name = $faker->name;
        $model->desc = "一个{$level_name}船员";
        $model->character = rand(0, 2);
        $model->job = rand(0, 3);
        $model->job_ability = $level * rand(5, 10) + rand(5, 20);
        $model->is_commander = $is_commander;
        $model->intelligence = $level * rand(5, 10) + rand(5, 20);
        $model->loyalty = $level * rand(5, 10) + rand(20, 40);
        $model->save();

        return $model;
    }
}

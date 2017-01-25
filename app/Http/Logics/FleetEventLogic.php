<?php

namespace App\Http\Logics;

use App\Events\TaskEvent;
use App\Http\Controllers\StaffController;
use App\Models\Event;
use App\Models\EventStandard;
use App\Models\Fleet;
use Event as FacadeEvent;
use Illuminate\Database\Eloquent\Model;

class FleetEventLogic extends Logic
{
    /**
     * 随机生成随机玩家的事件
     *
     * @param int $player_fleet_id 指定玩家，而不随机
     * @param int $event_id 指定事件，而不随机
     * @return Event
     * @author Zhou Yu
     */
    public function generate($player_fleet_id = 0, $event_id = 0)
    {
        // 事件号 取值范围
        $event_max_count = EventStandard::count();

        // 获取存活玩家的 ID
        $fleet_id = Fleet::where('alive', 1)->get()->random()->id;

        $ctl = new StaffController();

        $model = new Event();
        $model->fleet_id = $player_fleet_id ? : $fleet_id;
        $model->standard_id = $event_id ? : rand(1, $event_max_count);
        $model->status = 0;
        $model->commander = $ctl->commander($model->fleet_id)->id; // 获取玩家的指挥官
        $model->save();

        return $model;
    }

    public function resolve(Event $model, $commander_id = 0, $choose, $fleet_id)
    {
        $model->commander = $commander_id;
        $model->status = -1;
        $model->save();

        $params['fleet_id'] = $fleet_id;

        FacadeEvent::fire(new TaskEvent($model, $choose, $params));
    }
}

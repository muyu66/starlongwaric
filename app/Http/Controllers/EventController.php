<?php

namespace App\Http\Controllers;

use App\Events\TaskEvent;
use App\Models\Event;
use App\Models\EventStandard;
use App\Models\Fleet;
use Illuminate\Http\Request;
use Event as FacadeEvent;

class EventController extends Controller
{
    /**
     * 返回 顺序完成状态、逆序时间 且 尚未完成
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @author Zhou Yu
     */
    /**
     *
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUnFinish()
    {
        return Event::belong($this->getFleetId())
            ->whereIn('status', [-1, 0])
            ->with(['standard', 'staff'])
            ->orderByRaw('`status` asc, `updated_at` desc')
            ->paginate(g_get_paginate_count());
    }

    /**
     * 返回 顺序完成状态、逆序时间 且 已经完成
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @author Zhou Yu
     */
    public function getFinish()
    {
        return Event::belong($this->getFleetId())
            ->where('status', 1)
            ->with(['standard', 'staff'])
            ->orderByRaw('`status` asc, `updated_at` desc')
            ->get();
    }

    public function postResolve(Request $request, $p_id = 0, $p_choose = 0, $fleet_id = 0)
    {
        $event_id = $request->input('id') ? : $p_id;
        $choose = $request->input('choose') ? : $p_choose;
        $fleet_id = $fleet_id ? : $this->getFleetId();

        $model = Event::belong($fleet_id)
            ->where('status', 0)
            ->with(['standard', 'staff'])
            ->findOrFail($event_id);
        $model->commander = $p_id ? $model->commander : 0;
        $model->status = -1;
        $model->save();

        $params['fleet_id'] = $fleet_id;

        FacadeEvent::fire(new TaskEvent($model, $choose, $params));
    }

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
}

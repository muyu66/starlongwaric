<?php

namespace App\Http\Controllers;

use App\Events\TaskEvent;
use App\Models\Event;
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventStandard;
use App\Models\Fleet;
use Illuminate\Http\Request;
use App\Http\Components\Event as EventFunc;

class EventController extends Controller
{
    /**
     * 返回 顺序完成状态、逆序时间
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @author Zhou Yu
     */
    public function getIndex()
    {
        return Event::belong($this->getFleetId())
            ->with('standard')
            ->orderByRaw('`status` asc, `updated_at` desc')
            ->get();
    }

    public function postResolve(Request $request)
    {
        $event_id = $request->input('id');
        $choose = $request->input('choose');

        $model = Event::belong($this->getFleetId())
            ->where('status', 0)
            ->where('commander', 0)
            ->with('standard')
            ->findOrFail($event_id);

        $params['fleet_id'] = $this->getFleetId();

        $ctl = new EventFunc($model, $choose, $params);
        $ctl->run();

        $model->status = 1;
        $model->save();
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

        $model = new Event();
        $model->fleet_id = $player_fleet_id ? : $fleet_id;
        $model->standard_id = $event_id ? : rand(1, $event_max_count);
        $model->status = 0;
        $model->commander = 0;
        $model->save();

        return $model;
    }
}

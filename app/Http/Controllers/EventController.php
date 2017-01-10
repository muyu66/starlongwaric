<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventStandard;
use App\Models\Fleet;

class EventController extends Controller
{
    public function getIndex()
    {
        return Event::belong($this->getFleetId())
            ->with('standard')
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    /**
     * 随机生成随机玩家的事件
     *
     * @author Zhou Yu
     */
    public function generate()
    {
        $event_max_count = EventStandard::count();
        $fleet_id = Fleet::where('alive', 1)->get()->random()->id;

        $model = new Event();
        $model->fleet_id = $fleet_id;
        $model->standard_id = rand(1, $event_max_count);
        $model->status = 0;
        $model->commander = 0;
        $model->save();
    }
}
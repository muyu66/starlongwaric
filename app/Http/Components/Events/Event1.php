<?php

namespace App\Http\Components\Events;

use App\Http\Controllers\FightController;
use App\Http\Logics\FightLogic;
use App\Models\Fleet;

class Event1 extends Event
{
    /**
     * 战斗事件
     */
    public function handle()
    {
        $fleet_id = $this->params['fleet_id'];

        /**
         * 1 v 1 对战
         */
        if ($this->standard_params['count'] === 1 && $this->choose === 1) {
            $loc = new FightLogic();
            $loc->fight(Fleet::alive()->findOrFail($fleet_id));
        }
    }
}

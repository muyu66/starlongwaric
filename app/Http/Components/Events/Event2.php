<?php

namespace App\Http\Components\Events;

use App\Http\Controllers\StaffController;

class Event2 extends Event
{
    /**
     * 招募事件
     */
    public function handle()
    {
        $fleet_id = $this->params['fleet_id'];

        $ctl = new StaffController();
        $ctl->createStaff($fleet_id, 0, $this->standard_params['level']);
    }
}

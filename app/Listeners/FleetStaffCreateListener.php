<?php

namespace App\Listeners;

use App\Events\FleetCreateEvent;
use App\Http\Controllers\StaffController;
use Illuminate\Contracts\Queue\ShouldQueue;

class FleetStaffCreateListener implements ShouldQueue
{
    public function handle(FleetCreateEvent $instance)
    {
        $fleet = $instance->fleet;

        $ctl = new StaffController();
        $ctl->createStaff($fleet->id, 1);
        $ctl->createStaff($fleet->id);
    }
}

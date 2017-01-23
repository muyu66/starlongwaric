<?php

namespace App\Listeners;

use App\Events\FleetCreateEvent;
use App\Http\Controllers\StaffController;
use App\Models\Staff;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\FleetDeleteEvent;
use Illuminate\Events\Dispatcher;

class FleetStaffListener implements ShouldQueue
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            FleetDeleteEvent::class,
            FleetStaffListener::class . '@onDelete'
        );

        $events->listen(
            FleetCreateEvent::class,
            FleetStaffListener::class . '@onCreate'
        );
    }

    public function onCreate(FleetCreateEvent $instance)
    {
        $fleet = $instance->fleet;

        $ctl = new StaffController();
        $ctl->createStaff($fleet->id, 1);
        $ctl->createStaff($fleet->id);
    }

    public function onDelete(FleetDeleteEvent $instance)
    {
        $fleet_id = $instance->fleet_id;

        Staff::where('boss_id', $fleet_id)->update(['boss_id' => 0]);
    }
}

<?php

namespace App\Listeners;

use App\Events\FleetCreateEvent;
use App\Events\FleetDeleteEvent;
use App\Models\Fleet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;

class FleetListener implements ShouldQueue
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            FleetDeleteEvent::class,
            FleetListener::class . '@onDelete'
        );

        $events->listen(
            FleetCreateEvent::class,
            FleetListener::class . '@onCreate'
        );
    }

    public function onCreate(FleetCreateEvent $instance)
    {
        $fleet = $instance->fleet;
        $name = $instance->name;
        $user_id = $instance->user_id;

        $fleet->user_id = $user_id;
        $fleet->name = $name;
        $fleet->staff = 2;
        $fleet->union_id = 1;
        $fleet->planet_id = 1;
        $fleet->gold = 100;
        $fleet->fuel = 10;
        $fleet->alive = 1;
        $fleet->power = 0;
        $fleet->contribution = 0;
        $fleet->save();
    }

    public function onDelete(FleetDeleteEvent $instance)
    {
        $fleet_id = $instance->fleet_id;
        Fleet::find($fleet_id)->delete();
    }
}

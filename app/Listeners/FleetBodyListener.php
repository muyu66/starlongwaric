<?php

namespace App\Listeners;

use App\Events\FleetCreateEvent;
use App\Events\FleetDeleteEvent;
use App\Http\Logics\FleetBodyLogic;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use App\Models\FleetBody;
use App\Models\FleetBodyWidget;

class FleetBodyListener implements ShouldQueue
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            FleetDeleteEvent::class,
            FleetBodyListener::class . '@onDelete'
        );

        $events->listen(
            FleetCreateEvent::class,
            FleetBodyListener::class . '@onCreate'
        );
    }

    public function onCreate(FleetCreateEvent $instance)
    {
        $fleet = $instance->fleet;

        $fleet_body = new FleetBodyLogic();
        $fleet_body->createCopy($fleet->id);
    }

    public function onDelete(FleetDeleteEvent $instance)
    {
        $fleet_id = $instance->fleet_id;

        FleetBody::belong($fleet_id)->delete();
    }
}

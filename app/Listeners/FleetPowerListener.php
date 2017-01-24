<?php

namespace App\Listeners;

use App\Events\FleetCreateEvent;
use App\Events\FleetDeleteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use App\Http\Controllers\FleetPowerController;

class FleetPowerListener implements ShouldQueue
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            FleetDeleteEvent::class,
            FleetPowerListener::class . '@onDelete'
        );

        $events->listen(
            FleetCreateEvent::class,
            FleetPowerListener::class . '@onCreate'
        );
    }

    public function onCreate(FleetCreateEvent $instance)
    {
        $fleet = $instance->fleet;

        $power = new FleetPowerController();
        $fleet->power = $power->loc()->power($fleet->id);
        $fleet->save();
    }

    public function onDelete(FleetDeleteEvent $instance)
    {

    }
}

<?php

namespace App\Listeners;

use App\Events\FleetCreateEvent;
use App\Events\FleetDeleteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use App\Models\FleetTech;
use App\Models\FleetTechTech;

class FleetTechListener implements ShouldQueue
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            FleetDeleteEvent::class,
            FleetTechListener::class . '@onDelete'
        );

        $events->listen(
            FleetCreateEvent::class,
            FleetTechListener::class . '@onCreate'
        );
    }

    public function onCreate(FleetCreateEvent $instance)
    {
        $fleet = $instance->fleet;

        $copies = FleetTechTech::get();
        foreach ($copies as $copy) {
            $body = new FleetTech();
            $body->fleet_id = $fleet->id;
            $body->tech_id = $copy->id;
            $body->level = 0;
            $body->save();
        }
    }

    public function onDelete(FleetDeleteEvent $instance)
    {
        $fleet_id = $instance->fleet_id;

        FleetTech::belong($fleet_id)->delete();
    }
}

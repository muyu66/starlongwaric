<?php

namespace App\Listeners;

use App\Events\FleetCreateEvent;
use App\Models\FleetTech;
use App\Models\FleetTechTech;
use Illuminate\Contracts\Queue\ShouldQueue;

class FleetTechCreateListener implements ShouldQueue
{
    public function handle(FleetCreateEvent $instance)
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
}

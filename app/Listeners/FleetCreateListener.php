<?php

namespace App\Listeners;

use App\Events\FleetCreateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class FleetCreateListener implements ShouldQueue
{
    public function handle(FleetCreateEvent $instance)
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
}

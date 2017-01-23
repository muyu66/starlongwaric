<?php

namespace App\Listeners;

use App\Events\FleetCreateEvent;
use App\Models\FleetBody;
use App\Models\FleetBodyWidget;
use Illuminate\Contracts\Queue\ShouldQueue;

class FleetBodyCreateListener implements ShouldQueue
{
    public function handle(FleetCreateEvent $instance)
    {
        $fleet = $instance->fleet;

        $copies = FleetBodyWidget::get();
        foreach ($copies as $copy) {
            $body = new FleetBody();
            $body->fleet_id = $fleet->id;
            $body->widget_id = $copy->id;
            $body->health = 100;
            $body->save();
        }
    }
}

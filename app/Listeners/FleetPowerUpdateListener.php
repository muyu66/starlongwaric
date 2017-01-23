<?php

namespace App\Listeners;

use App\Events\FleetCreateEvent;
use App\Http\Controllers\FleetPowerController;
use App\Models\FleetBody;
use App\Models\FleetBodyWidget;
use Illuminate\Contracts\Queue\ShouldQueue;

class FleetPowerUpdateListener implements ShouldQueue
{
    public function handle(FleetCreateEvent $instance)
    {
        $fleet = $instance->fleet;

        $power = new FleetPowerController();
        $fleet->power = $power->power2($fleet->id);
        $fleet->save();
    }
}

<?php

namespace App\Console\Commands;

use App\Http\Controllers\FleetController;
use App\Models\Fleet;
use App\Models\FleetBody;
use App\Models\FleetTech;
use Illuminate\Console\Command;

class DataFix extends Command
{
    protected $signature = 'data:fix';
    protected $description = 'fix player data';

    public function handle()
    {
        $ctl = new FleetController();
        $fleet_ids = Fleet::get(['id'])->pluck('id');
        foreach ($fleet_ids as $fleet_id) {
            if (! FleetBody::where('fleet_id', $fleet_id)->count()) {
                $ctl->createFleetBody($fleet_id);
            }
            if (! FleetTech::where('fleet_id', $fleet_id)->count()) {
                $ctl->createFleetTech($fleet_id);
            }
        }
    }
}

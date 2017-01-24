<?php

namespace App\Console\Commands;

use App\Http\Controllers\FleetController;
use App\Http\Logics\FleetBodyLogic;
use App\Http\Logics\FleetTechLogic;
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
        $fleet_body = new FleetBodyLogic();
        $fleet_tech = new FleetTechLogic();

        $fleet_ids = Fleet::get(['id'])->pluck('id');
        foreach ($fleet_ids as $fleet_id) {
            if (! FleetBody::where('fleet_id', $fleet_id)->count()) {
                $fleet_body->createCopy($fleet_id);
            }
            if (! FleetTech::where('fleet_id', $fleet_id)->count()) {
                $fleet_tech->createCopy($fleet_id);
            }
        }
    }
}

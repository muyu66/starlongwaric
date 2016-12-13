<?php

namespace App\Models;

use \Eloquent;

class FleetBodyWidget extends Eloquent
{
    protected $table = 'fleet_body_widgets';
    protected $fillable = ['name'];
}

<?php

namespace App\Models;

use \Eloquent;

class FleetBodyWidget extends Eloquent
{
    protected $table = 'fleet_body_widgets';
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at', 'id'];
}

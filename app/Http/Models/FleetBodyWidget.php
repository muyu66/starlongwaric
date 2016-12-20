<?php

namespace App\Models;

class FleetBodyWidget extends Base
{
    protected $table = 'fleet_body_widgets';
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at', 'id'];
}

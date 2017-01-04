<?php

namespace App\Models;

class FleetConfig extends Base
{
    protected $table = 'fleet_configs';
    protected $fillable = ['fleet_id'];
    protected $casts = [
        'configs' => 'Array',
    ];
}

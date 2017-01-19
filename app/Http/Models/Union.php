<?php

namespace App\Models;

class Union extends Base
{
    protected $table = 'unions';

    protected $fillable = ['name'];

    protected $casts = [
        'occupied_planet' => 'Array',
        'diplomacy' => 'Array',
    ];
}

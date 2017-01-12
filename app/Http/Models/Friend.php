<?php

namespace App\Models;

class Friend extends Base
{
    protected $table = 'friends';

    protected $fillable = ['fleet_id'];

    protected $casts = [
        'friends' => 'Array',
    ];
}

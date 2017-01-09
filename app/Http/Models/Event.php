<?php

namespace App\Models;

class Event extends Base
{
    protected $table = 'events';

    protected $fillable = ['name', 'desc'];

    protected $casts = [
        'params' => 'Array',
    ];
}

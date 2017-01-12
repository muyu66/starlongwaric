<?php

namespace App\Models;

class EventStandard extends Base
{
    protected $table = 'event_standards';

    protected $fillable = ['name', 'desc'];

    protected $casts = [
        'params' => 'Array',
    ];
}

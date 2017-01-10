<?php

namespace App\Models;

class Event extends Base
{
    protected $table = 'events';

    public function standard()
    {
        return $this->hasOne(EventStandard::class, 'id', 'standard_id');
    }
}

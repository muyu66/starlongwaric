<?php

namespace App\Models;

use \Eloquent;

class Base extends Eloquent
{
    public static function getWith($with, $fleet_id)
    {
        return static::where('fleet_id', $fleet_id)->with($with)->get();
    }
}

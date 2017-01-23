<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Base extends Eloquent
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function getWith($with, $fleet_id)
    {
        return static::where('fleet_id', $fleet_id)->with($with)->get();
    }

    /**
     * 限定 Fleet
     *
     * @param $fleet_id
     * @return static
     * @author Zhou Yu
     */
    public static function belong($fleet_id)
    {
        return static::where('fleet_id', $fleet_id);
    }
}

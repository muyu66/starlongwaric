<?php

namespace App\Models;

class Staff extends Base
{
    protected $table = 'staff';

    protected $fillable = ['name', 'desc'];

    public static function getCount($fleet_id)
    {
        return static::where('boss_id', $fleet_id)->count();
    }
}

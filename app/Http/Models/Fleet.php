<?php

namespace App\Models;

class Fleet extends Base
{
    protected $table = 'fleets';
    protected $hidden = ['created_at', 'updated_at', 'rank_id', 'user_id'];

    public static function alive()
    {
        return static::where('alive', 1);
    }

    public static function getName($fleet_id)
    {
        return Fleet::findOrFail($fleet_id)->name;
    }
}

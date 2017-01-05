<?php

namespace App\Models;

class Fleet extends Base
{
    protected $table = 'fleets';
    protected $hidden = ['created_at', 'updated_at'];

    public static function isAlive()
    {
        return static::where('alive', 1);
    }
}

<?php

namespace App\Models;

use \Eloquent;

class Config extends Eloquent
{
    protected $table = 'configs';
    protected $fillable = ['key'];

    public static function getDb($key)
    {
        return static::where('key', $key)->firstOrFail()->value;
    }
}

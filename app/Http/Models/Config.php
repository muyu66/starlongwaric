<?php

namespace App\Models;

class Config extends Base
{
    protected $table = 'configs';
    protected $fillable = ['key'];

    public static function getDb($key)
    {
        return static::where('key', $key)->firstOrFail()->value;
    }
}

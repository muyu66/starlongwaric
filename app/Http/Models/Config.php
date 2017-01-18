<?php

namespace App\Models;

class Config extends Base
{
    protected $table = 'configs';
    protected $fillable = ['key'];
    protected $casts = [
        'value' => 'Array',
    ];

    public static function getDb($key)
    {
        return static::where('key', $key)->firstOrFail()->value;
    }
}

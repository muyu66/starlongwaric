<?php

namespace App\Models;

class Fleet extends Base
{
    protected $table = 'fleets';
    protected $hidden = ['created_at', 'updated_at'];

    public static function getByUserId($user_id)
    {
        return static::where('user_id', $user_id)->get();
    }

    public static function findOrFailByUserId($id, $user_id)
    {
        return static::where('user_id', $user_id)->findOrFail($id);
    }
}

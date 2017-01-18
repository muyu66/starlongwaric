<?php

namespace App\Models;

class Planet extends Base
{
    protected $table = 'planets';

    protected $hidden = ['created_at', 'updated_at', 'id'];

    protected $fillable = ['coordinate'];

    protected $casts = [
        'coordinate' => 'Array',
    ];

    public static function getName($id)
    {
        return static::findOrFail($id)->name;
    }

    public static function getPostion($id)
    {
        $planet = static::findOrFail($id);
        $quadrant = Quadrant::findOrFail($planet->quadrant_id);
        $galaxy = Galaxy::findOrFail($quadrant->galaxy_id);
        return $galaxy->name . ' ' . $quadrant->name . ' ' . $planet->name;
    }
}

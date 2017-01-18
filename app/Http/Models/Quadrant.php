<?php

namespace App\Models;

class Quadrant extends Base
{
    protected $table = 'quadrants';

    protected $hidden = ['created_at', 'updated_at', 'id'];

    protected $fillable = ['coordinate'];

    protected $casts = [
        'coordinate' => 'Array',
    ];

    public function planet()
    {
        return $this->hasMany(Planet::class);
    }
}

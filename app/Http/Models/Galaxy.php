<?php

namespace App\Models;

class Galaxy extends Base
{
    protected $table = 'galaxies';

    protected $hidden = ['created_at', 'updated_at', 'id'];

    protected $fillable = ['coordinate'];

    protected $casts = [
        'coordinate' => 'Array',
    ];

    public function quadrant()
    {
        return $this->hasMany(Quadrant::class);
    }
}

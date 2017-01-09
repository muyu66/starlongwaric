<?php

namespace App\Models;

class FightLog extends Base
{
    protected $table = 'fight_logs';
    protected $casts = [
        'booty' => 'Array',
    ];
    protected $hidden = ['created_at', 'updated_at'];
}

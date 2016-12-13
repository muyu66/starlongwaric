<?php

namespace App\Models;

use \Eloquent;

class Config extends Eloquent
{
    protected $table = 'configs';
    protected $fillable = ['key'];
}

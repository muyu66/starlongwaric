<?php

namespace App\Models;

class Staff extends Base
{
    protected $table = 'staff';

    protected $fillable = ['name', 'desc'];

    public static function convertJob($job_id)
    {
        switch ($job_id) {
            case 0:
                return trans('staff.job')[0];
            case 1:
                return trans('staff.job')[1];
            case 2:
                return trans('staff.job')[2];
            case 3:
                return trans('staff.job')[3];
        }
    }
}

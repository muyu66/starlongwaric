<?php

namespace App\Models;

class Event extends Base
{
    protected $table = 'events';

    protected $hidden = ['created_at', 'standard_id', 'commander'];

    public function standard()
    {
        return $this->hasOne(EventStandard::class, 'id', 'standard_id');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class, 'id', 'commander');
    }

    /**
     * 已被分派给指挥官 且 尚未处理 的事件
     *
     * @return $this
     * @author Zhou Yu
     */
    public static function commander()
    {
        return static::where('status', '0')->where('commander', '<>', '0');
    }
}

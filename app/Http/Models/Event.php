<?php

namespace App\Models;

class Event extends Base
{
    protected $table = 'events';

    public function standard()
    {
        return $this->hasOne(EventStandard::class, 'id', 'standard_id');
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

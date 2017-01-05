<?php

namespace App\Models;

class FleetBody extends Base
{
    protected $table = 'fleet_bodies';

    /**
     * 计算战斗力公式用
     */
    const POWER_NUM = 'health';
    const POWER_ITEM = 'widget';
    const POWER_PER = 'per_power';
    const STANDARD = 'widget';

    public function widget()
    {
        return $this->hasOne(FleetBodyWidget::class, 'id', 'widget_id');
    }
}

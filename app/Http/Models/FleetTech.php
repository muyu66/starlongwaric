<?php

namespace App\Models;

class FleetTech extends Base
{
    protected $table = 'fleet_teches';

    /**
     * 计算战斗力公式用
     */
    const POWER_NUM = 'level';
    const POWER_ITEM = 'tech';
    const POWER_PER = 'per_power';
    const STANDARD = 'tech';

    public function tech()
    {
        return $this->hasOne(FleetTechTech::class, 'id', 'tech_id');
    }
}

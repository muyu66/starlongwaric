<?php

namespace App\Http\Components;

use App\Http\Controllers\FightController;
use App\Http\Controllers\StaffController;
use App\Models\Fleet;

class Event
{
    private $event_id;

    /**
     * 玩家做出的选择
     *
     * @var int 2|1|0
     */
    private $choose;

    /**
     * @var \App\Models\Event
     */
    private $model;

    /**
     * 公共参数
     *
     * @var
     */
    private $params;

    public function __construct($model, $choose, $params)
    {
        $this->event_id = $model->standard->event;
        $this->model = $model;
        $this->choose = $choose;
        $this->params = $params;
    }

    /**
     * 分发事件
     *
     * @return mixed
     * @author Zhou Yu
     */
    public function run()
    {
        $method = "event{$this->event_id}";
        return $this->$method();
    }

    public function event1()
    {
        $params = $this->model->standard->params;

        $fleet_id = $this->params['fleet_id'];

        if ($params['count'] === 1 && $this->choose === 1) {
            $ctl = new FightController();
            $ctl->fight(Fleet::alive()->findOrFail($fleet_id));
        }
    }

    public function event2()
    {
        $params = $this->model->standard->params;

        $fleet_id = $this->params['fleet_id'];

        $ctl = new StaffController();
        $ctl->createStaff($fleet_id, 0, $params['level']);
    }
}

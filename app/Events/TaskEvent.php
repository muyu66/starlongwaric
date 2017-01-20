<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class TaskEvent extends Event
{
    use SerializesModels;

    public $instance;

    /**
     * 玩家做出的选择
     *
     * @var int 1|0 积极|消极
     */
    public $choose;

    /**
     * 公共参数
     *
     * @var
     */
    public $params;

    public function __construct(Model $event, $choose, $params)
    {
        $this->instance = $event;
        $this->choose = $choose;
        $this->params = $params;
    }

    public function broadcastOn()
    {
        return [];
    }
}

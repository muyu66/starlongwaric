<?php

namespace App\Listeners;

use App\Events\TaskEvent;
use App\Http\Components\Events\Event;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskEventListener implements ShouldQueue
{
    /**
     * @var Event
     */
    private $instance;

    public function handle(TaskEvent $event)
    {
        $model = $event->instance;

        /**
         * 事件编号, 用于分发
         */
        $event_id = $model->standard->event;

        $choose = $event->choose;

        $params = $event->params;

        /**
         * 分发
         */
        $this->setInstance($event_id, $model, $choose, $params);
        $this->instance->handle();
    }

    private function setInstance($event_id, $model, $choose, $params)
    {
        $method = Event::class . $event_id;
        $this->instance = new $method($model, $choose, $params);
    }

    /**
     * 获取 Event 实例
     *
     * @return Event
     */
    public function getInstance()
    {
        return $this->instance;
    }
}

<?php

namespace App\Listeners;

use App\Events\TaskEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskCompleteListener implements ShouldQueue
{
    public function handle(TaskEvent $event)
    {
        $model = $event->instance;
        $model->status = 1;
        $model->save();
    }
}

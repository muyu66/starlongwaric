<?php

namespace App\Providers;

use App\Events\TaskEvent;
use App\Listeners\TaskCompleteEventListener;
use App\Listeners\TaskEventListener;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        TaskEvent::class => [
            TaskEventListener::class,
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);
    }
}

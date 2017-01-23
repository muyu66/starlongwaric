<?php

namespace App\Providers;

use App\Events\FleetCreateEvent;
use App\Events\TaskEvent;
use App\Listeners\FleetBodyCreateListener;
use App\Listeners\FleetCreateListener;
use App\Listeners\FleetPowerUpdateListener;
use App\Listeners\FleetStaffCreateListener;
use App\Listeners\FleetTechCreateListener;
use App\Listeners\TaskCompleteListener;
use App\Listeners\TaskListener;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $defer = false;

    protected $listen = [
        TaskEvent::class => [
            TaskListener::class,
            TaskCompleteListener::class,
        ],
        FleetCreateEvent::class => [
            FleetCreateListener::class,
            FleetBodyCreateListener::class,
            FleetTechCreateListener::class,
            FleetPowerUpdateListener::class,
            FleetStaffCreateListener::class,
        ],
    ];

    public function boot(DispatcherContract $events)
    {
        parent::boot($events);
    }
}

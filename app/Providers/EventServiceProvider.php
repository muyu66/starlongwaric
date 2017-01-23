<?php

namespace App\Providers;

use App\Events\TaskEvent;
use App\Listeners\FleetBodyListener;
use App\Listeners\FleetListener;
use App\Listeners\FleetPowerListener;
use App\Listeners\FleetStaffListener;
use App\Listeners\FleetTechListener;
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
    ];

    protected $subscribe = [
        FleetListener::class,
        FleetBodyListener::class,
        FleetTechListener::class,
        FleetPowerListener::class,
        FleetStaffListener::class,
    ];

    public function boot(DispatcherContract $events)
    {
        parent::boot($events);
    }
}

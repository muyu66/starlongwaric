<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orm\Controllers\Connections\Connection;
use Predis\Client;

class OrmServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Connection::create(new Client(config('orm.redis')));
    }

    public function register()
    {

    }
}

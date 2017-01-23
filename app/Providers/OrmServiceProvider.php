<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orm\Controllers\Connections\Connection;

class OrmServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Connection::create(config('orm.redis'));
    }

    public function register()
    {

    }
}

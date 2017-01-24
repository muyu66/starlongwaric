<?php

namespace App\Providers;

use App\Http\Commons\Redis;
use Illuminate\Support\ServiceProvider;
use Orm\Controllers\Connections\Connection;

class OrmServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $redis = new Redis(config('database.redis.orm'));
        Connection::create($redis->getConnection());
    }

    public function register()
    {

    }
}

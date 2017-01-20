<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (g_is_debug()) {
            DB::connection()->enableQueryLog();
        }

        switch (env('E_WARNING')) {
            case 1:
                error_reporting(E_ALL ^ E_NOTICE);
                break;
            case 2:
                error_reporting(E_ALL);
                break;
            default:
                error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
                break;
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}

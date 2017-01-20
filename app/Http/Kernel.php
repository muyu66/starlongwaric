<?php

namespace App\Http;

use App\Http\Middleware\BasicAuth;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
//        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
//        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Response::class,
//        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        
        /**
         * 无状态登录认证
         */
        'basic.auth' => BasicAuth::class,

//        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
//        'auth' => \App\Http\Middleware\Authenticate::class,
//        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    ];
}

<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class BasicAuth
{
    public function handle($request, Closure $next)
    {
        if (Auth::onceBasic()) {
            return ['status' => 0, 'error' => '帐号或密码错误'];
        } else {
            return $next($request);
        }
    }
}

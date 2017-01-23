<?php

namespace App\Http\Middleware;

use Response;
use Auth;
use Closure;

class BasicAuth
{
    public function handle($request, Closure $next)
    {
        if (Auth::onceBasic()) {
            // 验证失败则
            return Response::json(['code' => 40101, 'msg' => '认证失败',], 200);
        } else {
            return $next($request);
        }
    }
}

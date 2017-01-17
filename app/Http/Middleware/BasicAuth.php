<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Auth;
use Closure;

class BasicAuth
{
    public function handle($request, Closure $next)
    {
        if (Auth::onceBasic()) {
            // 验证失败则
            throw new ApiException(40101);
        } else {
            return $next($request);
        }
    }
}

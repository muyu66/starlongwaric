<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class BasicAuth
{
    public function handle($request, Closure $next)
    {
        return Auth::onceBasic() ?: $next($request);
    }
}

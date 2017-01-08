<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class BasicAuth
{
    public function handle($request, Closure $next)
    {
        if (Auth::onceBasic()) {
            return ['status' => 0, 'error' => 'Invalid credentials'];
        } else {
            return $next($request);
        }
    }
}

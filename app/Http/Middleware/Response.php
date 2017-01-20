<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Response as RootResponse;

class Response
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if (! $response->getContent() && $request->wantsJson()) {
            return RootResponse::json(['code' => 200]);
        }
        return $response;
    }
}

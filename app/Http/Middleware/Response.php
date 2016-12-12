<?php

namespace App\Http\Middleware;

use Closure;

class Response
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (!$response->getContent() && $request->wantsJson()) {
            return \Response::json(['status' => '1']);
        }
        return $response;
    }
}

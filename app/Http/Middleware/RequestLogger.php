<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class RequestLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Log::debug("Request {$request->url()}", [ $request->json() ]);
        $result = $next($request);
        Log::debug("Response", [ $result->getData() ]);
        return $result;
    }
}

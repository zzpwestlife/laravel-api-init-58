<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;

class UserGuardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        config(['auth.defaults.guard' => 'api']);

        return $next($request);
    }
}

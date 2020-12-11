<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AdminGuardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     *
     * @return mixed
     *
     * @throws UnauthorizedHttpException
     */
    public function handle($request, Closure $next)
    {
        config(['auth.defaults.guard' => 'admin']);

        return $next($request);
    }
}

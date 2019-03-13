<?php

namespace App\Http\Middleware;

use Closure;

class DebugBarMiddleware
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
        if(\Auth::check()) {
            if(\Auth::user()->id !== config('platform.main-admin-user-id')) {
                \Debugbar::enable();
            } else {
                \Debugbar::disabled();
            }
        } else {
            \Debugbar::disabled();
        }

        return $next($request);

    }
}

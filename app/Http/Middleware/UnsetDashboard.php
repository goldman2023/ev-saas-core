<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class UnsetDashboard
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
        $request->is_dashboard = false;

        return $next($request);
    }
}

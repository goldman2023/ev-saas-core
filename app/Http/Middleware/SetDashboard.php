<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class SetDashboard
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
        $request->is_dashboard = true;

        return $next($request);
    }
}

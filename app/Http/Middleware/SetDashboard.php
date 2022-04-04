<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

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
        // dd(auth()->user()->shop()->newQueryWithoutRelationships()->first());

        return $next($request);
    }
}

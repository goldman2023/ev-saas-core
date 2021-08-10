<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsAdmin
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
        if (Auth::check() && (auth()->user()->isAdmin() || auth()->user()->isStaff())) {
            return $next($request);
        }
        else{
            abort(404);
        }
    }
}

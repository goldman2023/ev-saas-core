<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class IsSeller
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
        if (Auth::check() && auth()->user()->isSeller() && ! auth()->user()->banned) {
            return $next($request);
        } else {
            abort(404);
        }
    }
}

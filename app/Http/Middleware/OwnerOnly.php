<?php

namespace App\Http\Middleware;

use Closure;

class OwnerOnly
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
        if (! auth()->user()->isOwner()) {
            abort(403);
        }

        return $next($request);
    }
}

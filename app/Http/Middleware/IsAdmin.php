<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

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
        // TODO: Don't forget to add IsModerator and check for permissions
        if (Auth::check() && auth()->user()->isAdmin()) {
            return $next($request);
        }

        abort(404);
    }
}

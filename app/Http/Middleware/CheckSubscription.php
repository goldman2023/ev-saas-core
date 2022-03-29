<?php

namespace App\Http\Middleware;

use Closure;

class CheckSubscription
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
        if (! tenant()->can_use_app && request()->route()->getName() !== 'tenant.settings.application') {
            return redirect(route('tenant.settings.application'));
        }

        return $next($request);
    }
}

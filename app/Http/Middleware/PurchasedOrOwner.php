<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PurchasedOrOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /* TODO: @vukasin check if user has purchased this product or is an owner of it. */
        return $next($request);
    }
}

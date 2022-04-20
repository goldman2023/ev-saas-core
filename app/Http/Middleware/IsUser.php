<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class IsUser
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
        if (Auth::check() && (auth()->user()->isCustomer() || auth()->user()->isSeller())) {
            return $next($request);
        } else {
            session(['link' => url()->current()]);

            return redirect()->route('business.login');
        }
    }
}

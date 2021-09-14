<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\BusinessSetting;

class CheckoutMiddleware
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
        if (get_setting('guest_checkout_active') != 1) {
            if(Auth::check()){
                return $next($request);
            }
            else {
                session(['link' => url()->current()]);
                return redirect()->route('business.login');
            }
        }
        else{
            return $next($request);
        }
    }
}

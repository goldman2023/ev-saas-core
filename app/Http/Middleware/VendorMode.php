<?php

namespace App\Http\Middleware;

use App\Models\Shop;
use Closure;
use Auth;
use Vendor;
use Illuminate\Support\Facades\View;

class VendorMode
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
        if(Vendor::isVendorSite()) {
            /* TODO: Make this dynamic based on request domain and ID comes from domain mapping */
            $globalShop = Vendor::getVendorShop();
            $globalLayout = 'white-label';
        } else {
            $globalShop = null;
            $globalLayout = 'app';
        }

        View::share('globalShop', $globalShop);
        View::share('globalLayout', $globalLayout);

        return $next($request);

    }
}

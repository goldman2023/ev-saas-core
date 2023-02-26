<?php

namespace App\Http\Middleware;

use App\Models\Shop;
use Auth;
use Closure;
use Illuminate\Support\Facades\View;
use Vendor;

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
        if (Vendor::isVendorSite()) {
            $globalShop = Vendor::getVendorShop();
            $globalLayout = 'app';
        } else {
            $globalShop = null;
            $globalLayout = 'app';
        }

        // If request is for dashboard, always use dashboard layout!
        if ($request->is_dashboard) {
            $globalLayout = 'dashboard';
        }

        if ($request->is('wishlist') || $request->is('chat')) {
            $globalLayout = 'dashboard';
        }

        View::share('globalShop', $globalShop);
        View::share('globalLayout', apply_filters('global.layout', $globalLayout));

        return $next($request);
    }
}

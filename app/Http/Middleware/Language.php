<?php

namespace App\Http\Middleware;

use App;
use App\Tenancy\Resolvers\ExtendedDomainTenantResolver;
use Closure;
use Config;
use Session;

class Language
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

         $domain =  ExtendedDomainTenantResolver::$currentDomain;


        if(!empty(auth()->user()?->getUserMeta('locale') ?? null)) {
            $locale = auth()->user()->getUserMeta('locale');
        } else if (Session::has('locale')) {
            $locale = Session::get('locale');
        } else {
            /* TODO: Add locale by domain here */

            $locale = $domain->domain_locale;
        }


        App::setLocale($locale);
        $request->session()->put('locale', $locale);

        return $next($request);
    }
}

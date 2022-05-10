<?php

namespace App\Http\Middleware;

use App;
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
        if(!empty(auth()->user()->getUserMeta('locale'))) {
            $locale = auth()->user()->getUserMeta('locale');
        } else if (Session::has('locale')) {
            $locale = Session::get('locale');
        } else {
            $locale = env('DEFAULT_LANGUAGE', 'en');
        }

        App::setLocale($locale);
        $request->session()->put('locale', $locale);

        return $next($request);
    }
}

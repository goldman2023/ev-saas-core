<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class IsUnbanned
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->banned) {
            $redirect_to = '';
            if (auth()->user()->isAdmin() || auth()->user()->isStaff()) {
                $redirect_to = 'login';
            } else {
                $redirect_to = 'business.login';
            }

            auth()->logout();

            $message = translate('You are banned');
            flash($message);

            return redirect()->route($redirect_to);
        }

        return $next($request);
    }
}

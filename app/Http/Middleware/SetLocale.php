<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = Session::get('langue', App::getLocale());

        if (is_string($locale) && in_array($locale, ['en', 'fr'])) {
            App::setLocale($locale);
        } else {
            App::setLocale(App::getLocale());
        }

        return $next($request);
    }
}

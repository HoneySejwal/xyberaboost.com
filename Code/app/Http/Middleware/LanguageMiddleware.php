<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('app_locale')) {
            App::setLocale(session('app_locale'));
        }
        
        return $next($request);
    }
}

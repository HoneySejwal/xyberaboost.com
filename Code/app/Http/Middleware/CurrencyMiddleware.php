<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CurrencyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if a currency is set in session, if not, set default to USD
        if (!Session::has('currency')) {
            Session::put('currency', 'USD'); // Default currency
        }

        return $next($request);
    }
}

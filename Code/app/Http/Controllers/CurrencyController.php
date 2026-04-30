<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{
    public function changeCurrency($currency)
    {
        // Allowed currencies
        $availableCurrencies = ['USD', 'HKD', 'JPY'];

        if (in_array($currency, $availableCurrencies)) {
            Session::put('currency', $currency);
        }

        return redirect()->back()->with('success', __('common.currency_changed_to').' '. $currency);
    }
}

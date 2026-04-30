<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function changeLanguage($lang)
    {
        // Allowed languages
        $availableLanguages = ['en', 'ja'];

        // Check if the requested language is available
        if (in_array($lang, $availableLanguages)) {
            session(['app_locale' => $lang]);
            App::setLocale($lang);
        }

        return redirect()->back()->with('success', __('messages.language_changed'));
    }
}

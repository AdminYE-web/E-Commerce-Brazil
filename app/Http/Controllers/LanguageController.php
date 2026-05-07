<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        if (in_array($locale, config('app.supported_locales', ['pt', 'ja', 'en']), true)) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }

        return back();
    }
}

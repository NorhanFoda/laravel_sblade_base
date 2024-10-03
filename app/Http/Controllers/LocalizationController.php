<?php

namespace App\Http\Controllers;

class LocalizationController extends Controller
{
    public function __invoke()
    {
        $locale = app()->getLocale();
        $changedLocale = $locale === 'en' ? 'ar' : 'en';
        app()->setLocale($changedLocale);
        session()->put('locale', $changedLocale);
        return response()->json(['locale' => $changedLocale]);
    }
}

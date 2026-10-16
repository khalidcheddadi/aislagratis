<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->user()->locale
            ?? $request->session()->get('locale')
            ?? config('app.locale');

        if (in_array($locale, ['es', 'en', 'ar'])) {
            app()->setLocale($locale);
            setlocale(LC_TIME, $locale.'_'.strtoupper($locale).'.UTF-8');
        }

        return $next($request);
    }
}

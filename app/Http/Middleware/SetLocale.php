<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Enums\Language;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = auth()->user()?->language ?? session('locale', 'en');
        if ($locale && in_array($locale, Language::values())) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}


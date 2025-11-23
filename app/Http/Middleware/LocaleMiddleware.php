<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from session, fallback to config default
        $locale = session('locale', config('app.locale'));
        
        // Validate locale is supported
        if (in_array($locale, ['en', 'es'])) {
            App::setLocale($locale);
        }
        
        return $next($request);
    }
}

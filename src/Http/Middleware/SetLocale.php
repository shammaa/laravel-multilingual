<?php

declare(strict_types=1);

namespace Shammaa\LaravelMultilingual\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Shammaa\LaravelMultilingual\Services\LocaleManager;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    protected LocaleManager $localeManager;

    public function __construct(LocaleManager $localeManager)
    {
        $this->localeManager = $localeManager;
    }

    /**
     * Handle an incoming request
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Detect and set locale
        $locale = $this->localeManager->detectLocale();

        // Validate locale
        if (!$this->localeManager->isSupportedLocale($locale)) {
            $locale = $this->localeManager->getDefaultLocale();
        }

        // Set application locale
        app()->setLocale($locale);
        app('config')->set('app.locale', $locale);

        // Store locale in session and cookie
        $this->localeManager->storeInSession($locale);
        $this->localeManager->storeInCookie($locale);

        // Set direction for RTL languages
        $direction = $this->localeManager->isRtlLocale($locale) ? 'rtl' : 'ltr';
        view()->share('direction', $direction);
        view()->share('locale', $locale);

        return $next($request);
    }
}

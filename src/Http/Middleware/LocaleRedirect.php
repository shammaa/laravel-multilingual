<?php

declare(strict_types=1);

namespace Shammaa\LaravelMultilingual\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Shammaa\LaravelMultilingual\Services\LocaleManager;
use Symfony\Component\HttpFoundation\Response;

class LocaleRedirect
{
    protected LocaleManager $localeManager;

    public function __construct(LocaleManager $localeManager)
    {
        $this->localeManager = $localeManager;
    }

    /**
     * Handle an incoming request and redirect to localized URL if needed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip redirect for excluded routes
        $path = $request->path();
        
        if ($this->localeManager->shouldExcludeRoute($path)) {
            return $next($request);
        }

        // Get current locale from URL
        $currentLocale = $this->getLocaleFromUrl($request);
        
        // If no locale in URL and we should redirect to default
        if (!$currentLocale && ($this->localeManager->getConfig()['redirect_to_default'] ?? true)) {
            // Only redirect if this is the root path or a path without locale
            $path = $request->path();
            
            // Check if path starts with a locale
            $segments = explode('/', trim($path, '/'));
            $firstSegment = $segments[0] ?? '';
            
            // If first segment is not a locale, redirect to default locale
            if (empty($firstSegment) || !$this->localeManager->isSupportedLocale($firstSegment)) {
                $defaultLocale = $this->localeManager->getDefaultLocale();
                $localizedUrl = $this->localeManager->getLocalizedUrl($defaultLocale, $request->fullUrl());
                
                return redirect($localizedUrl, 301);
            }
        }

        return $next($request);
    }

    /**
     * Get locale from URL
     */
    protected function getLocaleFromUrl(Request $request): ?string
    {
        $path = $request->path();
        $segments = explode('/', trim($path, '/'));

        if (empty($segments)) {
            return null;
        }

        $firstSegment = $segments[0];
        
        if ($this->localeManager->isSupportedLocale($firstSegment)) {
            return $firstSegment;
        }

        // If locale is not found and we have hidden locales, check if path matches hidden locale
        $hiddenLocales = $this->localeManager->getHiddenLocales();
        
        if (!empty($hiddenLocales)) {
            // If path doesn't start with any locale, it might be a hidden locale
            // Return the first hidden locale (usually default) or check all hidden locales
            foreach ($hiddenLocales as $hiddenLocale) {
                if ($this->localeManager->isSupportedLocale($hiddenLocale)) {
                    return $hiddenLocale;
                }
            }
        }
        
        // Fallback to old behavior for backward compatibility
        if ($this->localeManager->shouldHideDefaultLocale()) {
            return $this->localeManager->getDefaultLocale();
        }

        return null;
    }
}

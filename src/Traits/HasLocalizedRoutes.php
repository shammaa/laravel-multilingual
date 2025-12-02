<?php

declare(strict_types=1);

namespace Shammaa\LaravelMultilingual\Traits;

trait HasLocalizedRoutes
{
    /**
     * Get localized route name
     */
    public function getLocalizedRouteName(string $routeName, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        
        // If route name contains locale placeholder
        if (str_contains($routeName, '{locale}')) {
            return str_replace('{locale}', $locale, $routeName);
        }
        
        // Otherwise, prepend locale prefix
        return "{$locale}.{$routeName}";
    }

    /**
     * Get localized URL for this model
     */
    public function getLocalizedUrl(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        
        // Try to find a route for this model
        if (method_exists($this, 'getRouteKeyName')) {
            $routeName = $this->getRouteKeyName() . '.show';
            
            if (route()->has($routeName)) {
                return localized_route($routeName, $this->getRouteKey(), $locale);
            }
        }
        
        // Fallback: use localized_url helper
        return localized_url($locale);
    }
}

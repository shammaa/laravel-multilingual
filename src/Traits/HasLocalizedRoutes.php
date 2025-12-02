<?php

declare(strict_types=1);

namespace Shammaa\LaravelMultilingual\Traits;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

trait HasLocalizedRoutes
{
    /**
     * Route name to use for generating localized URLs
     * Override this in your model if needed
     */
    protected ?string $localizedRouteName = null;

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
     * 
     * Automatically detects and adds locale prefix to the model's URL.
     * 
     * Example:
     * - Original: /post/my-article
     * - Localized: /en/post/my-article (or /post/my-article if locale is hidden)
     * 
     * @param string|null $locale
     * @param string|null $routeName Optional route name, auto-detected if not provided
     * @return string
     */
    public function getLocalizedUrl(?string $locale = null, ?string $routeName = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $routeName = $routeName ?? $this->getLocalizedRouteNameForModel();

        if ($routeName && route()->has($routeName)) {
            // Use route with model binding
            return localized_route($routeName, $this->getRouteKey(), $locale);
        }

        // Try to find route by model name patterns
        $modelName = $this->getModelRouteName();
        $possibleRoutes = [
            "{$modelName}.show",
            "{$modelName}s.show",
            Str::singular($modelName) . '.show',
            Str::plural($modelName) . '.show',
        ];

        foreach ($possibleRoutes as $possibleRoute) {
            if (route()->has($possibleRoute)) {
                return localized_route($possibleRoute, $this->getRouteKey(), $locale);
            }
        }

        // Fallback: get current URL and localize it
        if (request()->route()) {
            $currentUrl = url()->current();
            return localized_url($locale, $currentUrl);
        }

        // Last fallback
        return localized_url($locale);
    }

    /**
     * Get all localized URLs for this model (all languages)
     * 
     * @return array Array of [locale => url]
     */
    public function getAllLocalizedUrls(?string $routeName = null): array
    {
        $urls = [];
        $locales = \Shammaa\LaravelMultilingual\Facades\Multilingual::getSupportedLocales();

        foreach ($locales as $locale) {
            $urls[$locale] = $this->getLocalizedUrl($locale, $routeName);
        }

        return $urls;
    }

    /**
     * Get localized route name for this model
     */
    protected function getLocalizedRouteNameForModel(): ?string
    {
        // Use custom route name if set
        if ($this->localizedRouteName) {
            return $this->localizedRouteName;
        }

        // Try to get route name from model name
        $modelName = $this->getModelRouteName();
        
        // Try common route name patterns
        $possibleRoutes = [
            "{$modelName}.show",
            "{$modelName}s.show",
            Str::singular($modelName) . '.show',
            Str::plural($modelName) . '.show',
        ];

        foreach ($possibleRoutes as $route) {
            if (route()->has($route)) {
                return $route;
            }
        }

        return null;
    }

    /**
     * Get model name for route generation
     */
    protected function getModelRouteName(): string
    {
        $className = class_basename($this);
        return Str::kebab(Str::plural($className));
    }

    /**
     * Set custom route name for localized URLs
     */
    public function setLocalizedRouteName(string $routeName): self
    {
        $this->localizedRouteName = $routeName;
        return $this;
    }
}

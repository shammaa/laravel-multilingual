<?php

declare(strict_types=1);

use Shammaa\LaravelMultilingual\Facades\Multilingual;

if (!function_exists('localized_url')) {
    /**
     * Get localized URL for a given locale
     *
     * @param string $locale
     * @param string|null $url
     * @return string
     */
    function localized_url(string $locale, ?string $url = null): string
    {
        return Multilingual::getLocalizedUrl($locale, $url);
    }
}

if (!function_exists('all_localized_urls')) {
    /**
     * Get all localized URLs for current route
     *
     * @param string|null $url
     * @return array
     */
    function all_localized_urls(?string $url = null): array
    {
        return Multilingual::getAllLocalizedUrls($url);
    }
}

if (!function_exists('switch_locale')) {
    /**
     * Switch to a different locale
     *
     * @param string $locale
     * @return string The localized URL for the current route
     */
    function switch_locale(string $locale): string
    {
        if (!Multilingual::isSupportedLocale($locale)) {
            $locale = Multilingual::getDefaultLocale();
        }

        Multilingual::storeInSession($locale);
        Multilingual::storeInCookie($locale);

        return localized_url($locale);
    }
}

if (!function_exists('is_rtl')) {
    /**
     * Check if current locale is RTL
     *
     * @return bool
     */
    function is_rtl(): bool
    {
        return Multilingual::isRtlLocale(app()->getLocale());
    }
}

if (!function_exists('locale_name')) {
    /**
     * Get human-readable name for a locale
     *
     * @param string|null $locale
     * @return string
     */
    function locale_name(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        return Multilingual::getLocaleName($locale);
    }
}

if (!function_exists('locale_flag')) {
    /**
     * Get flag emoji for a locale
     *
     * @param string|null $locale
     * @return string|null
     */
    function locale_flag(?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        return Multilingual::getLocaleFlag($locale);
    }
}

if (!function_exists('localized_route')) {
    /**
     * Generate a localized route URL
     *
     * @param string $name
     * @param mixed $parameters
     * @param string|null $locale
     * @param bool $absolute
     * @return string
     */
    function localized_route(string $name, mixed $parameters = [], ?string $locale = null, bool $absolute = true): string
    {
        $locale = $locale ?? app()->getLocale();
        $url = route($name, $parameters, $absolute);
        
        return localized_url($locale, $url);
    }
}

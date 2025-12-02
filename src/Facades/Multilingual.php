<?php

declare(strict_types=1);

namespace Shammaa\LaravelMultilingual\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getSupportedLocales()
 * @method static string getDefaultLocale()
 * @method static string getFallbackLocale()
 * @method static bool isSupportedLocale(string $locale)
 * @method static bool shouldHideDefaultLocale()
 * @method static bool shouldHideLocale(string $locale)
 * @method static array getHiddenLocales()
 * @method static string getLocaleName(string $locale)
 * @method static string getLocaleNativeName(string $locale)
 * @method static string|null getLocaleFlag(string $locale)
 * @method static bool isRtlLocale(string $locale)
 * @method static string detectLocale()
 * @method static void storeInSession(string $locale)
 * @method static void storeInCookie(string $locale)
 * @method static string getLocalizedUrl(string $locale, ?string $url = null)
 * @method static array getAllLocalizedUrls(?string $url = null)
 * @method static bool shouldExcludeRoute(string $path)
 * @method static array getAvailableLocales()
 *
 * @see \Shammaa\LaravelMultilingual\Services\LocaleManager
 */
class Multilingual extends Facade
{
    /**
     * Get the registered name of the component
     */
    protected static function getFacadeAccessor(): string
    {
        return \Shammaa\LaravelMultilingual\Services\LocaleManager::class;
    }
}

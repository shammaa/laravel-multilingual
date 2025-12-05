<?php

declare(strict_types=1);

namespace Shammaa\LaravelMultilingual\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Shammaa\LaravelMultilingual\Exceptions\InvalidLocaleException;
use Shammaa\LaravelMultilingual\Services\LocaleValidator;

class LocaleManager
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get configuration array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Get all supported locales
     */
    public function getSupportedLocales(): array
    {
        return $this->config['supported_locales'] ?? ['ar', 'en'];
    }

    /**
     * Get default locale
     */
    public function getDefaultLocale(): string
    {
        return $this->config['default_locale'] ?? 'ar';
    }

    /**
     * Get fallback locale
     */
    public function getFallbackLocale(): string
    {
        return $this->config['fallback_locale'] ?? 'en';
    }

    /**
     * Check if locale is supported.
     *
     * @param string $locale The locale to check
     * @return bool
     */
    public function isSupportedLocale(string $locale): bool
    {
        try {
            return LocaleValidator::validateLocale($locale, false);
        } catch (\Exception $e) {
            Log::warning('Locale validation failed', [
                'locale' => $locale,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Check if default locale should be hidden in URL
     */
    public function shouldHideDefaultLocale(): bool
    {
        return $this->config['hide_default_locale'] ?? true;
    }

    /**
     * Check if a specific locale should be hidden in URL
     */
    public function shouldHideLocale(string $locale): bool
    {
        // First check hidden_locales array (takes priority)
        $hiddenLocales = $this->config['hidden_locales'] ?? [];
        
        if (!empty($hiddenLocales)) {
            return in_array($locale, $hiddenLocales, true);
        }
        
        // Fallback to hide_default_locale setting for backward compatibility
        if ($this->shouldHideDefaultLocale()) {
            return $locale === $this->getDefaultLocale();
        }
        
        return false;
    }

    /**
     * Get list of hidden locales
     */
    public function getHiddenLocales(): array
    {
        $hiddenLocales = $this->config['hidden_locales'] ?? [];
        
        if (!empty($hiddenLocales)) {
            return $hiddenLocales;
        }
        
        // Fallback to default locale if hide_default_locale is enabled
        if ($this->shouldHideDefaultLocale()) {
            return [$this->getDefaultLocale()];
        }
        
        return [];
    }

    /**
     * Get locale name (human-readable)
     */
    public function getLocaleName(string $locale): string
    {
        // First try available_locales
        $available = $this->config['available_locales'] ?? [];
        if (isset($available[$locale])) {
            return $available[$locale]['name'] ?? $available[$locale]['native'] ?? strtoupper($locale);
        }
        
        // Fallback to locale_names
        $names = $this->config['locale_names'] ?? [];
        if (isset($names[$locale])) {
            return $names[$locale];
        }
        
        return strtoupper($locale);
    }

    /**
     * Get locale flag emoji
     */
    public function getLocaleFlag(string $locale): ?string
    {
        // First try available_locales
        $available = $this->config['available_locales'] ?? [];
        if (isset($available[$locale])) {
            return $available[$locale]['flag'] ?? null;
        }
        
        // Fallback to locale_flags
        $flags = $this->config['locale_flags'] ?? [];
        return $flags[$locale] ?? null;
    }

    /**
     * Get locale native name
     */
    public function getLocaleNativeName(string $locale): string
    {
        $available = $this->config['available_locales'] ?? [];
        if (isset($available[$locale])) {
            return $available[$locale]['native'] ?? $this->getLocaleName($locale);
        }
        
        return $this->getLocaleName($locale);
    }

    /**
     * Get all available locales (not just supported)
     */
    public function getAvailableLocales(): array
    {
        return $this->config['available_locales'] ?? [];
    }

    /**
     * Check if locale is RTL
     */
    public function isRtlLocale(string $locale): bool
    {
        $rtlLocales = $this->config['rtl_locales'] ?? [];
        return in_array($locale, $rtlLocales, true);
    }

    /**
     * Detect locale from request using configured methods
     */
    public function detectLocale(): string
    {
        $methods = $this->config['detection_methods'] ?? ['url', 'session', 'cookie', 'browser', 'default'];
        
        foreach ($methods as $method) {
            $locale = match ($method) {
                'url' => $this->detectFromUrl(),
                'session' => $this->detectFromSession(),
                'cookie' => $this->detectFromCookie(),
                'browser' => $this->detectFromBrowser(),
                'default' => $this->getDefaultLocale(),
                default => null,
            };

            if ($locale && $this->isSupportedLocale($locale)) {
                return $locale;
            }
        }

        return $this->getDefaultLocale();
    }

    /**
     * Detect locale from URL
     */
    protected function detectFromUrl(): ?string
    {
        $path = Request::path();
        $segments = explode('/', trim($path, '/'));

        if (empty($segments)) {
            return null;
        }

        $firstSegment = $segments[0];
        
        // Check if first segment is a valid locale
        if ($this->isSupportedLocale($firstSegment)) {
            // If locale is hidden, it won't be in URL, but we detected it
            if ($this->shouldHideLocale($firstSegment)) {
                return $firstSegment; // Still return it as detected
            }
            return $firstSegment;
        }

        // If first segment is not a locale, check if we have hidden locales
        $hiddenLocales = $this->getHiddenLocales();
        if (!empty($hiddenLocales)) {
            // If path doesn't start with a locale, it might be a hidden locale
            // Return the first hidden locale (usually default) or try to detect from context
            return $hiddenLocales[0] ?? null;
        }

        // Fallback to old behavior for backward compatibility
        if ($this->shouldHideDefaultLocale()) {
            return $this->getDefaultLocale();
        }

        return null;
    }

    /**
     * Detect locale from session
     */
    protected function detectFromSession(): ?string
    {
        if (!session()->isStarted()) {
            return null;
        }

        $key = $this->config['session']['key'] ?? 'locale';
        return session($key);
    }

    /**
     * Detect locale from cookie
     */
    protected function detectFromCookie(): ?string
    {
        if (!$this->config['cookie']['enabled'] ?? true) {
            return null;
        }

        $name = $this->config['cookie']['name'] ?? 'locale';
        return Request::cookie($name);
    }

    /**
     * Detect locale from browser Accept-Language header
     */
    protected function detectFromBrowser(): ?string
    {
        $acceptLanguage = Request::server('HTTP_ACCEPT_LANGUAGE');
        
        if (!$acceptLanguage) {
            return null;
        }

        // Parse Accept-Language header
        $languages = [];
        preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)\s*(?:;\s*q\s*=\s*(1|0\.\d+))?/i', $acceptLanguage, $matches);

        if (empty($matches[1])) {
            return null;
        }

        // Create array with quality scores
        foreach ($matches[1] as $key => $lang) {
            $quality = $matches[2][$key] ?? '1';
            $lang = strtolower(substr($lang, 0, 2)); // Get primary language code
            $languages[$lang] = (float) $quality;
        }

        // Sort by quality
        arsort($languages);

        // Find first supported locale
        foreach (array_keys($languages) as $lang) {
            if ($this->isSupportedLocale($lang)) {
                return $lang;
            }
        }

        return null;
    }

    /**
     * Store locale in session
     */
    public function storeInSession(string $locale): void
    {
        if (!session()->isStarted()) {
            return;
        }

        $key = $this->config['session']['key'] ?? 'locale';
        session([$key => $locale]);
    }

    /**
     * Store locale in cookie
     */
    public function storeInCookie(string $locale): void
    {
        if (!($this->config['cookie']['enabled'] ?? true)) {
            return;
        }

        $name = $this->config['cookie']['name'] ?? 'locale';
        $lifetime = ($this->config['cookie']['lifetime'] ?? 525600) * 60; // Convert to seconds
        $path = $this->config['cookie']['path'] ?? '/';
        $domain = $this->config['cookie']['domain'] ?? null;
        $secure = $this->config['cookie']['secure'] ?? false;
        $sameSite = $this->config['cookie']['same_site'] ?? 'lax';

        cookie()->queue($name, $locale, $lifetime, $path, $domain, $secure, false, $sameSite);
    }

    /**
     * Get localized URL for a given locale
     */
    public function getLocalizedUrl(string $locale, ?string $url = null): string
    {
        if (!$this->isSupportedLocale($locale)) {
            $locale = $this->getDefaultLocale();
        }

        $url = $url ?? Request::fullUrl();
        $currentLocale = app()->getLocale();

        // Use cache if enabled
        if ($this->isCacheEnabled() && $url === Request::fullUrl()) {
            $cacheKey = $this->getCacheKey("url:{$locale}:" . md5($url));
            
            return Cache::remember($cacheKey, $this->getCacheTtl(), function () use ($locale, $url, $currentLocale) {
                return $this->buildLocalizedUrl($locale, $url, $currentLocale);
            });
        }

        return $this->buildLocalizedUrl($locale, $url, $currentLocale);
    }

    /**
     * Build localized URL
     */
    protected function buildLocalizedUrl(string $locale, string $url, string $currentLocale): string
    {
        // Parse URL
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'] ?? '/';
        
        // Remove current locale from path if exists
        $segments = explode('/', trim($path, '/'));
        
        if (!empty($segments) && $this->isSupportedLocale($segments[0])) {
            array_shift($segments);
        }

        $newPath = '/' . implode('/', $segments);
        $newPath = rtrim($newPath, '/') ?: '/';

        // Add new locale prefix if needed
        if ($this->shouldHideLocale($locale)) {
            // Hidden locale: no prefix
            $localizedPath = $newPath;
        } else {
            // Visible locale: add prefix
            $localizedPath = '/' . $locale . $newPath;
        }

        // Reconstruct URL
        $scheme = $parsedUrl['scheme'] ?? (Request::secure() ? 'https' : 'http');
        $host = $parsedUrl['host'] ?? Request::getHost();
        $port = isset($parsedUrl['port']) ? ':' . $parsedUrl['port'] : '';
        $query = isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '';
        $fragment = isset($parsedUrl['fragment']) ? '#' . $parsedUrl['fragment'] : '';

        return $scheme . '://' . $host . $port . $localizedPath . $query . $fragment;
    }

    /**
     * Get all localized URLs for current route
     */
    public function getAllLocalizedUrls(?string $url = null): array
    {
        $urls = [];
        
        foreach ($this->getSupportedLocales() as $locale) {
            $urls[$locale] = $this->getLocalizedUrl($locale, $url);
        }

        return $urls;
    }

    /**
     * Check if route should be excluded from localization
     */
    public function shouldExcludeRoute(string $path): bool
    {
        $excludedRoutes = $this->config['excluded_routes'] ?? [];

        foreach ($excludedRoutes as $pattern) {
            if (fnmatch($pattern, $path)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get cache key for a given operation
     */
    protected function getCacheKey(string $key): string
    {
        $prefix = $this->config['cache']['prefix'] ?? 'multilingual';
        return "{$prefix}:{$key}";
    }

    /**
     * Check if cache is enabled
     */
    protected function isCacheEnabled(): bool
    {
        return $this->config['cache']['enabled'] ?? true;
    }

    /**
     * Get cache TTL
     */
    protected function getCacheTtl(): int
    {
        return $this->config['cache']['ttl'] ?? 86400;
    }
}

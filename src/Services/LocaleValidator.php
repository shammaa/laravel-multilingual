<?php

declare(strict_types=1);

namespace Shammaa\LaravelMultilingual\Services;

use Shammaa\LaravelMultilingual\Exceptions\InvalidLocaleException;

class LocaleValidator
{
    /**
     * Validate locale.
     *
     * @param string $locale The locale to validate
     * @param bool $throwException Whether to throw exception on invalid locale
     * @return bool
     * @throws InvalidLocaleException
     */
    public static function validateLocale(string $locale, bool $throwException = true): bool
    {
        $supportedLocales = config('multilingual.supported_locales', config('multilingual.locales', ['ar', 'en']));
        
        if (!in_array($locale, $supportedLocales, true)) {
            if ($throwException) {
                throw new InvalidLocaleException($locale);
            }
            return false;
        }

        return true;
    }
}


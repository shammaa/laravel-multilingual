<?php

/*
|--------------------------------------------------------------------------
| Multilingual Configuration
|--------------------------------------------------------------------------
|
| This configuration file contains all settings for the multilingual package.
| 
| QUICK START:
| 1. Choose your supported locales in 'supported_locales' below
| 2. All available languages are listed in 'available_locales' section
| 3. The middleware will automatically work with your chosen locales
| 4. Names and flags are auto-populated from 'available_locales'
|
*/

return [
    /*
    |--------------------------------------------------------------------------
    | Supported Locales
    |--------------------------------------------------------------------------
    |
    | List of all supported locales in your application.
    | Each locale should be a valid ISO 639-1 language code (e.g., 'en', 'ar', 'fr').
    |
    | IMPORTANT: Choose locales from 'available_locales' below.
    | All available languages are listed in the 'available_locales' section.
    |
    | Example: ['ar', 'en', 'fr', 'es', 'de']
    |
    | You can also set this via .env file:
    | MULTILINGUAL_LOCALES=ar,en,fr,es,de
    |
    | The middleware will automatically work with any locale you add here!
    |
    */
    'supported_locales' => env('MULTILINGUAL_LOCALES') 
        ? explode(',', env('MULTILINGUAL_LOCALES')) 
        : ['ar', 'en'],

    /*
    |--------------------------------------------------------------------------
    | Default Locale
    |--------------------------------------------------------------------------
    |
    | The default locale that will be used if no locale is specified in the URL.
    | This should be one of the supported locales.
    |
    */
    'default_locale' => env('MULTILINGUAL_DEFAULT_LOCALE', 'ar'),

    /*
    |--------------------------------------------------------------------------
    | Hide Default Locale in URL (DEPRECATED - Use hidden_locales instead)
    |--------------------------------------------------------------------------
    |
    | When enabled, the default locale will not appear in the URL.
    | For example, if default is 'ar' and this is true:
    | - /ar/about -> /about
    | - /en/about -> /en/about
    |
    | DEPRECATED: Use 'hidden_locales' array below for more flexibility.
    | This setting is kept for backward compatibility.
    |
    */
    'hide_default_locale' => env('MULTILINGUAL_HIDE_DEFAULT', true),

    /*
    |--------------------------------------------------------------------------
    | Hidden Locales in URL
    |--------------------------------------------------------------------------
    |
    | List of locales that should NOT appear in the URL.
    | You can hide any language you want, not just the default one.
    |
    | Examples:
    | - Hide default locale only: ['ar'] 
    | - Hide multiple locales: ['ar', 'en']
    | - Show all locales: [] (empty array)
    | - Hide all except one: ['ar', 'fr', 'de'] (if supported_locales is ['ar', 'en', 'fr', 'de'])
    |
    | If empty array and hide_default_locale is true, only default locale will be hidden.
    | If you set locales here, this takes priority over hide_default_locale.
    |
    */
    'hidden_locales' => env('MULTILINGUAL_HIDDEN_LOCALES') 
        ? explode(',', env('MULTILINGUAL_HIDDEN_LOCALES')) 
        : [],

    /*
    |--------------------------------------------------------------------------
    | Available Locales - Complete List
    |--------------------------------------------------------------------------
    |
    | All available locales with their names and flags.
    | You only need to add the locale codes you want to 'supported_locales' above.
    | This list is comprehensive and includes all major languages.
    |
    */
    'available_locales' => [
        // Middle East & Asia
        'ar' => ['name' => 'العربية', 'flag' => '🇸🇾', 'native' => 'العربية'],
        'fa' => ['name' => 'Persian', 'flag' => '🇮🇷', 'native' => 'فارسی'],
        'ur' => ['name' => 'Urdu', 'flag' => '🇵🇰', 'native' => 'اردو'],
        'tr' => ['name' => 'Turkish', 'flag' => '🇹🇷', 'native' => 'Türkçe'],
        'ku' => ['name' => 'Kurdish', 'flag' => '🇮🇶', 'native' => 'Kurdî'],
        'ps' => ['name' => 'Pashto', 'flag' => '🇦🇫', 'native' => 'پښتو'],
        'hi' => ['name' => 'Hindi', 'flag' => '🇮🇳', 'native' => 'हिन्दी'],
        'bn' => ['name' => 'Bengali', 'flag' => '🇧🇩', 'native' => 'বাংলা'],
        'ta' => ['name' => 'Tamil', 'flag' => '🇮🇳', 'native' => 'தமிழ்'],
        'te' => ['name' => 'Telugu', 'flag' => '🇮🇳', 'native' => 'తెలుగు'],
        'mr' => ['name' => 'Marathi', 'flag' => '🇮🇳', 'native' => 'मराठी'],
        'th' => ['name' => 'Thai', 'flag' => '🇹🇭', 'native' => 'ไทย'],
        'vi' => ['name' => 'Vietnamese', 'flag' => '🇻🇳', 'native' => 'Tiếng Việt'],
        'id' => ['name' => 'Indonesian', 'flag' => '🇮🇩', 'native' => 'Bahasa Indonesia'],
        'ms' => ['name' => 'Malay', 'flag' => '🇲🇾', 'native' => 'Bahasa Melayu'],
        'fil' => ['name' => 'Filipino', 'flag' => '🇵🇭', 'native' => 'Filipino'],
        'zh' => ['name' => 'Chinese', 'flag' => '🇨🇳', 'native' => '中文'],
        'zh-TW' => ['name' => 'Traditional Chinese', 'flag' => '🇹🇼', 'native' => '繁體中文'],
        'ja' => ['name' => 'Japanese', 'flag' => '🇯🇵', 'native' => '日本語'],
        'ko' => ['name' => 'Korean', 'flag' => '🇰🇷', 'native' => '한국어'],
        
        // European Languages
        'en' => ['name' => 'English', 'flag' => '🇬🇧', 'native' => 'English'],
        'en-US' => ['name' => 'English (US)', 'flag' => '🇺🇸', 'native' => 'English'],
        'en-GB' => ['name' => 'English (UK)', 'flag' => '🇬🇧', 'native' => 'English'],
        'fr' => ['name' => 'French', 'flag' => '🇫🇷', 'native' => 'Français'],
        'es' => ['name' => 'Spanish', 'flag' => '🇪🇸', 'native' => 'Español'],
        'es-MX' => ['name' => 'Spanish (Mexico)', 'flag' => '🇲🇽', 'native' => 'Español'],
        'de' => ['name' => 'German', 'flag' => '🇩🇪', 'native' => 'Deutsch'],
        'it' => ['name' => 'Italian', 'flag' => '🇮🇹', 'native' => 'Italiano'],
        'pt' => ['name' => 'Portuguese', 'flag' => '🇵🇹', 'native' => 'Português'],
        'pt-BR' => ['name' => 'Portuguese (Brazil)', 'flag' => '🇧🇷', 'native' => 'Português'],
        'ru' => ['name' => 'Russian', 'flag' => '🇷🇺', 'native' => 'Русский'],
        'pl' => ['name' => 'Polish', 'flag' => '🇵🇱', 'native' => 'Polski'],
        'nl' => ['name' => 'Dutch', 'flag' => '🇳🇱', 'native' => 'Nederlands'],
        'sv' => ['name' => 'Swedish', 'flag' => '🇸🇪', 'native' => 'Svenska'],
        'no' => ['name' => 'Norwegian', 'flag' => '🇳🇴', 'native' => 'Norsk'],
        'da' => ['name' => 'Danish', 'flag' => '🇩🇰', 'native' => 'Dansk'],
        'fi' => ['name' => 'Finnish', 'flag' => '🇫🇮', 'native' => 'Suomi'],
        'el' => ['name' => 'Greek', 'flag' => '🇬🇷', 'native' => 'Ελληνικά'],
        'cs' => ['name' => 'Czech', 'flag' => '🇨🇿', 'native' => 'Čeština'],
        'sk' => ['name' => 'Slovak', 'flag' => '🇸🇰', 'native' => 'Slovenčina'],
        'hu' => ['name' => 'Hungarian', 'flag' => '🇭🇺', 'native' => 'Magyar'],
        'ro' => ['name' => 'Romanian', 'flag' => '🇷🇴', 'native' => 'Română'],
        'bg' => ['name' => 'Bulgarian', 'flag' => '🇧🇬', 'native' => 'Български'],
        'hr' => ['name' => 'Croatian', 'flag' => '🇭🇷', 'native' => 'Hrvatski'],
        'sr' => ['name' => 'Serbian', 'flag' => '🇷🇸', 'native' => 'Српски'],
        'sl' => ['name' => 'Slovenian', 'flag' => '🇸🇮', 'native' => 'Slovenščina'],
        'uk' => ['name' => 'Ukrainian', 'flag' => '🇺🇦', 'native' => 'Українська'],
        'be' => ['name' => 'Belarusian', 'flag' => '🇧🇾', 'native' => 'Беларуская'],
        'lt' => ['name' => 'Lithuanian', 'flag' => '🇱🇹', 'native' => 'Lietuvių'],
        'lv' => ['name' => 'Latvian', 'flag' => '🇱🇻', 'native' => 'Latviešu'],
        'et' => ['name' => 'Estonian', 'flag' => '🇪🇪', 'native' => 'Eesti'],
        'ga' => ['name' => 'Irish', 'flag' => '🇮🇪', 'native' => 'Gaeilge'],
        'cy' => ['name' => 'Welsh', 'flag' => '🇬🇧', 'native' => 'Cymraeg'],
        'mt' => ['name' => 'Maltese', 'flag' => '🇲🇹', 'native' => 'Malti'],
        'is' => ['name' => 'Icelandic', 'flag' => '🇮🇸', 'native' => 'Íslenska'],
        
        // African Languages
        'sw' => ['name' => 'Swahili', 'flag' => '🇰🇪', 'native' => 'Kiswahili'],
        'af' => ['name' => 'Afrikaans', 'flag' => '🇿🇦', 'native' => 'Afrikaans'],
        'am' => ['name' => 'Amharic', 'flag' => '🇪🇹', 'native' => 'አማርኛ'],
        'zu' => ['name' => 'Zulu', 'flag' => '🇿🇦', 'native' => 'isiZulu'],
        'xh' => ['name' => 'Xhosa', 'flag' => '🇿🇦', 'native' => 'isiXhosa'],
        'yo' => ['name' => 'Yoruba', 'flag' => '🇳🇬', 'native' => 'Yorùbá'],
        'ig' => ['name' => 'Igbo', 'flag' => '🇳🇬', 'native' => 'Igbo'],
        'ha' => ['name' => 'Hausa', 'flag' => '🇳🇬', 'native' => 'Hausa'],
        
        // Other Languages
        'ca' => ['name' => 'Catalan', 'flag' => '🇪🇸', 'native' => 'Català'],
        'eu' => ['name' => 'Basque', 'flag' => '🇪🇸', 'native' => 'Euskara'],
        'gl' => ['name' => 'Galician', 'flag' => '🇪🇸', 'native' => 'Galego'],
        'br' => ['name' => 'Breton', 'flag' => '🇫🇷', 'native' => 'Brezhoneg'],
        'lb' => ['name' => 'Luxembourgish', 'flag' => '🇱🇺', 'native' => 'Lëtzebuergesch'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Locale Names (Auto-generated from available_locales)
    |--------------------------------------------------------------------------
    |
    | Human-readable names for each locale (used in language switcher, etc.)
    | This is automatically populated from available_locales above.
    | You can override individual entries here if needed.
    |
    */
    'locale_names' => [
        // This will be auto-populated, but you can override here
        'ar' => 'العربية',
        'en' => 'English',
        'fr' => 'Français',
        'es' => 'Español',
        'de' => 'Deutsch',
        'it' => 'Italiano',
        'pt' => 'Português',
        'ru' => 'Русский',
        'zh' => '中文',
        'ja' => '日本語',
    ],

    /*
    |--------------------------------------------------------------------------
    | Locale Flags (Auto-generated from available_locales)
    |--------------------------------------------------------------------------
    |
    | Flag icons for each locale (can be used in language switcher UI)
    | This is automatically populated from available_locales above.
    | You can override individual entries here if needed.
    |
    */
    'locale_flags' => [
        // This will be auto-populated, but you can override here
        'ar' => '🇸🇾',
        'en' => '🇬🇧',
        'fr' => '🇫🇷',
        'es' => '🇪🇸',
        'de' => '🇩🇪',
        'it' => '🇮🇹',
        'pt' => '🇵🇹',
        'ru' => '🇷🇺',
        'zh' => '🇨🇳',
        'ja' => '🇯🇵',
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Prefix Pattern
    |--------------------------------------------------------------------------
    |
    | The pattern used for locale in routes. Can be:
    | - 'prefix' : /{locale}/...
    | - 'subdomain' : {locale}.example.com
    | - 'domain' : example-{locale}.com
    |
    | Currently only 'prefix' is supported (most common and SEO-friendly).
    |
    */
    'route_pattern' => env('MULTILINGUAL_ROUTE_PATTERN', 'prefix'),

    /*
    |--------------------------------------------------------------------------
    | Locale Detection Methods
    |--------------------------------------------------------------------------
    |
    | Order of methods to detect the user's preferred locale:
    | 1. 'url' - From URL segment
    | 2. 'session' - From session storage
    | 3. 'cookie' - From cookie
    | 4. 'browser' - From Accept-Language header
    | 5. 'default' - Fall back to default locale
    |
    */
    'detection_methods' => [
        'url',
        'session',
        'cookie',
        'browser',
        'default',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Cache settings for improved performance. The locale routes and
    | translations are cached to avoid repeated processing.
    |
    */
    'cache' => [
        'enabled' => env('MULTILINGUAL_CACHE_ENABLED', true),
        'prefix' => env('MULTILINGUAL_CACHE_PREFIX', 'multilingual'),
        'ttl' => env('MULTILINGUAL_CACHE_TTL', 86400), // 24 hours
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for storing locale in session
    |
    */
    'session' => [
        'key' => env('MULTILINGUAL_SESSION_KEY', 'locale'),
        'lifetime' => env('MULTILINGUAL_SESSION_LIFETIME', 120), // minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Cookie Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for storing locale in cookie
    |
    */
    'cookie' => [
        'enabled' => env('MULTILINGUAL_COOKIE_ENABLED', true),
        'name' => env('MULTILINGUAL_COOKIE_NAME', 'locale'),
        'lifetime' => env('MULTILINGUAL_COOKIE_LIFETIME', 525600), // 1 year in minutes
        'domain' => env('MULTILINGUAL_COOKIE_DOMAIN', null),
        'path' => env('MULTILINGUAL_COOKIE_PATH', '/'),
        'secure' => env('MULTILINGUAL_COOKIE_SECURE', false),
        'same_site' => env('MULTILINGUAL_COOKIE_SAME_SITE', 'lax'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Middleware
    |--------------------------------------------------------------------------
    |
    | Middleware to apply to localized routes. The SetLocale middleware
    | is automatically added, but you can add additional middleware here.
    |
    */
    'route_middleware' => [],

    /*
    |--------------------------------------------------------------------------
    | Excluded Routes
    |--------------------------------------------------------------------------
    |
    | Route patterns that should NOT be localized (e.g., API routes, admin routes).
    | These routes will be excluded from locale prefixing.
    |
    */
    'excluded_routes' => [
        'api/*',
        'admin/*',
        'auth/*',
        'storage/*',
        'img/*',
        'sitemap.xml',
        'robots.txt',
    ],

    /*
    |--------------------------------------------------------------------------
    | Redirect to Default Locale
    |--------------------------------------------------------------------------
    |
    | When enabled, requests to the root URL (/) will redirect to the default
    | locale (with or without prefix based on hide_default_locale setting).
    |
    */
    'redirect_to_default' => env('MULTILINGUAL_REDIRECT_TO_DEFAULT', true),

    /*
    |--------------------------------------------------------------------------
    | Fallback Locale
    |--------------------------------------------------------------------------
    |
    | If a translation is missing for the current locale, fall back to this locale.
    | Usually the same as default_locale, but can be different.
    |
    */
    'fallback_locale' => env('MULTILINGUAL_FALLBACK_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | RTL Support
    |--------------------------------------------------------------------------
    |
    | Right-to-left languages configuration
    |
    */
    'rtl_locales' => [
        'ar',
        'fa',
        'ur',
    ],
];

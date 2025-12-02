# Laravel Multilingual

A high-performance multilingual package for Laravel with optimized URL localization support. Built with performance in mind, this package provides seamless language switching without impacting your site's speed.

## Features

- 🚀 **High Performance** - Optimized with caching and minimal overhead
- 🌍 **Multiple Languages** - Support for unlimited languages (60+ languages available)
- 🔗 **Flexible URLs** - Hide/Show any locale from URL (not just default)
- 🎯 **Smart Detection** - Automatic locale detection from URL, session, cookie, or browser
- 🔄 **Easy Switching** - Simple language switching helpers
- 📱 **RTL Support** - Built-in support for right-to-left languages
- 🛣️ **Route Macros** - Easy localized route registration

## Installation

```bash
composer require shammaa/laravel-multilingual
```

Publish configuration:

```bash
php artisan vendor:publish --tag=multilingual-config
```

## Quick Start

### 1. Configure Languages

Edit `config/multilingual.php` or use `.env`:

```php
// config/multilingual.php
'supported_locales' => ['ar', 'en', 'fr'],
'default_locale' => 'ar',
```

Or via `.env`:
```env
MULTILINGUAL_LOCALES=ar,en,fr
```

**Available Languages:** The package includes 60+ languages (Arabic, English, French, Spanish, German, Chinese, Japanese, Turkish, Russian, and many more). Just choose from them!

### 2. Add Middleware

Add to `app/Http/Kernel.php`:

```php
protected $middlewareGroups = [
    'web' => [
        // ... other middleware
        \Shammaa\LaravelMultilingual\Http\Middleware\SetLocale::class,
    ],
];
```

**That's it!** The middleware automatically:
- ✅ Detects locale from URL, session, cookie, or browser
- ✅ Sets locale for your entire application
- ✅ Works on **all routes automatically**

### 3. Register Localized Routes

```php
Route::localized(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
    
    Route::get('/about', function () {
        return view('about');
    })->name('about');
    
    Route::get('/posts/{post}', [PostController::class, 'show'])
        ->name('posts.show');
});
```

This automatically creates routes for all locales:
- `/` (default locale - hidden)
- `/en` (English)
- `/en/about` (English)
- `/about` (default locale)
- `/posts/1` (default locale)
- `/en/posts/1` (English)

### 4. Language Switcher

**Using Blade Component:**

```blade
<x-multilingual::language-switcher />
```

**Or manually:**

```blade
@foreach(Multilingual::getSupportedLocales() as $locale)
    <a href="{{ localized_url($locale) }}" 
       class="{{ app()->getLocale() === $locale ? 'active' : '' }}">
        {{ locale_flag($locale) }} {{ locale_name($locale) }}
    </a>
@endforeach
```

**For specific routes:**

```blade
@foreach(Multilingual::getSupportedLocales() as $locale)
    <a href="{{ localized_route('posts.show', $post, $locale) }}">
        {{ locale_flag($locale) }} {{ locale_name($locale) }}
    </a>
@endforeach
```

## Usage

### Helper Functions

```php
// Get localized URL for current route
localized_url('en')                    // Current URL in English

// Get localized URL for specific path
localized_url('en', '/about')          // /en/about

// Get all localized URLs
all_localized_urls()                   // All languages for current URL

// Switch locale and get URL
switch_locale('en')                    // Switch and get localized URL

// Check if current locale is RTL
is_rtl()                               // Returns true/false

// Get locale information
locale_name('ar')                      // Returns: العربية
locale_flag('ar')                      // Returns: 🇸🇾

// Generate localized route
localized_route('posts.show', $post, 'en')  // /en/posts/1
```

### Working with Models

**No model modification needed!** Just use helper functions with your existing models:

```php
// In your Blade template
<a href="{{ localized_route('posts.show', $post, 'en') }}">
    Read in English
</a>

// Language switcher for a post
@foreach(Multilingual::getSupportedLocales() as $locale)
    <a href="{{ localized_route('posts.show', $post, $locale) }}"
       class="{{ app()->getLocale() === $locale ? 'active' : '' }}">
        {{ locale_flag($locale) }} {{ locale_name($locale) }}
    </a>
@endforeach
```

## Configuration

### Hiding Locales from URL

Control which locales appear in URLs:

**Example 1: Hide default locale only (default behavior)**
```php
'hidden_locales' => [],
'hide_default_locale' => true,
// Results: /about (Arabic - hidden), /en/about (English)
```

**Example 2: Hide multiple locales**
```php
'hidden_locales' => ['ar', 'en'],
// Results: /about (hidden), /fr/about (French shown)
```

**Example 3: Show all locales**
```php
'hidden_locales' => [],
'hide_default_locale' => false,
// Results: /ar/about, /en/about, /fr/about
```

**Via .env:**
```env
MULTILINGUAL_HIDDEN_LOCALES=ar,en
MULTILINGUAL_HIDE_DEFAULT_LOCALE=true
```

### Excluding Routes

Exclude routes from localization:

```php
'excluded_routes' => [
    'api/*',
    'admin/*',
    'storage/*',
],
```

### Cache Configuration

Enable caching for better performance:

```php
'cache' => [
    'enabled' => true,
    'ttl' => 86400, // 24 hours
],
```

Clear cache:
```bash
php artisan multilingual:clear-cache
```

## Performance

This package is optimized for performance:

- **Minimal Middleware Overhead** - Only processes when needed
- **Smart Caching** - URL generation and locale detection are cached
- **Efficient URL Generation** - Fast, in-memory operations
- **No Database Queries** - Pure in-memory operations
- **Zero Impact** on PageSpeed scores

**Performance Tips:**
- Enable caching in production
- Use route exclusions for routes that don't need localization

## API Reference

### Facade Methods

```php
Multilingual::getSupportedLocales()      // Get all supported locales
Multilingual::getDefaultLocale()         // Get default locale
Multilingual::isSupportedLocale($locale) // Check if locale is supported
Multilingual::getLocaleName($locale)     // Get locale name
Multilingual::getLocaleFlag($locale)     // Get locale flag
Multilingual::isRtlLocale($locale)       // Check if RTL
Multilingual::getLocalizedUrl($locale, $url) // Get localized URL
Multilingual::getAllLocalizedUrls($url)  // Get all localized URLs
```

### Helper Functions

```php
localized_url($locale, $url = null)      // Get localized URL
all_localized_urls($url = null)          // Get all localized URLs
switch_locale($locale)                   // Switch locale
is_rtl()                                 // Check if RTL
locale_name($locale = null)              // Get locale name
locale_flag($locale = null)              // Get locale flag
localized_route($name, $params, $locale) // Generate localized route
```

## License

MIT

## Author

Shadi Shammaa

## Support

For issues and feature requests, please use the GitHub issue tracker.

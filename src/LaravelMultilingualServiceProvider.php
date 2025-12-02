<?php

declare(strict_types=1);

namespace Shammaa\LaravelMultilingual;

use Shammaa\LaravelMultilingual\Services\LocaleManager;
use Shammaa\LaravelMultilingual\Http\Middleware\SetLocale;
use Shammaa\LaravelMultilingual\Http\Middleware\LocaleRedirect;
use Shammaa\LaravelMultilingual\View\Components\LanguageSwitcher;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

final class LaravelMultilingualServiceProvider extends ServiceProvider
{
    /**
     * Register services
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/multilingual.php', 'multilingual');

        // Auto-populate locale_names and locale_flags from available_locales
        $config = config('multilingual', []);
        $availableLocales = $config['available_locales'] ?? [];
        
        if (!empty($availableLocales)) {
            // Auto-populate locale_names from available_locales
            $localeNames = $config['locale_names'] ?? [];
            foreach ($availableLocales as $code => $info) {
                if (is_array($info) && isset($info['name']) && !isset($localeNames[$code])) {
                    $localeNames[$code] = $info['name'];
                }
            }
            if (!empty($localeNames)) {
                config(['multilingual.locale_names' => $localeNames]);
            }
            
            // Auto-populate locale_flags from available_locales
            $localeFlags = $config['locale_flags'] ?? [];
            foreach ($availableLocales as $code => $info) {
                if (is_array($info) && isset($info['flag']) && !isset($localeFlags[$code])) {
                    $localeFlags[$code] = $info['flag'];
                }
            }
            if (!empty($localeFlags)) {
                config(['multilingual.locale_flags' => $localeFlags]);
            }
        }

        $this->app->singleton(LocaleManager::class, function ($app) {
            return new LocaleManager(
                config('multilingual', [])
            );
        });

        $this->app->alias(LocaleManager::class, 'multilingual');
    }

    /**
     * Bootstrap services
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/multilingual.php' => config_path('multilingual.php'),
        ], 'multilingual-config');

        $this->loadViews();
        $this->registerComponents();
        $this->registerMiddleware();
        $this->registerRouteMacros();
        $this->registerCommands();
        
        // Set default locale on application boot
        $this->app->booted(function () {
            $this->setDefaultLocale();
        });
    }

    /**
     * Load views
     */
    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'multilingual');
    }

    /**
     * Register Blade components
     */
    protected function registerComponents(): void
    {
        Blade::component('multilingual::language-switcher', LanguageSwitcher::class);
    }

    /**
     * Register middleware
     */
    protected function registerMiddleware(): void
    {
        $this->app['router']->aliasMiddleware('multilingual.locale', SetLocale::class);
        $this->app['router']->aliasMiddleware('multilingual.redirect', LocaleRedirect::class);
    }

    /**
     * Register route macros for localized routes
     */
    protected function registerRouteMacros(): void
    {
        Route::macro('localized', function (callable $callback) {
            $localeManager = app(LocaleManager::class);
            $supportedLocales = $localeManager->getSupportedLocales();

            foreach ($supportedLocales as $locale) {
                $shouldHide = $localeManager->shouldHideLocale($locale);
                $prefix = $shouldHide ? '' : $locale;

                Route::group([
                    'prefix' => $prefix,
                    'middleware' => ['multilingual.locale'],
                ], function () use ($callback, $locale) {
                    // Set locale before calling callback
                    app()->setLocale($locale);
                    $callback();
                });
            }
        });

        Route::macro('localizedGroup', function (array $attributes, callable $callback) {
            $localeManager = app(LocaleManager::class);
            $supportedLocales = $localeManager->getSupportedLocales();

            foreach ($supportedLocales as $locale) {
                $shouldHide = $localeManager->shouldHideLocale($locale);
                $prefix = $shouldHide ? '' : $locale;
                
                // Merge with existing prefix if provided
                if (isset($attributes['prefix'])) {
                    $prefix = $prefix ? "{$prefix}/{$attributes['prefix']}" : $attributes['prefix'];
                }

                $groupAttributes = array_merge($attributes, [
                    'prefix' => $prefix,
                    'middleware' => array_merge(
                        $attributes['middleware'] ?? [],
                        ['multilingual.locale']
                    ),
                ]);

                Route::group($groupAttributes, function () use ($callback, $locale) {
                    app()->setLocale($locale);
                    $callback();
                });
            }
        });
    }

    /**
     * Register console commands
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Shammaa\LaravelMultilingual\Console\ClearCacheCommand::class,
            ]);
        }
    }

    /**
     * Set default locale on application boot
     */
    protected function setDefaultLocale(): void
    {
        $localeManager = app(LocaleManager::class);
        $defaultLocale = $localeManager->getDefaultLocale();
        
        $this->app->setLocale($defaultLocale);
        $this->app['config']->set('app.locale', $defaultLocale);
    }
}

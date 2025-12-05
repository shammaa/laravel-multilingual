<?php

declare(strict_types=1);

namespace Shammaa\LaravelMultilingual\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Shammaa\LaravelMultilingual\LaravelMultilingualServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('cache.default', 'array');
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelMultilingualServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('cache.default', 'array');
        $app['config']->set('multilingual.supported_locales', ['ar', 'en']);
        $app['config']->set('multilingual.default_locale', 'ar');
    }
}


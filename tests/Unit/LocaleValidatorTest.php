<?php

declare(strict_types=1);

namespace Shammaa\LaravelMultilingual\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Shammaa\LaravelMultilingual\Exceptions\InvalidLocaleException;
use Shammaa\LaravelMultilingual\Services\LocaleValidator;

class LocaleValidatorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Mock config
        if (!function_exists('config')) {
            eval('function config($key, $default = null) { return $default; }');
        }
    }

    public function test_validate_locale_success(): void
    {
        // This will use default config
        $this->assertTrue(LocaleValidator::validateLocale('ar', false));
    }

    public function test_validate_locale_throws_exception_when_invalid(): void
    {
        $this->expectException(InvalidLocaleException::class);
        LocaleValidator::validateLocale('invalid-locale');
    }
}


<?php

declare(strict_types=1);

namespace Shammaa\LaravelMultilingual\Exceptions;

use InvalidArgumentException;

class InvalidLocaleException extends InvalidArgumentException
{
    /**
     * Create a new exception instance.
     */
    public function __construct(string $locale)
    {
        parent::__construct("Locale '{$locale}' is not supported.");
    }
}


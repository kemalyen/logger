<?php

namespace Kemalyen\Logger\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kemalyen\Logger\Logger
 */
class Logger extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Kemalyen\Logger\Logger::class;
    }
}

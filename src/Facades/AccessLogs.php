<?php

namespace Maize\AccessLogs\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Maize\AccessLogs\AccessLogs
 */
class AccessLogs extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Maize\AccessLogs\AccessLogs::class;
    }
}

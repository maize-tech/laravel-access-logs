<?php

namespace Maize\AccessLogs\Support;

use Maize\AccessLogs\Actions\GetCacheKeyAction;
use Maize\AccessLogs\Models\AccessLog;

class Config
{
    public static function getModel(): AccessLog
    {
        $model = config('access-logs.model')
            ?? AccessLog::class;

        return new $model;
    }

    public static function getCacheTtl(): int
    {
        return config('access-logs.cache_ttl')
            ?? 3600; // 1 hour
    }

    public static function getGetCacheKeyAction(): GetCacheKeyAction
    {
        $action = config('access-logs.cache_key_action')
            ?? GetCacheKeyAction::class;

        return app($action);
    }
}

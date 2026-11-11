<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Access Log model
    |--------------------------------------------------------------------------
    |
    | Here you may specify the fully qualified class name of the access log
    | model.
    | By default, the value is Maize\AccessLogs\Models\AccessLog::class
    |
    */
    'model' => null,

    /*
    |--------------------------------------------------------------------------
    | Cache ttl
    |--------------------------------------------------------------------------
    |
    | Here you may specify cache time to live in seconds.
    | By default, the value is 3600
    |
    */
    'cache_ttl' => null,

    /*
    |--------------------------------------------------------------------------
    | Get Cache Key Action
    |--------------------------------------------------------------------------
    |
    | Here you can specify the fully qualified class name of a custom action
    | used to get the cache key.
    | By default, the value is Maize\AccessLogs\Actions\GetCacheKeyAction::class
    |
    */
    'cache_key_action' => null,
];

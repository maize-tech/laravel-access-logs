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
    | Cache key
    |--------------------------------------------------------------------------
    |
    | Here you may specify the cache key.
    | You can define whether the settings should be cached or not,
    | the cache store, the key prefix and the default retention (in seconds).
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Get Cache Key Action
    |--------------------------------------------------------------------------
    |
    | Here you can specify the fully qualified class name of a custom action
    | used to get the cache key.
    | By default, the value is Maize\AccessLogs\Actions\GetCacheKeyAction::class
    */
    'cache_key_action' => null,
];

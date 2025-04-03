<?php

namespace Maize\AccessLogs\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Maize\AccessLogs\HasAccessLogs;
use Maize\AccessLogs\Models\AccessLog;
use Maize\AccessLogs\Support\Cache;
use Symfony\Component\HttpFoundation\Response;

class LogAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user instanceof HasAccessLogs) {
            return $next($request);
        }

        $lastAccess = Cache::for($user)->remember(fn () => (
            AccessLog::lastAccess($user)
        ));

        $isToday = $lastAccess?->accessed_at?->isToday() ?? false;

        if (! $isToday) {
            Cache::for($user)->forget();

            Cache::for($user)->remember(fn () => (
                AccessLog::registerAccess($user)
            ));
        }

        return $next($request);
    }
}

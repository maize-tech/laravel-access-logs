<?php

namespace Maize\AccessLogs\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Maize\AccessLogs\HasAccessLogs;
use Maize\AccessLogs\Support\Cache;
use Maize\AccessLogs\Support\Config;
use Symfony\Component\HttpFoundation\Response;

class LogAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user instanceof Model || ! $user instanceof HasAccessLogs) {
            return $next($request);
        }

        $lastAccess = Cache::for($user)->remember(fn () => (
            Config::getModel()::lastAccess($user)
        ));

        $isToday = $lastAccess?->accessed_at?->isToday() ?? false;

        if (! $isToday) {
            Cache::for($user)->forget();

            Cache::for($user)->remember(fn () => (
                Config::getModel()::registerAccess($user)
            ));
        }

        return $next($request);
    }
}

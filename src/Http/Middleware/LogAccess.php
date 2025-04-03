<?php

namespace Maize\AccessLogs\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        auth()->user()?->checkLastLogin();

        return $next($request);
    }
}

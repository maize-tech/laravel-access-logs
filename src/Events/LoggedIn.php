<?php

namespace Maize\AccessLogs\Events;

use Maize\AccessLogs\Models\AccessLog;

class LoggedIn
{
    public function __construct(
        public AccessLog $accessLog
    ) {}
}

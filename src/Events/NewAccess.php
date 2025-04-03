<?php

namespace Maize\AccessLogs\Events;

use Maize\AccessLogs\Models\AccessLog;

class NewAccess
{
    public function __construct(
        public AccessLog $accessLog
    ) {}
}

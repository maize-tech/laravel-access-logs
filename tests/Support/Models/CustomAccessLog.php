<?php

namespace Maize\AccessLogs\Tests\Support\Models;

use Maize\AccessLogs\Models\AccessLog;

class CustomAccessLog extends AccessLog
{
    protected $table = 'access_logs';
}

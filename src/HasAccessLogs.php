<?php

namespace Maize\AccessLogs;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasAccessLogs
{
    public function accessLogs(): MorphMany;
}

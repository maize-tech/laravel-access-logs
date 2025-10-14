<?php

namespace Maize\AccessLogs;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasAccessLogs
{
    public static function bootInteractsWithAccessLogs(): void;

    public function accessLogs(): MorphMany;
}

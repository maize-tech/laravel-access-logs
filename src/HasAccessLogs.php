<?php

namespace Maize\AccessLogs;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasAccessLogs
{
    public static function bootInteractWithAccessLogs(): void;

    public function accessLogs(): MorphMany;
}

<?php

namespace Maize\AccessLogs;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Maize\AccessLogs\Models\AccessLog;
use Maize\AccessLogs\Support\Config;

/** @phpstan-ignore trait.unused */
trait InteractWithAccessLogs
{
    public static function bootInteractWithAccessLogs(): void
    {
        static::deleting(fn (Authenticatable&HasAccessLogs $model) => (
            $model
                ->accessLogs()
                ->cursor()
                ->each(fn (AccessLog $log) => (
                    $log->delete()
                ))
        ));
    }

    public function accessLogs(): MorphMany
    {
        return $this->morphMany(Config::getModel()::class, 'user');
    }
}

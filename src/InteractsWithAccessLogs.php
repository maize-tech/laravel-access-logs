<?php

namespace Maize\AccessLogs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Maize\AccessLogs\Support\Config;

/** @phpstan-ignore trait.unused */
trait InteractsWithAccessLogs
{
    public static function bootInteractsWithAccessLogs(): void
    {
        static::deleting(fn (Model $model) => (
            $model->accessLogs()->delete()
        ));
    }

    public function accessLogs(): MorphMany
    {
        return $this->morphMany(Config::getModel()::class, 'user');
    }
}

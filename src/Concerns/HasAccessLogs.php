<?php

namespace Maize\AccessLogs\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Cache;
use Maize\AccessLogs\Models\AccessLog;

trait HasAccessLogs
{
    public function accessLogs(): MorphMany
    {
        return $this->morphMany(AccessLog::class, 'model')->latest();
    }

    public function getLastLogin(): AccessLog
    {
        return Cache::remember(
            key: "access-logs.{$this->getMorphClass()}.{$this->getKey()}.last_login",
            ttl: 3600, // 1 hour
            callback: fn () => $this->updateAccessLog()
        );
    }

    public function updateAccessLog(): AccessLog
    {
        Cache::forget("access-logs.{$this->getMorphClass()}.{$this->getKey()}.last_login");

        return $this
            ->accessLogs()
            ->whereDate('accessed_at', now())
            ->firstOrCreate(
                attributes: [],
                values: ['accessed_at' => now()]
            );
    }

    public function checkLastLogin(): void
    {
        if (! $this->getLastLogin()->accessed_at->isToday()) {
            $this->updateAccessLog();
        }
    }
}

<?php

namespace Maize\AccessLogs\Support;

use Closure;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache as BaseCache;
use Maize\AccessLogs\HasAccessLogs;

class Cache
{
    public function __construct(
        protected Authenticatable&HasAccessLogs $model
    ) {}

    public static function for(
        Authenticatable&HasAccessLogs $model
    ): self {
        return new self($model);
    }

    public function remember(Closure $callback): mixed
    {
        return BaseCache::remember(
            key: $this->key(),
            ttl: $this->ttl(),
            callback: $callback
        );
    }

    public function forget(): bool
    {
        return BaseCache::forget(
            key: $this->key(),
        );
    }

    protected function ttl(): int
    {
        return 3600; // 1 hour
    }

    protected function key(): string
    {
        return implode('.', [
            'access-logs',
            $this->model->getMorphClass(),
            $this->model->getKey(),
            'last_login', // TODO name
        ]);
    }
}

<?php

namespace Maize\AccessLogs\Actions;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Maize\AccessLogs\HasAccessLogs;

class GetCacheKeyAction
{
    public function __invoke(
        Authenticatable&HasAccessLogs $model
    ): string {
        return implode('.', [
            'access-logs',
            $model->getMorphClass(),
            $model->getKey(),
            'last_access',
        ]);
    }
}

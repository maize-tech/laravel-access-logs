<?php

namespace Maize\AccessLogs\Actions;

use Illuminate\Database\Eloquent\Model;
use Maize\AccessLogs\HasAccessLogs;

class GetCacheKeyAction
{
    public function __invoke(
        Model&HasAccessLogs $model
    ): string {
        return implode('.', [
            'access-logs',
            $model->getMorphClass(),
            $model->getKey(),
            'last_access',
        ]);
    }
}

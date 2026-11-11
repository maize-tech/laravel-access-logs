<?php

namespace Maize\AccessLogs\Tests\Support\Actions;

use Illuminate\Database\Eloquent\Model;
use Maize\AccessLogs\Actions\GetCacheKeyAction;
use Maize\AccessLogs\HasAccessLogs;

class CustomGetCacheKeyAction extends GetCacheKeyAction
{
    public function __invoke(
        Model&HasAccessLogs $model
    ): string {
        return "custom.{$model->getKey()}";
    }
}

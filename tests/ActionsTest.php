<?php

use Illuminate\Foundation\Auth\User as Authenticatable;
use Maize\AccessLogs\Actions\GetCacheKeyAction;
use Maize\AccessLogs\Tests\Support\Models\Admin;
use Maize\AccessLogs\Tests\Support\Models\User;

it('can get cache key', function () {

    /** @var Authenticatable $user */
    $user = User::factory()->create();

    expect(
        (new GetCacheKeyAction)($user)
    )->toBe("access-logs.{$user->getMorphClass()}.{$user->getKey()}.last_access");

    /** @var Authenticatable $user */
    $user = User::factory()->create();

    expect(
        (new GetCacheKeyAction)($user)
    )->toBe("access-logs.{$user->getMorphClass()}.{$user->getKey()}.last_access");

    /** @var Authenticatable $admin */
    $admin = Admin::factory()->create();

    expect(
        (new GetCacheKeyAction)($admin)
    )->toBe("access-logs.{$admin->getMorphClass()}.{$admin->getKey()}.last_access");
});

<?php

use Maize\AccessLogs\Models\AccessLog;
use Maize\AccessLogs\Tests\Support\Models\Admin;
use Maize\AccessLogs\Tests\Support\Models\User;

use function Pest\Laravel\assertDatabaseCount;

it('can delete logs when deleted user', function () {

    $user1 = User::factory()->create();

    AccessLog::registerAccess($user1);

    $user2 = User::factory()->create();

    AccessLog::registerAccess($user2);

    $admin = Admin::factory()->create();

    AccessLog::registerAccess($admin);

    assertDatabaseCount((new AccessLog)->getTable(), 3);

    $user1->delete();

    assertDatabaseCount((new AccessLog)->getTable(), 2);

    $admin->delete();

    assertDatabaseCount((new AccessLog)->getTable(), 1);

    $user2->delete();

    assertDatabaseCount((new AccessLog)->getTable(), 0);
})->only();

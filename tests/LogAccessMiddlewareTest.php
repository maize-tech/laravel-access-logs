<?php

use Illuminate\Foundation\Auth\User as Authenticatable;
use Maize\AccessLogs\Models\AccessLog;
use Maize\AccessLogs\Tests\Support\Models\Admin;
use Maize\AccessLogs\Tests\Support\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\getJson;

it('can register logs', function () {

    /** @var Authenticatable $user */
    $user = User::factory()->create();

    actingAs($user)
        ->getJson(route('route'))
        ->assertStatus(204);

    assertDatabaseHas((new AccessLog)->getTable(), [
        'user_id' => $user->getKey(),
        'user_type' => $user->getMorphClass(),
    ]);
});

it('can not register logs when user is not authenticated', function () {

    /** @var Authenticatable $user */
    $user = User::factory()->create();

    getJson(route('route'))
        ->assertStatus(401);

    assertDatabaseMissing((new AccessLog)->getTable(), [
        'user_id' => $user->getKey(),
        'user_type' => $user->getMorphClass(),
    ]);
});

it('can register logs for many model types', function () {

    /** @var Authenticatable $user */
    $user = User::factory()->create();

    actingAs($user)
        ->getJson(route('route'))
        ->assertStatus(204);

    /** @var Authenticatable $admin */
    $admin = Admin::factory()->create();

    actingAs($admin)
        ->getJson(route('route'))
        ->assertStatus(204);

    assertDatabaseHas((new AccessLog)->getTable(), [
        'user_id' => $user->getKey(),
        'user_type' => $user->getMorphClass(),
    ]);

    assertDatabaseHas((new AccessLog)->getTable(), [
        'user_id' => $admin->getKey(),
        'user_type' => $admin->getMorphClass(),
    ]);

    assertDatabaseCount((new AccessLog)->getTable(), 2);
});

it('can register one log per day per user', function () {

    /** @var Authenticatable $user */
    $user = User::factory()->create();

    actingAs($user)
        ->getJson(route('route'))
        ->assertStatus(204);

    actingAs($user)
        ->getJson(route('route'))
        ->assertStatus(204);

    assertDatabaseHas((new AccessLog)->getTable(), [
        'user_id' => $user->getKey(),
        'user_type' => $user->getMorphClass(),
    ]);

    assertDatabaseCount((new AccessLog)->getTable(), 1);
});

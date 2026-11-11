<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Maize\AccessLogs\Actions\GetCacheKeyAction;
use Maize\AccessLogs\Events\NewAccess;
use Maize\AccessLogs\Models\AccessLog;
use Maize\AccessLogs\Support\Config;
use Maize\AccessLogs\Tests\Support\Actions\CustomGetCacheKeyAction;
use Maize\AccessLogs\Tests\Support\Models\CustomAccessLog;
use Maize\AccessLogs\Tests\Support\Models\User;

use function Pest\Laravel\actingAs;
use function Spatie\PestPluginTestTime\testTime;

it('uses default values', function () {
    expect(Config::getModel())->toBeInstanceOf(AccessLog::class)
        ->and(Config::getCacheTtl())->toBe(3600)
        ->and(Config::getGetCacheKeyAction())->toBeInstanceOf(GetCacheKeyAction::class);
});

it('can use a custom model', function () {
    Event::fake();

    config()->set('access-logs.model', CustomAccessLog::class);

    expect(Config::getModel())->toBeInstanceOf(CustomAccessLog::class);

    actingAs(User::factory()->create())
        ->getJson(route('route'))
        ->assertStatus(204);

    Event::assertDispatched(NewAccess::class, fn (NewAccess $event) => (
        $event->accessLog instanceof CustomAccessLog
    ));
});

it('can use a custom cache key action', function () {
    config()->set('access-logs.cache_key_action', CustomGetCacheKeyAction::class);

    $user = User::factory()->create();

    actingAs($user)
        ->getJson(route('route'))
        ->assertStatus(204);

    expect(Cache::has("custom.{$user->getKey()}"))->toBeTrue()
        ->and(Cache::has((new GetCacheKeyAction)($user)))->toBeFalse();
});

it('can use a custom cache ttl', function () {
    testTime()->freeze('2025-07-29 10:00:00');

    config()->set('access-logs.cache_ttl', 60);

    $user = User::factory()->create();

    actingAs($user)
        ->getJson(route('route'))
        ->assertStatus(204);

    $key = (new GetCacheKeyAction)($user);

    expect(Cache::has($key))->toBeTrue();

    testTime()->addSeconds(61);

    expect(Cache::has($key))->toBeFalse();
});

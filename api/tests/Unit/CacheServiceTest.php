<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Constants\CacheKey;
use App\Models\User;
use App\Models\Weather;
use App\Services\CacheService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CacheServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateUserList()
    {
        // Given
        $users = User::factory()->count(3)->createQuietly();
        $userIds = $users->sortBy('id')->pluck('id')->toArray();
        $service = resolve(CacheService::class);

        // Expect
        Cache::shouldReceive('put')
            ->once()
            ->with(CacheKey::getAllUsersKey(), $userIds, $service::TTL_ONE_DAY);

        // When
        $service->updateUserList();
    }

    public function testUpdateUserWeather()
    {
        // Given
        $user = User::factory()->has(Weather::factory())->createQuietly();
        $user->load('weather');
        $service = resolve(CacheService::class);

        // Expect
        Cache::shouldReceive('put')
            ->once()
            ->withArgs(function ($arg1, $arg2, $arg3) use ($user, $service) {
                return $arg1 === CacheKey::getUserCurrentWeatherKey($user->id) &&
                    $user->is($arg2) &&
                    $arg3 === $service::TTL_ONE_HOUR;
            });

        // When
        $service->updateUserWeather($user->id);
    }

    public function testGetUserList()
    {
        // Given
        $users = User::factory()->count(3)->createQuietly();
        $userIds = $users->sortBy('id')->pluck('id')->toArray();
        $service = resolve(CacheService::class);

        // Expects
        Cache::shouldReceive('has')
            ->once()
            ->with(CacheKey::getAllUsersKey())
            ->andReturn(true);

        Cache::shouldReceive('get')
            ->once()
            ->with(CacheKey::getAllUsersKey())
            ->andReturn($userIds);

        // When
        $service->getUserList();
    }

    public function testGetUserWeather()
    {
        // Given
        $user = User::factory()->has(Weather::factory())->createQuietly();
        $user->load('weather');
        $service = resolve(CacheService::class);

        // Expects
        Cache::shouldReceive('has')
            ->once()
            ->with(CacheKey::getUserCurrentWeatherKey($user->id))
            ->andReturn(true);

        Cache::shouldReceive('get')
            ->once()
            ->with(CacheKey::getUserCurrentWeatherKey($user->id))
            ->andReturn($user);

        // When
        $service->getUserWeather($user->id);
    }
}

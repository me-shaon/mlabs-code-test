<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Jobs\FetchWeatherDataForUserJob;
use App\Models\User;
use App\Models\Weather;
use App\Services\CacheService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Mockery;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUsersWeather()
    {
        // Given
        $user1 = User::factory()->has(Weather::factory())->createQuietly();
        $user1->load('weather');
        $user2 = User::factory()->has(Weather::factory())->createQuietly();
        $user2->load('weather');
        $userIds = [$user1->id, $user2->id];
        $users = [$user1, $user2];
        $cacheServiceMock = Mockery::mock(CacheService::class);
        $service = resolve(UserService::class, ['cacheService' => $cacheServiceMock]);

        // expects
        $cacheServiceMock
            ->expects('getUserList')
            ->once()
            ->andReturn($userIds);

        $cacheServiceMock
            ->expects('getUserWeather')
            ->with($user1->id)
            ->andReturn($user1);

        $cacheServiceMock
            ->expects('getUserWeather')
            ->with($user2->id)
            ->andReturn($user2);

        // When
        $values = $service->getUsersWeather();

        // Then
        foreach ($users as $index => $user) {
            $this->assertTrue($user->is($values[$index]));
        }
    }
}

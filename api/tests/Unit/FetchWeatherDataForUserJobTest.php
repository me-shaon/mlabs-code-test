<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Events\UserDataUpdated;
use App\Jobs\FetchWeatherDataForUserJob;
use App\Models\User;
use App\Models\Weather;
use App\Services\CacheService;
use App\Services\External\Contracts\WeatherApiInterface;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Mockery;
use Tests\TestCase;

class FetchWeatherDataForUserJobTest extends TestCase
{
    use RefreshDatabase;

    public function testFetchWeatherDataForUserJobUpdatedWeatherData()
    {
        // Given
        Bus::fake();
        $user = User::factory()->create();
        $dummyPayload = [
            'weather' => [
                'id' => 501,
                'main' => 'Rain',
                'description' => 'moderate rain'
            ]
        ];

        $apiServiceMock = Mockery::mock(WeatherApiInterface::class);
        $cacheServiceMock = Mockery::mock(CacheService::class);
        $userServiceMock = Mockery::mock(UserService::class);

        // expects
        $apiServiceMock
            ->expects('getCurrentWeatherData')
            ->once()
            ->andReturn($dummyPayload);

        $cacheServiceMock
            ->expects('updateUserWeather')
            ->once();

        $userServiceMock
            ->expects('getUsersWeather')
            ->once()
            ->andReturn(collect([$user]));

        // When
        $job = resolve(FetchWeatherDataForUserJob::class, ['user' => $user]);
        $job->handle($apiServiceMock, $cacheServiceMock, $userServiceMock);

        // Then
        $this->assertDatabaseHas(
            Weather::class,
            [
                'user_id' => $user->id,
                'current' => $this->castAsJson($dummyPayload)
            ]
        );
    }
}

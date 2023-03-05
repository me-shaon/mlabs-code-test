<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Jobs\FetchWeatherDataForUserJob;
use App\Models\User;
use App\Models\Weather;
use App\Services\CacheService;
use App\Services\External\Contracts\WeatherApiInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class FetchWeatherDataForUserJobTest extends TestCase
{
    use RefreshDatabase;

    public function testFetchWeatherDataForUserJobUpdatedWeatherData()
    {
        // Given
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

        // expects
        $apiServiceMock
            ->expects('getCurrentWeatherData')
            ->once()
            ->andReturn($dummyPayload);

        $cacheServiceMock
            ->expects('updateUserWeather')
            ->once();

        // When
        $job = resolve(FetchWeatherDataForUserJob::class, ['user' => $user]);
        $job->handle($apiServiceMock, $cacheServiceMock);

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

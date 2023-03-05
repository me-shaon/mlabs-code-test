<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Jobs\FetchWeatherDataJob;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class FetchWeatherDataCommandTest extends TestCase
{
    public function testFetchWeatherDataCommandDispatchesJob()
    {
        // Given
        Bus::fake();

        // When
        $this->artisan('fetch-weather-data');

        // Then
        Bus::assertDispatched(FetchWeatherDataJob::class);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Exceptions\ApiCallException;
use App\Services\External\OpenWeatherApiService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class OpenWeatherApiServiceTest extends TestCase
{
    public function testGetCurrentWeatherDataCallsTheProperApi()
    {
        // Given
        $dummyResponsePayload = ['foo' => 'bar'];
        Http::fake(
            [
                'api.openweathermap.org/*' => Http::response($dummyResponsePayload)
            ]
        );

        // When
        $apiService = resolve(OpenWeatherApiService::class);
        $result = $apiService->getCurrentWeatherData(1.111, 2.222);

        // Then
        Http::assertSent(function (Request $request) {
            return Str::startsWith($request->url(), 'https://api.openweathermap.org/data/2.5/weather') &&
                $request['lat'] === 1.111 &&
                $request['lon'] === 2.222 &&
                $request['units'] === 'metric';
        });

        $this->assertEquals($dummyResponsePayload, $result);
    }

    public function testGetCurrentWeatherDataHandlesException()
    {
        // Given
        Http::fake(
            [
                'api.openweathermap.org/*' => Http::response(status: 503)
            ]
        );
        $this->expectException(ApiCallException::class);

        // When
        $apiService = resolve(OpenWeatherApiService::class);
        $apiService->getCurrentWeatherData(1.111, 2.222);

        // Then
        Http::assertSent(function (Request $request) {
            return Str::startsWith($request->url(), 'https://api.openweathermap.org/data/2.5/weather') &&
                $request['lat'] === 1.111 &&
                $request['lon'] === 2.222 &&
                $request['units'] === 'metric';
        });
    }
}

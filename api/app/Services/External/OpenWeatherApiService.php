<?php

declare(strict_types=1);

namespace App\Services\External;

use App\Exceptions\ApiCallException;
use App\Services\External\Contracts\WeatherApiInterface;
use Illuminate\Support\Facades\Http;

class OpenWeatherApiService implements WeatherApiInterface
{
    public function getBaseURL(): string
    {
        return 'https://api.openweathermap.org/data/2.5';
    }

    /**
     * @throws ApiCallException
     */
    public function getCurrentWeatherData(float $lat, float $lon): array
    {
        $response = Http::get("{$this->getBaseURL()}/weather", [
            'lat' => $lat,
            'lon' => $lon,
            'units' => 'metric',
            'appid' => config('weatherapi.services.open_weather.api_key')
        ]);

        if ($response->failed()) {
            throw new ApiCallException(
                "Current weather API call with params: ($lat, $lon) failed with error code: {$response->status()}"
            );
        }

        return $response->json();
    }
}

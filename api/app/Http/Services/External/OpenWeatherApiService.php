<?php

declare(strict_types=1);

namespace App\Http\Services\External;

use Exception;
use App\Http\Services\External\Contracts\WeatherApiInterface;
use Illuminate\Support\Facades\Http;

class OpenWeatherApiService implements WeatherApiInterface
{
    public function getBaseURL(): string
    {
        return 'https://api.openweathermap.org/data/2.5';
    }

    /**
     * @throws Exception
     */
    public function getCurrentWeatherData(string $lat, string $lon): array
    {
        $response = Http::get("{$this->getBaseURL()}/weather", [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => config('weatherapi.open_weather.api_key')
        ]);

        if ($response->failed()) {
            throw new Exception(
                "Current weather API call with params: ($lat, $lon) failed with error code: {$response->status()}"
            );
        }

        return $response->json();
    }
}

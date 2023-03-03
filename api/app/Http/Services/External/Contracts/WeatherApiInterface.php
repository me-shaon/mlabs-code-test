<?php

declare(strict_types=1);

namespace App\Http\Services\External\Contracts;

interface WeatherApiInterface
{
    public function getBaseURL();

    public function getCurrentWeatherData(string $lat, string $lon);
}

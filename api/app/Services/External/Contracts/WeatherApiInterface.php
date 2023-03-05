<?php

declare(strict_types=1);

namespace App\Services\External\Contracts;

interface WeatherApiInterface
{
    public function getBaseURL();

    public function getCurrentWeatherData(float $lat, float $lon);
}

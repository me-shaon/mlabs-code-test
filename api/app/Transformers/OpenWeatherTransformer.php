<?php

declare(strict_types=1);

namespace App\Transformers;

class OpenWeatherTransformer extends AbstractWeatherTransformer
{
    public function getSummary(): array
    {
        $city = $this->weather->current['name'];
        $country = optional($this->weather->current['sys'])['country'];

        return [
            'location' => implode(", ", array_filter([$city, $country], fn ($item) => !empty($item))),
            'current_temp' => round(optional($this->weather->current['main'])['temp']) . "°C",
        ];
    }

    public function getDetails(): array
    {
        return [
            'current_temp' => round(optional($this->weather->current['main'])['temp']) . "°C",
            'min_temp' => round(optional($this->weather->current['main'])['temp_min']) . "°C",
            'max_temp' => round(optional($this->weather->current['main'])['temp_max']) . "°C",
            'feels_like' => round(optional($this->weather->current['main'])['feels_like']) . "°C",
            'pressure' => optional($this->weather->current['main'])['pressure'],
            'humidity' => optional($this->weather->current['main'])['humidity'],
            'status' => optional($this->weather->current['weather'][0])['main'],
            'description' => optional($this->weather->current['weather'][0])['description'],
        ];
    }
}

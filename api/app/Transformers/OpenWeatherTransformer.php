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
            'min_temp' => round(optional($this->weather->current['main'])['temp_min']) . "°",
            'max_temp' => round(optional($this->weather->current['main'])['temp_max']) . "°",
        ];
    }

    public function getDetails(): array
    {
        return [];
    }
}

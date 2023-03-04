<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\Weather;

abstract class AbstractWeatherTransformer
{
    public function __construct(protected Weather $weather)
    {
    }

    abstract public function getSummary(): array;

    abstract public function getDetails(): array;
}

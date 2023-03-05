<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\FetchWeatherDataJob;
use Illuminate\Console\Command;

class FetchWeatherData extends Command
{
    protected $signature = 'fetch-weather-data';

    protected $description = 'Fetch weather data for the users';

    public function handle(): void
    {
        FetchWeatherDataJob::dispatch();
    }
}

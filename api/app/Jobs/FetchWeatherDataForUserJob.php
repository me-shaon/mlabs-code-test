<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Http\Services\CacheService;
use App\Http\Services\External\Contracts\WeatherApiInterface;
use App\Jobs\Traits\ExponentialBackoff;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchWeatherDataForUserJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use ExponentialBackoff;

    public function __construct(protected User $user)
    {
    }

    public function handle(WeatherApiInterface $weatherApi, CacheService $cacheService): void
    {
        $currentWeather = $weatherApi->getCurrentWeatherData($this->user->latitude, $this->user->longitude);

        $this->user->weather()->updateOrCreate(
            [
                'current' => $currentWeather
            ]
        );

        $cacheService->updateUserWeather($this->user->id);
    }
}

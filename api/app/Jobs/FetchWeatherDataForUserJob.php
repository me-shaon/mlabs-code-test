<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Events\UserDataUpdated;
use App\Http\Resources\UserResource;
use App\Jobs\Traits\ExponentialBackoff;
use App\Models\User;
use App\Services\CacheService;
use App\Services\External\Contracts\WeatherApiInterface;
use App\Services\UserService;
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

    public function __construct(public User $user)
    {
    }

    public function handle(WeatherApiInterface $weatherApi, CacheService $cacheService, UserService $userService): void
    {
        $currentWeather = $weatherApi->getCurrentWeatherData($this->user->latitude, $this->user->longitude);

        $this->user->weather()->updateOrCreate(
            [
                'user_id' => $this->user->id,
            ],
            [
                'current' => $currentWeather
            ]
        );

        $cacheService->updateUserWeather($this->user->id);

        UserDataUpdated::dispatch(UserResource::collection($userService->getUsersWeather()));
    }
}

<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\FetchWeatherDataForUserJob;
use App\Models\Weather;
use Illuminate\Support\Collection;

class UserService
{
    public function __construct(protected CacheService $cacheService)
    {
    }

    public function getUsersWeather(): Collection
    {
        $users = collect();
        $userIds = $this->cacheService->getUserList();

        foreach ($userIds as $userId) {
            $users->push($this->cacheService->getUserWeather($userId));
        }

        return $users;
    }

    public function syncStaleUsersWeather(Collection $users)
    {
        foreach ($users as $user) {
            if (empty($user->weather) || $this->isStale($user->weather)) {
                FetchWeatherDataForUserJob::dispatch($user);
            }
        }
    }

    private function isStale(Weather $weather): bool
    {
        $syncFrequency = config('weatherapi.data_sync_frequency');

        return $weather->updated_at->lt(now()->subMinutes($syncFrequency));
    }
}

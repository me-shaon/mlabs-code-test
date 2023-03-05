<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Constants\CacheKey;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    public function updateUserList()
    {
        Cache::put(CacheKey::getAllUsersKey(), User::pluck('id'), now()->addDay());
    }

    public function getUserList(): Collection
    {
        if (!Cache::has(CacheKey::getAllUsersKey())) {
            $this->updateUserList();
        }

        return Cache::get(CacheKey::getAllUsersKey(), collect());
    }

    public function updateUserWeather(string $userId)
    {
        Cache::put(
            CacheKey::getUserCurrentWeatherKey($userId),
            User::with('weather')->find($userId),
            now()->addHour()
        );
    }

    public function getUserWeather(string $userId)
    {
        if (!Cache::has(CacheKey::getUserCurrentWeatherKey($userId))) {
            $this->updateUserWeather($userId);
        }

        return Cache::get(CacheKey::getUserCurrentWeatherKey($userId));
    }
}

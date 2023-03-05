<?php

declare(strict_types=1);

namespace App\Services;

use App\Constants\CacheKey;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    public const TTL_ONE_DAY = 86400;
    public const TTL_ONE_HOUR = 3600;

    public function updateUserList()
    {
        $userIds = User::orderBy('id')->pluck('id')->toArray();

        Cache::put(CacheKey::getAllUsersKey(), $userIds, self::TTL_ONE_DAY);
    }

    public function getUserList(): array
    {
        if (!Cache::has(CacheKey::getAllUsersKey())) {
            $this->updateUserList();
        }

        return Cache::get(CacheKey::getAllUsersKey());
    }

    public function updateUserWeather(int $userId)
    {
        Cache::put(
            CacheKey::getUserCurrentWeatherKey($userId),
            User::with('weather')->find($userId),
            self::TTL_ONE_HOUR
        );
    }

    public function getUserWeather(int $userId)
    {
        if (!Cache::has(CacheKey::getUserCurrentWeatherKey($userId))) {
            $this->updateUserWeather($userId);
        }

        return Cache::get(CacheKey::getUserCurrentWeatherKey($userId));
    }
}

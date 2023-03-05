<?php

declare(strict_types=1);

namespace App\Constants;

class CacheKey
{
    public static function getUserCurrentWeatherKey(int $userId): string
    {
        return "user:$userId:current-weather";
    }

    public static function getAllUsersKey(): string
    {
        return 'users:list';
    }
}

<?php

declare(strict_types=1);

namespace App\Constants;

use App\Models\User;

class CacheKey
{
    public static function getUserCurrentWeatherKey(User $user): string
    {
        return "user:$user->uuid:current-weather";
    }
}

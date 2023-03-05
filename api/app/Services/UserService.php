<?php

declare(strict_types=1);

namespace App\Services;

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
}

<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserCreated;
use App\Services\CacheService;

class UpdateUserListCache
{
    public function __construct(protected CacheService $cacheService)
    {
    }

    public function handle(UserCreated $event): void
    {
        $this->cacheService->updateUserList();
    }
}

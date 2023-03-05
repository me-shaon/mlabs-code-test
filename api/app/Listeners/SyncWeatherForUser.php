<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserCreated;
use App\Jobs\FetchWeatherDataForUserJob;

class SyncWeatherForUser
{
    public function handle(UserCreated $event): void
    {
        FetchWeatherDataForUserJob::dispatch($event->user);
    }
}

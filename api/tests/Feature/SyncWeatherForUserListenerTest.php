<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Events\UserCreated;
use App\Jobs\FetchWeatherDataForUserJob;
use App\Listeners\SyncWeatherForUser;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class SyncWeatherForUserListenerTest extends TestCase
{
    public function testIsAttachedToEvent()
    {
        Event::fake();
        Event::assertListening(
            UserCreated::class,
            SyncWeatherForUser::class
        );
    }

    public function testDispatchesJob()
    {
        // Given
        Bus::fake();
        $user = User::factory()->createQuietly();
        $event = new UserCreated($user);
        $listener = resolve(SyncWeatherForUser::class);

        //When
        $listener->handle($event);

        // Then
        Bus::assertDispatched(function (FetchWeatherDataForUserJob $job) use ($user) {
            return $job->user->id === $user->id;
        });
    }
}

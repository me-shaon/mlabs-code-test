<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Events\UserCreated;
use App\Listeners\UpdateUserListCache;
use App\Models\User;
use App\Services\CacheService;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Mockery;

class UpdateUserListCacheListenerTest extends TestCase
{
    public function testIsAttachedToEvent()
    {
        Event::fake();
        Event::assertListening(
            UserCreated::class,
            UpdateUserListCache::class
        );
    }

    public function testCallsServiceMethod()
    {
        // Given
        $user = User::factory()->createQuietly();
        $event = new UserCreated($user);
        $cacheService = Mockery::mock(CacheService::class);
        $listener = resolve(UpdateUserListCache::class, ['cacheService' => $cacheService]);

        // Expects
        $cacheService
        ->expects('updateUserList')
        ->once();

        // When
        $listener->handle($event);
    }
}

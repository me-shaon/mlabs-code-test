<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Jobs\FetchWeatherDataForUserJob;
use App\Jobs\FetchWeatherDataJob;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class FetchWeatherDataJobTest extends TestCase
{
    public function testFetchWeatherDataJobDispatchesOtherGranularJobs()
    {
        // Given
        Bus::fake();
        $users = User::factory()->count(3)->create();

        // When
        $job = resolve(FetchWeatherDataJob::class);
        $job->handle();

        // Then
        foreach ($users as $user) {
            Bus::assertDispatched(function(FetchWeatherDataForUserJob $job) use ($user) {
                return $job->user->id === $user->id;
            });
        }
    }
}

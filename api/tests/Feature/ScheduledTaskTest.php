<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Scheduling\Event;

class ScheduledTaskTest extends TestCase
{
    public function testWeatherDataFetchingCommandIsScheduled()
    {
        $schedule = app()->make(Schedule::class);

        $events = collect($schedule->events())->filter(function (Event $event) {
            return stripos($event->command, 'fetch-weather-data');
        });

        $this->assertCount(1, $events, 'fetch-weather-data command is not scheduled');
    }

    public function testPruneStaleTagCommandIsScheduled()
    {
        $schedule = app()->make(Schedule::class);

        $events = collect($schedule->events())->filter(function (Event $event) {
            return stripos($event->command, 'cache:prune-stale-tags');
        });

        $this->assertCount(1, $events, 'cache:prune-stale-tags command is not scheduled');
    }
}

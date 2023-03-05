<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Weather;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class UserListTest extends TestCase
{
    use RefreshDatabase;

    public function testUserListReturnsProperData()
    {
        // Given
        $users = User::factory()->has(Weather::factory())->count(3)->create();
        $users->load('weather');
        $userServiceMock = Mockery::mock(UserService::class);
        $this->instance(UserService::class, $userServiceMock);

        // Expects
        $userServiceMock
            ->expects('getUsersWeather')
            ->once()
            ->andReturn($users);

        $userServiceMock
            ->expects('syncStaleUsersWeather')
            ->with($users)
            ->once();

        // When
        $response = $this->get('api/users');

        // Then
        $response->assertStatus(200);
    }
}

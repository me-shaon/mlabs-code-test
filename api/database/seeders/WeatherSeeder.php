<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\Weather;
use Illuminate\Database\Seeder;

class WeatherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::orderBy('id')->pluck('id');

        foreach ($userIds as $userId) {
            Weather::factory()->create(
                [
                    'user_id' => $userId
                ]
            );
        }
    }
}

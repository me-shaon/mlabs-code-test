<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Weather>
 */
class WeatherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'current' => [
                'name' => 'Zocca',
                'sys' => [
                    'country' => 'IT'
                ],
                'weather' => [
                    [
                        'main' => 'Rain',
                        'description' => 'moderate rain'
                    ]
                ],
                'main' => [
                    'temp' => '29',
                    'temp_min' => '23',
                    'temp_max' => '31',
                    'feels_like' => '30',
                    'humidity' => '67',
                    'pressure' => '1212'
                ]
            ]
        ];
    }
}

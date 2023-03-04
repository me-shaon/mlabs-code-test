<?php

return [
    'services' => [
        'open_weather' => [
            'api_key' => env('OPEN_WEATHER_API_KEY', null)
        ]
    ],
    'data_sync_frequency' => env('WEATHER_DATA_SYNC_FREQUENCY', 30), // in minutes (max value: 60)
];

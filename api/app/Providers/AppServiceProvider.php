<?php

namespace App\Providers;

use App\Http\Services\External\Contracts\WeatherApiInterface;
use App\Http\Services\External\OpenWeatherApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        WeatherApiInterface::class => OpenWeatherApiService::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

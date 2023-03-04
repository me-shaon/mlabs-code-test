<?php

namespace App\Providers;

use App\Http\Services\External\Contracts\WeatherApiInterface;
use App\Http\Services\External\OpenWeatherApiService;
use App\Transformers\AbstractWeatherTransformer;
use App\Transformers\OpenWeatherTransformer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        WeatherApiInterface::class => OpenWeatherApiService::class,
        AbstractWeatherTransformer::class => OpenWeatherTransformer::class
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

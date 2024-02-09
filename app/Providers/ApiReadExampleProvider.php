<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class ApiReadExampleProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('read-api', function () {
            return Http::withOptions([
                'verify' => false,
                'base_uri' => 'https://jsonplaceholder.typicode.com/'
            ])->withHeaders([
                'Authorization' => 'Bearer ',
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}

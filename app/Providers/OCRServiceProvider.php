<?php

namespace App\Providers;

use App\Services\OCRSercive;
use Illuminate\Support\ServiceProvider;

class OCRServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(OCRSercive::class, function ($app) {
            return new OCRSercive(
                apiKey: config('services.mistral.key')
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

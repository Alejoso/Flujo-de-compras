<?php

namespace App\Providers;

use App\Services\OCRService;
use Illuminate\Support\ServiceProvider;

class OCRServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(OCRService::class, function ($app) {
            return new OCRService(
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

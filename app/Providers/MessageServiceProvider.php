<?php

namespace App\Providers;

use App\Services\SendMessageFactory;
use Illuminate\Support\ServiceProvider;

class MessageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SendMessageFactory::class);
    }
}

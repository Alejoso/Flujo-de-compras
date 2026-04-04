<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SendMessageFactory;

class MessageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SendMessageFactory::class);
    }
}
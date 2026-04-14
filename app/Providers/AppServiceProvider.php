<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        RedirectIfAuthenticated::redirectUsing(function ($request) {
            $user = auth()->user();

            if ($user->getRole() === 'admin') {
                return route('admin.project.index');
            }

            return route('technician.project.index');
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        view()->composer(['layout.index'], function ($view) {
            if (Auth::check()) {
                $account = Auth::user();
                $view->with('account', $account);
            }
        });

        Gate::define('admin', function () {
            return Auth::user()->role === "admin";
        });
        Gate::define('cashier', function () {
            return Auth::user()->role === "cashier";
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

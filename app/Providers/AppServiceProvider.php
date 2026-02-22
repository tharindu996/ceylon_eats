<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\Gate::define('is-owner', function ($user) {
            return $user->hasRole(\App\Models\User::ROLE_OWNER);
        });

        \Illuminate\Support\Facades\Gate::define('is-admin', function ($user) {
            return $user->hasRole(\App\Models\User::ROLE_ADMIN);
        });

        \Illuminate\Support\Facades\Gate::define('is-vendor-manager', function ($user) {
            return $user->hasRole(\App\Models\User::ROLE_VENDOR_MANAGER);
        });

        \Illuminate\Support\Facades\Gate::define('is-finance-manager', function ($user) {
            return $user->hasRole(\App\Models\User::ROLE_FINANCE_MANAGER);
        });

        \Illuminate\Support\Facades\Gate::define('is-support-executive', function ($user) {
            return $user->hasRole(\App\Models\User::ROLE_SUPPORT_EXECUTIVE);
        });

        // Combined Gate for "Sensitive Admin Actions"
        \Illuminate\Support\Facades\Gate::define('has-operational-control', function ($user) {
            return $user->hasRole(\App\Models\User::ROLE_OWNER) || $user->hasRole(\App\Models\User::ROLE_ADMIN);
        });
    }
}

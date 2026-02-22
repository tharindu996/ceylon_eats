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
            return $user->hasRole(\App\Models\Role::OWNER);
        });

        \Illuminate\Support\Facades\Gate::define('is-admin', function ($user) {
            return $user->hasRole(\App\Models\Role::ADMIN);
        });

        \Illuminate\Support\Facades\Gate::define('is-vendor-manager', function ($user) {
            return $user->hasRole(\App\Models\Role::VENDOR_MANAGER);
        });

        \Illuminate\Support\Facades\Gate::define('is-finance-manager', function ($user) {
            return $user->hasRole(\App\Models\Role::FINANCE_MANAGER);
        });

        \Illuminate\Support\Facades\Gate::define('is-support-executive', function ($user) {
            return $user->hasRole(\App\Models\Role::SUPPORT_EXECUTIVE);
        });

        // Combined Gate for "Sensitive Admin Actions"
        \Illuminate\Support\Facades\Gate::define('has-operational-control', function ($user) {
            return $user->hasRole(\App\Models\Role::OWNER) || $user->hasRole(\App\Models\Role::ADMIN);
        });
    }
}

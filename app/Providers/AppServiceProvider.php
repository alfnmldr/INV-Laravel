<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

     public function boot()
    {
        // Contoh mendefinisikan gate untuk admin
        Gate::define('access-admin', function ($user) {
            return $user->role === 'admin';
        });
    }

    /**
     * Bootstrap any application services.
     */
}

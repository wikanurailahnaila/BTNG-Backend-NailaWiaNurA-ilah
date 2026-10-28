<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Illuminate\Support\Facades\Gate;
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
        // Dokumentasi API Scramble dapat diakses publik di /docs/api
        Scramble::configure('default')->expose('/docs/api', '/docs/api.json');

        Gate::define('viewApiDocs', function (?object $user = null) {
            return true;
        });
    }
}

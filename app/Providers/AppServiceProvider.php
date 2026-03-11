<?php

namespace App\Providers;

use App\Services\License\LicenseService;
use App\Support\SystemBoot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SystemBoot::class, fn () => new SystemBoot());
        $this->app->singleton(LicenseService::class, fn ($app) => new LicenseService($app->make(SystemBoot::class)));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        if (env('APP_ENV') === "production") {
            URL::forceScheme('https');
        }
    }
}

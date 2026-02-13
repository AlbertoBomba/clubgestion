<?php

namespace App\Providers;

use App\Services\TenantService;
use Illuminate\Support\ServiceProvider;

class TenantServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Registrar TenantService como singleton
        $this->app->singleton('tenant', function ($app) {
            return new TenantService();
        });

        // Alias para facilitar el uso
        $this->app->alias('tenant', TenantService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Aquí puedes agregar lógica adicional si es necesario
    }
}

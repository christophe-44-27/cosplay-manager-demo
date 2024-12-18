<?php

namespace App\Domains\Core\Providers;

use App\Providers\ModuleServiceProvider;

class CoreServiceProvider extends ModuleServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Migrations');
    }
}

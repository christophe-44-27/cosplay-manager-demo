<?php

namespace App\Domains\ProjectManagement\Providers;

use App\Providers\ModuleServiceProvider;

class ProjectManagementServiceProvider extends ModuleServiceProvider
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

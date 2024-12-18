<?php

namespace App\Domains\Community\Providers;

use App\Providers\ModuleServiceProvider;

class CommunityServiceProvider extends ModuleServiceProvider
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

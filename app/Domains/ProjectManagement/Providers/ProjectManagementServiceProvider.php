<?php

namespace App\Domains\ProjectManagement\Providers;

use App\Domains\ProjectManagement\Controllers\ProjectController;
use App\Providers\ModuleServiceProvider;
use Illuminate\Support\Facades\Route;

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
        $this->registerProjectRoutes();
    }

    private function registerProjectRoutes()
    {
        $this->registerProtectedRoutes(function() {
            Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
        });
    }
}

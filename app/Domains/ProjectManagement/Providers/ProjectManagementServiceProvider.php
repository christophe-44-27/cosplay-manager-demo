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
            Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
            Route::post('projects/store', [ProjectController::class, 'store'])->name('projects.store');
            Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
            Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
            Route::post('projects/{project}/update', [ProjectController::class, 'update'])->name('projects.update');
        });
    }
}

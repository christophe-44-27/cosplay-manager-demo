<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

abstract class ModuleServiceProvider extends ServiceProvider
{
    protected function registerProtectedRoutes($callback)
    {
        $this->registerRoutes(function () use ($callback) {
            Route::middleware(['auth', 'web'])->group(function () use ($callback) {
                $callback();
            });
        });
    }

    protected function registerPublicRoutes($callback)
    {
        $this->registerRoutes(function () use ($callback) {
            $callback();
        });
    }

    protected function registerRoutes($callback)
    {
        if ($this->app->runningUnitTests() || !$this->app->routesAreCached()) {
            Route::middleware(['web'])->group(function () use ($callback) {
                $callback();
            });
        }
    }
}

<?php

namespace App\Domains\Community\Providers;

use App\Domains\Community\Controllers\MemberController;
use App\Providers\ModuleServiceProvider;
use Illuminate\Support\Facades\Route;

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
        $this->registerMemberRoutes();
    }

    private function registerMemberRoutes()
    {
        $this->registerProtectedRoutes(function() {
            Route::get('members', [MemberController::class, 'index'])->name('members.index');
            Route::get('members/{member}', [MemberController::class, 'show'])->name('members.show');
        });
    }
}

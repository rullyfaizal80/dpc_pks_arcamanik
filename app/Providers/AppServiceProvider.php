<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware; 
use Spatie\Permission\Middleware\PermissionMiddleware;

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
        // --- DAFTARKAN MIDDLEWARE SPATIE DI SINI ---
    // Kita gunakan Route::aliasMiddleware() untuk mendaftarkan alias
    Route::aliasMiddleware('role', RoleMiddleware::class);
    Route::aliasMiddleware('permission', PermissionMiddleware::class);
    // ------------------------------------------
    }
}

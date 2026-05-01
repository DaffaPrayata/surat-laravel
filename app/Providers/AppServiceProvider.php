<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL; // <--- TAMBAHIN INI
use Illuminate\Pagination\Paginator;

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
        // FIX MIXED CONTENT: Paksa HTTPS kalau diakses via Ngrok
        if (str_contains(request()->url(), 'ngrok-free.dev')) {
            URL::forceScheme('https');
        }

        // FIX PANAH RAKSASA: Paksa Laravel pake styling Bootstrap untuk Pagination
        Paginator::useBootstrapFour(); 

        /** * AUTO CREATE ADMIN (LOCAL ONLY) */
        try {
            if (app()->isLocal() && Schema::hasTable('users')) {
                if (User::count() === 0) {
                    User::create([
                        'username'  => 'admin',
                        'name'      => 'Administrator',
                        'email'     => 'admin@admin.com',
                        'password'  => Hash::make('admin123'),
                        'role'      => 'admin',
                        'is_active' => true,
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Biarkan kosong
        }
    }
}
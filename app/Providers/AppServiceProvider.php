<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        if (!app()->runningInConsole()) {
            if (str_contains(request()->getHost(), 'ngrok')) {
                \Illuminate\Support\Facades\Vite::useHotFile(public_path('non-existent-hot-file'));
            }
        }
    }
}

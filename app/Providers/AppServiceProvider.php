<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        if (Schema::hasTable('settings')) {
            
            $web_settings = Setting::first() ?? new Setting([
                'nama_klinik' => 'Klinik Default',
                'theme_colors' => [
                    'primary' => '#A5B985',
                    'secondary' => '#B3C499',
                    'accent' => '#FFDBA3',
                    'neutral' => '#E9E8EB',
                ]
            ]);

            View::share('web_config', $web_settings);
        }
    }
}

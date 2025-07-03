<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PdfService;

class PdfServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PdfService::class, function ($app) {
            return new PdfService(config('mpdf'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/mpdf.php' => config_path('mpdf.php'),
        ], 'config');
    }
}

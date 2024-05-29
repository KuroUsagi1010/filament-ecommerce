<?php

namespace App\Providers;

use App\Contracts\SkuGeneratorInterface;
use App\Services\SkuGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SkuGeneratorInterface::class, SkuGenerator::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Unguard all models and let filament handle these logic
         */
        Model::unguard();
    }
}

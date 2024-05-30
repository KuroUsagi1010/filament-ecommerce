<?php

namespace App\Providers;

use App\Contracts\ProductDashboardInterface;
use App\Contracts\SkuGeneratorInterface;
use App\Services\ProductDashboard;
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
        /** Service use to generate an SKU for a product variant */
        $this->app->bind(SkuGeneratorInterface::class, SkuGenerator::class);

        /** Service used by Dashboard widgets */
        $this->app->singleton(ProductDashboardInterface::class, ProductDashboard::class);
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

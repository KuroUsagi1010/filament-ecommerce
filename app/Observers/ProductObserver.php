<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\ProductDashboard;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        Cache::forget(ProductDashboard::PRODUCT_TOTAL_KEY);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        Cache::forget(ProductDashboard::PRODUCT_TOTAL_KEY);
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        Cache::forget(ProductDashboard::PRODUCT_TOTAL_KEY);
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        Cache::forget(ProductDashboard::PRODUCT_TOTAL_KEY);
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        Cache::forget(ProductDashboard::PRODUCT_TOTAL_KEY);
    }
}

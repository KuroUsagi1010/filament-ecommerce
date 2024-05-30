<?php

namespace App\Observers;

use App\Models\ProductVariant;
use App\Services\ProductDashboard;
use Illuminate\Support\Facades\Cache;

class ProductVariantObserver
{
    /**
     * Handle the ProductVariant "created" event.
     */
    public function created(ProductVariant $productVariant): void
    {
        Cache::forget(ProductDashboard::VARIANT_STOCK_TOTAL_KEY);
    }

    /**
     * Handle the ProductVariant "updated" event.
     */
    public function updated(ProductVariant $productVariant): void
    {
        Cache::forget(ProductDashboard::VARIANT_STOCK_TOTAL_KEY);
    }

    /**
     * Handle the ProductVariant "deleted" event.
     */
    public function deleted(ProductVariant $productVariant): void
    {
        Cache::forget(ProductDashboard::VARIANT_STOCK_TOTAL_KEY);
    }

    /**
     * Handle the ProductVariant "restored" event.
     */
    public function restored(ProductVariant $productVariant): void
    {
        Cache::forget(ProductDashboard::VARIANT_STOCK_TOTAL_KEY);
    }

    /**
     * Handle the ProductVariant "force deleted" event.
     */
    public function forceDeleted(ProductVariant $productVariant): void
    {
        Cache::forget(ProductDashboard::VARIANT_STOCK_TOTAL_KEY);
    }
}

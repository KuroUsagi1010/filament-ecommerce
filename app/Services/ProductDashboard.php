<?php

namespace App\Services;

use App\Contracts\ProductDashboardInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductDashboard implements ProductDashboardInterface
{

    const PRODUCT_TOTAL_KEY = "dashboard_product_total";
    const VARIANT_STOCK_TOTAL_KEY = "dashboard_variant_stocks_total";

    public function getTotal(): int
    {
        // this key is being invalidated in the ProductObserver
        return Cache::remember(self::PRODUCT_TOTAL_KEY, now()->addHours(1), function () {
            return Product::count();
        });
    }

    public function getTotalVariantStock(): int
    {
        // this key is being invalidated in the ProductVariantObserver
        return Cache::remember(self::VARIANT_STOCK_TOTAL_KEY, now()->addHours(1), function () {
            return Product::query()
                ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->sum('product_variants.available_stock');
        });
    }
}

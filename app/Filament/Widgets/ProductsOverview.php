<?php

namespace App\Filament\Widgets;

use App\Contracts\ProductDashboardInterface;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        /** @var ProductDashboardInterface $dashboardService */
        $dashboardService = app()->make(ProductDashboardInterface::class);

        return [
            Stat::make('Total Products', $dashboardService->getTotal())
                ->description('Total products on the system.'),
            Stat::make('Available Variant Stocks', $dashboardService->getTotalVariantStock())
        ];
    }
}

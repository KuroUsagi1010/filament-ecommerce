<?php

namespace App\Contracts;

/**
 * Defines the contract for building the product dashboard counters
 * @method int getTotal() retrieves the total count of products
 * @method int getTotalVariantStock() retrieves the total count of variants for all products
 */
interface ProductDashboardInterface
{

    /**
     * retrieves the total number of products
     */
    public function getTotal(): int;

    /**
     * retrieves all stocks for all variants
     */
    public function getTotalVariantStock(): int;
}

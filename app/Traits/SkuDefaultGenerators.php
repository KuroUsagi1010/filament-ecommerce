<?php

namespace App\Traits;

use App\Contracts\BaseSkuPartGenerator;
use Illuminate\Support\Str;

trait SkuDefaultGenerators
{

    /**
     * Generates a 4 letter word based on the variant ID.
     * @return string
     */
    protected function defaultVariantId()
    {
        $variantId = $this->record->id ?? null;

        return Str::padLeft($variantId, 4, "0");
    }

    /**
     * Generates a 4 letter word based on the variant name.
     * @return string
     */
    protected function defaultVariantName(): string
    {
        $name = $this->record->name;

        return BaseSkuPartGenerator::getLetters($name);
    }

    /**
     * Generates a 4 letter word based on brand name  or returns a random string
     * 
     * @return string|null
     */
    protected function defaultBrand()
    {
        $brand = $this->record?->product->brand ?? null;

        if (empty($brand)) return Str::upper(Str::random(3));

        return BaseSkuPartGenerator::getLetters($brand);
    }

    /**
     * Generates a 4 letter word based on the product.
     * @return string
     */
    protected function defaultProductName()
    {
        $productName = $this->record?->product->name ?? null;

        return BaseSkuPartGenerator::getLetters($productName);
    }
}

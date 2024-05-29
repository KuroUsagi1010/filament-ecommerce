<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait SkuDefaultGenerators
{
    /**
     * Generates a 4 letter word based on the variant name.
     * @return string
     */
    protected function defaultVariantName(): string
    {
        $name = $this->record['name'];
        return $this->getLetters($name);
    }

    /**
     * Generates a 4 letter word based on brand name  or returns a random string
     * 
     * @return string|null
     */
    protected function defaultBrand()
    {
        $brand = $this->record['product']['brand'] ?? null;

        if (empty($brand)) return Str::random(3);

        return $this->getLetters($brand);
    }


    /**
     * Generates a 4 letter word based on the product.
     * @return string
     */
    protected function defaultProductName()
    {
        $productName = $this->record['product']['name'] ?? null;

        return $this->getLetters($productName);
    }
}

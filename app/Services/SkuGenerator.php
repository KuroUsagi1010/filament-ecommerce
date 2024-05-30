<?php

namespace App\Services;

use App\Contracts\BaseSkuPartGenerator;

class SkuGenerator extends BaseSkuPartGenerator
{
    /**
     * this class generates an SKU based on its default part generators 
     * i.e defaultBrand, defaultProductName, defaultVariantName
     * you may add additional sku part generators by creating protected functions.
     * function names must start with "from" in order to be registered as part generator 
     * ex: fromProductColor
     * 
     * you may call the clear method if you dont want other generators when you pass
     * your own callbacks
     */

    protected function fromSomethingElse()
    {
        // a test to see that this generator gets called
        info("SKU Generator: fromSomethingElse(): Called");
        return "";
    }
}
